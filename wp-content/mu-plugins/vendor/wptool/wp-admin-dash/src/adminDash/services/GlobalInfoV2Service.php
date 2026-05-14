<?php

namespace Wptool\adminDash\services;

use Wptool\adminDash\exceptions\GlobalInfoV2RequestFailedException;
use Wptool\adminDash\utils\Configuration;
use WPaaS\Plugin;

/**
 * Client for the upstream /api/v1/admindash/* endpoints.
 *
 * All methods here share the same WP-signed auth flow (X-WP-Nonce,
 * X-WP-Origin, X-WP-Signature, X-WP-Bodyhash) via Plugin::sign_http_request(),
 * and cache results in WP transients to protect the rate-sensitive upstream.
 *
 * To add a new /admindash/<foo> endpoint:
 *   1. add a `CACHE_PREFIX_FOO` + `CACHE_TTL_FOO` constant,
 *   2. add a `get_foo()` method that delegates to `self::get_cached_or_fetch()`
 *      + `self::request('/admindash/foo/' . rawurlencode(...))`.
 */
class GlobalInfoV2Service {

	/**
	 * Transient TTL for /admindash/plan-details (seconds).
	 * Plan metadata is stable — cache longer.
	 */
	const PLAN_DETAILS_CACHE_TTL = 5 * MINUTE_IN_SECONDS;

	/**
	 * Transient TTL for /admindash/plan-storage (seconds).
	 * Storage numbers drift — cache shorter.
	 */
	const PLAN_STORAGE_CACHE_TTL = 2 * MINUTE_IN_SECONDS;

	const PLAN_DETAILS_CACHE_PREFIX = 'wptool_ad_plan_details_';
	const PLAN_STORAGE_CACHE_PREFIX = 'wptool_ad_plan_storage_';

	/**
	 * Request timeout for upstream calls (seconds).
	 */
	const REQUEST_TIMEOUT = 15;

	/**
	 * @var string
	 */
	private $api_url;

	public function __construct() {
		$this->api_url = Configuration::get( 'public_api_url' );
	}

	/**
	 * Fetch plan-details for the given account.
	 *
	 * Upstream: GET {public_api_url}/admindash/plan-details/{accountUid}
	 *
	 * Returned as-is (UI-ready) as an associative array:
	 *   planName, accountStatus, expireDate, sites{…}, visitors{…},
	 *   features{…}, datacenter{…}
	 *
	 * @param string $account_uid
	 * @return array
	 * @throws GlobalInfoV2RequestFailedException
	 */
	public function get_plan_details( $account_uid ) {
		return $this->get_cached_or_fetch(
			self::PLAN_DETAILS_CACHE_PREFIX . md5( (string) $account_uid ),
			self::PLAN_DETAILS_CACHE_TTL,
			function () use ( $account_uid ) {
				return $this->request( '/admindash/plan-details/' . rawurlencode( (string) $account_uid ) );
			}
		);
	}

	/**
	 * Fetch plan-storage for the given account.
	 *
	 * Upstream: GET {public_api_url}/admindash/plan-storage/{accountUid}
	 *
	 * Returned as-is (UI-ready) as an associative array:
	 *   planName, storage{…}, sites{…}, softLimitReached, hardLimitReached,
	 *   siteBreakdown[], lastRefreshed
	 *
	 * All storage values are in bytes (see `storage.unit`).
	 *
	 * @param string $account_uid
	 * @return array
	 * @throws GlobalInfoV2RequestFailedException
	 */
	public function get_plan_storage( $account_uid ) {
		return $this->get_cached_or_fetch(
			self::PLAN_STORAGE_CACHE_PREFIX . md5( (string) $account_uid ),
			self::PLAN_STORAGE_CACHE_TTL,
			function () use ( $account_uid ) {
				return $this->request( '/admindash/plan-storage/' . rawurlencode( (string) $account_uid ) );
			}
		);
	}

	/**
	 * Invalidate cached admindash data for the given account (e.g. after a
	 * plan change or storage-touching event).
	 *
	 * @param string $account_uid
	 * @return void
	 */
	public function flush_cache( $account_uid ) {
		$hash = md5( (string) $account_uid );
		delete_transient( self::PLAN_DETAILS_CACHE_PREFIX . $hash );
		delete_transient( self::PLAN_STORAGE_CACHE_PREFIX . $hash );
	}

	/**
	 * Returns cached payload if present, otherwise runs $fetcher, caches, and returns.
	 *
	 * @param string   $cache_key
	 * @param int      $ttl_seconds
	 * @param callable $fetcher
	 * @return array
	 */
	private function get_cached_or_fetch( $cache_key, $ttl_seconds, callable $fetcher ) {
		$cached = get_transient( $cache_key );
		if ( false !== $cached && is_array( $cached ) ) {
			return $cached;
		}

		$fresh = $fetcher();

		set_transient( $cache_key, $fresh, $ttl_seconds );

		return $fresh;
	}

	/**
	 * Perform a signed GET against the upstream public API.
	 *
	 * @param string $path Path relative to $this->api_url (must start with '/').
	 * @return array Decoded JSON body as associative array.
	 * @throws GlobalInfoV2RequestFailedException
	 */
	private function request( $path ) {
		$response = wp_remote_get(
			$this->api_url . $path,
			array(
				'timeout' => self::REQUEST_TIMEOUT,
				'headers' => Plugin::sign_http_request( wp_json_encode( array() ) ),
			)
		);

		if ( is_wp_error( $response ) ) {
			throw new GlobalInfoV2RequestFailedException( $response->get_error_message(), 0 );
		}

		$status = (int) wp_remote_retrieve_response_code( $response );
		$body   = wp_remote_retrieve_body( $response );
		$parsed = is_string( $body ) && '' !== $body ? json_decode( $body, true ) : null;

		if ( 200 !== $status ) {
			$message       = is_array( $parsed ) && isset( $parsed['message'] ) ? (string) $parsed['message'] : 'Upstream request failed.';
			$upstream_code = null;
			if ( is_array( $parsed ) ) {
				if ( isset( $parsed['status'] ) && is_string( $parsed['status'] ) ) {
					$upstream_code = $parsed['status'];
				} elseif ( isset( $parsed['code'] ) && is_string( $parsed['code'] ) ) {
					$upstream_code = $parsed['code'];
				}
			}
			throw new GlobalInfoV2RequestFailedException( $message, $status, $upstream_code );
		}

		if ( ! is_array( $parsed ) ) {
			throw new GlobalInfoV2RequestFailedException( 'Malformed upstream response.', $status );
		}

		return $parsed;
	}
}
