<?php

namespace GoDaddy\WordPress\OAuth\Services;

use Exception;
use GoDaddy\WordPress\OAuth\Client\Exceptions\HttpException;
use GoDaddy\WordPress\OAuth\Client\Exceptions\SessionExpiredException;
use GoDaddy\WordPress\OAuth\Client\Exceptions\TokenRefreshException;
use GoDaddy\WordPress\OAuth\Client\Models\AccessToken;
use GoDaddy\WordPress\OAuth\Client\OAuthClient;
use GoDaddy\WordPress\OAuth\Storage\Contracts\TokenRepositoryContract;

/**
 * Service for accessing valid OAuth tokens.
 *
 * Provides automatic refresh when tokens are expired.
 * This is the primary API for consumers needing authenticated access.
 *
 * Uses an atomic wp_options lock to prevent race conditions with background refresh.
 * If lock is held, fails immediately - consumer can retry.
 */
class TokenService
{
    /** @var string Option key for refresh lock (shared with handler) */
    public const LOCK_KEY = 'gd_oauth_refresh_lock';

    /** @var int Lock TTL in seconds */
    public const LOCK_TTL = 30;

    /** @var OAuthClient */
    private OAuthClient $oauthClient;

    /** @var TokenRepositoryContract */
    private TokenRepositoryContract $tokenRepository;

    public function __construct(
        OAuthClient $oauthClient,
        TokenRepositoryContract $tokenRepository
    ) {
        $this->oauthClient = $oauthClient;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Get a valid (non-expired) access token.
     *
     * If the stored token is expired, attempts to refresh it.
     * Throws TokenRefreshException if no token exists or refresh fails.
     *
     * @return AccessToken
     * @throws TokenRefreshException When no token available or refresh fails
     */
    public function getValidToken() : AccessToken
    {
        $token = $this->tokenRepository->get();

        if ($token === null) {
            throw new TokenRefreshException('No token available. Please connect first.');
        }

        if (! $token->hasExpired()) {
            return $token;
        }

        // Try to acquire lock - fail immediately if held
        if (! $this->acquireLock()) {
            throw new TokenRefreshException('Could not refresh token. Please try again.');
        }

        try {
            return $this->refreshToken($token);
        } finally {
            $this->releaseLock();
        }
    }

    /**
     * Force-refresh the stored token regardless of expiry.
     *
     * Used by background refresh to proactively refresh tokens before they expire.
     * Throws TokenRefreshException if no token exists, lock cannot be acquired, or refresh fails.
     *
     * @return AccessToken
     * @throws TokenRefreshException When no token available, lock held, or refresh fails
     */
    public function forceRefresh() : AccessToken
    {
        $token = $this->tokenRepository->get();

        if ($token === null) {
            throw new TokenRefreshException('No token available. Please connect first.');
        }

        if (! $this->acquireLock()) {
            throw new TokenRefreshException('Could not refresh token. Please try again.');
        }

        try {
            return $this->refreshToken($token);
        } finally {
            $this->releaseLock();
        }
    }

    /**
     * Disconnect by revoking the server token (best effort) and deleting local storage.
     *
     * @return void
     */
    public function disconnect() : void
    {
        $token = $this->tokenRepository->get();

        if ($token !== null) {
            $this->revokeTokenSilently($token->getRefreshToken());
        }

        $this->tokenRepository->delete();
    }

    /**
     * Refresh the token using the refresh token.
     *
     * @param AccessToken $token The expired token containing the refresh token
     * @return AccessToken The new token
     * @throws TokenRefreshException When refresh fails
     */
    protected function refreshToken(AccessToken $token) : AccessToken
    {
        try {
            $newToken = $this->oauthClient->refreshAccessToken(
                $token->getRefreshToken()
            );

            $this->tokenRepository->save($newToken);

            return $newToken;
        } catch (HttpException $e) {
            // Permanent failure - refresh token is invalid/expired/revoked
            // Extend this list if other permanent error codes are identified
            if (in_array($e->getErrorCode(), ['invalid_grant', 'invalid_token'], true)) {
                $this->tokenRepository->delete();
                throw new SessionExpiredException(
                    'Session expired. Please reconnect.',
                    $e
                );
            }

            // Temporary failure - keep tokens, let caller retry
            throw new TokenRefreshException(
                'Could not refresh token. Please try again.',
                $e
            );
        } catch (Exception $e) {
            // Other errors (InvalidUrlException, InvalidMethodException, etc.) - temporary, keep tokens
            throw new TokenRefreshException(
                'Could not reach authentication server. Please try again.',
                $e
            );
        }
    }

    /**
     * Attempt to revoke token on server, silently catching any errors.
     *
     * @param string $refreshToken The refresh token to revoke
     * @return void
     */
    protected function revokeTokenSilently(string $refreshToken) : void
    {
        try {
            $this->oauthClient->revokeToken($refreshToken);
        } catch (Exception $e) {
            // Silent failure - local deletion still happens
        }
    }

    /**
     * Try to acquire the refresh lock.
     *
     * Uses add_option() for atomic insert-or-fail semantics.
     * Falls back to stale lock recovery if the lock exists but has exceeded its TTL.
     *
     * @return bool True if lock acquired, false if already locked
     */
    protected function acquireLock() : bool
    {
        // Atomic: returns false if option already exists
        if (add_option(self::LOCK_KEY, time())) {
            return true;
        }

        // Lock exists - check if stale
        $lockTime = get_option(self::LOCK_KEY);

        if (is_numeric($lockTime) && (time() - (int) $lockTime) >= self::LOCK_TTL) {
            delete_option(self::LOCK_KEY);

            return (bool) add_option(self::LOCK_KEY, time());
        }

        return false;
    }

    /**
     * Release the refresh lock.
     *
     * @return void
     */
    protected function releaseLock() : void
    {
        delete_option(self::LOCK_KEY);
    }
}
