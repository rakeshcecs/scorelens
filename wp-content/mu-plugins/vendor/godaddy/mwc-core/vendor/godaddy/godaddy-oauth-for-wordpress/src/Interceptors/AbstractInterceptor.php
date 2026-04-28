<?php

namespace GoDaddy\WordPress\OAuth\Interceptors;

/**
 * Abstract base class for interceptors.
 *
 * Interceptors hook into WordPress actions and filters to intercept
 * and handle specific requests. This mirrors the pattern from mwc-common.
 */
abstract class AbstractInterceptor
{
    /**
     * Load the interceptor.
     *
     * Registers WordPress hooks via addHooks().
     *
     * @return void
     */
    public function load() : void
    {
        if (static::shouldLoad()) {
            $this->addHooks();
        }
    }

    /**
     * Determine if the interceptor should load.
     *
     * Override this method in concrete implementations to conditionally
     * load the interceptor based on environment or configuration.
     *
     * @return bool True to load, false to skip.
     */
    public static function shouldLoad() : bool
    {
        return true;
    }

    /**
     * Register WordPress hooks.
     *
     * Concrete interceptors must implement this to register their
     * specific actions and filters.
     *
     * @return void
     */
    abstract public function addHooks() : void;
}
