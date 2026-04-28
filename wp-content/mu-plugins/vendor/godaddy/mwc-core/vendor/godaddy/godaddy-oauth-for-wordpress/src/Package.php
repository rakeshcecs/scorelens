<?php

namespace GoDaddy\WordPress\OAuth;

use Exception;
use GoDaddy\WordPress\MWC\Common\Container\ContainerFactory;
use GoDaddy\WordPress\MWC\Common\Container\Contracts\ContainerContract;
use GoDaddy\WordPress\MWC\Common\Helpers\TypeHelper;
use GoDaddy\WordPress\OAuth\Admin\ConnectionPage;
use GoDaddy\WordPress\OAuth\Interceptors\AuthorizationInterceptor;
use GoDaddy\WordPress\OAuth\Interceptors\CallbackInterceptor;
use GoDaddy\WordPress\OAuth\Interceptors\DisconnectInterceptor;
use GoDaddy\WordPress\OAuth\Interceptors\TokenRefreshInterceptor;
use GoDaddy\WordPress\OAuth\Providers\OAuthServiceProvider;

/**
 * Main Package class.
 *
 * Singleton pattern ensures only one instance exists even if multiple
 * plugins try to initialize the package.
 */
class Package
{
    /**
     * Package ID.
     */
    const ID = 'godaddy-oauth-for-wordpress';

    /**
     * Package version.
     */
    const VERSION = '1.0.0';

    /**
     * Filter name for controlling whether the package should initialize its functionality.
     */
    const FILTER_SHOULD_INITIALIZE = 'godaddy_oauth_should_initialize';

    /**
     * Single instance of the package.
     *
     * @var Package|null
     */
    private static ?Package $instance = null;

    /**
     * Whether the package has been initialized.
     *
     * @var bool
     */
    private bool $initialized = false;

    /**
     * Get the singleton instance.
     *
     * @return Package
     */
    public static function instance() : Package
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize the package.
     *
     * @return void
     */
    private function initialize() : void
    {
        if ($this->initialized) {
            return;
        }

        $this->initializeContainer();
        $this->addHooks();

        $this->initialized = true;
    }

    /**
     * Initialize the DI container with service providers.
     *
     * @return void
     */
    private function initializeContainer() : void
    {
        $container = $this->getContainer();

        $container->addProvider(new OAuthServiceProvider());
        $container->enableAutoWiring();
    }

    /**
     * Get the shared DI container.
     *
     * @return ContainerContract
     */
    protected function getContainer() : ContainerContract
    {
        return ContainerFactory::getInstance()->getSharedContainer();
    }

    /**
     * Add necessary action and filter hooks.
     *
     * @return void
     */
    protected function addHooks() : void
    {
        // Hook for future functionality
        add_action('init', [$this, 'onInit']);
    }

    /**
     * Handle WordPress init hook.
     *
     * Loads interceptors on every request and admin pages on admin requests,
     * but only when the filter allows initialization.
     *
     * @return void
     * @throws Exception
     */
    public function onInit() : void
    {
        if (! $this->shouldInitialize()) {
            return;
        }

        $this->loadInterceptors();
        $this->loadAdminPages();
    }

    /**
     * Determines whether the package should initialize its functionality.
     *
     * @return bool
     */
    protected function shouldInitialize() : bool
    {
        return TypeHelper::bool(apply_filters(self::FILTER_SHOULD_INITIALIZE, false), false);
    }

    /**
     * Load OAuth interceptors.
     *
     * Interceptors are loaded on every request (frontend and admin)
     * to handle authorization and callback requests.
     *
     * @return void
     * @throws Exception
     */
    protected function loadInterceptors() : void
    {
        $this->getAuthorizationInterceptor()->load();
        $this->getCallbackInterceptor()->load();
        $this->getDisconnectInterceptor()->load();
        $this->getTokenRefreshInterceptor()->load();
    }

    /**
     * Load admin pages.
     *
     * Admin pages are only loaded on admin requests.
     *
     * @return void
     * @throws Exception
     */
    protected function loadAdminPages() : void
    {
        if (! is_admin()) {
            return;
        }

        $this->getConnectionPage()->load();
    }

    /**
     * Get authorization interceptor instance.
     *
     * @return AuthorizationInterceptor
     * @throws Exception
     */
    protected function getAuthorizationInterceptor() : AuthorizationInterceptor
    {
        return $this->getContainer()->get(AuthorizationInterceptor::class);
    }

    /**
     * Get callback interceptor instance.
     *
     * @return CallbackInterceptor
     * @throws Exception
     */
    protected function getCallbackInterceptor() : CallbackInterceptor
    {
        return $this->getContainer()->get(CallbackInterceptor::class);
    }

    /**
     * Get disconnect interceptor instance.
     *
     * @return DisconnectInterceptor
     * @throws Exception
     */
    protected function getDisconnectInterceptor() : DisconnectInterceptor
    {
        return $this->getContainer()->get(DisconnectInterceptor::class);
    }

    /**
     * Get token refresh interceptor instance.
     *
     * @return TokenRefreshInterceptor
     * @throws Exception
     */
    protected function getTokenRefreshInterceptor() : TokenRefreshInterceptor
    {
        return $this->getContainer()->get(TokenRefreshInterceptor::class);
    }

    /**
     * Get connection page instance.
     *
     * @return ConnectionPage
     * @throws Exception
     */
    protected function getConnectionPage() : ConnectionPage
    {
        return $this->getContainer()->get(ConnectionPage::class);
    }

    /**
     * Get package version.
     *
     * @return string
     */
    public function getVersion() : string
    {
        return self::VERSION;
    }

    /**
     * Get package path.
     *
     * @return string
     */
    public static function getPackagePath() : string
    {
        return untrailingslashit(__DIR__);
    }

    /**
     * Get package URL.
     *
     * @return string
     */
    public static function getPackageUrl() : string
    {
        return untrailingslashit(plugins_url('', __FILE__));
    }

    /**
     * Check if package is initialized.
     *
     * @return bool
     */
    public function isInitialized() : bool
    {
        return $this->initialized;
    }
}
