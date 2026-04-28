<?php

namespace GoDaddy\WordPress\MWC\Core\Auth\Interceptors;

use Exception;
use GoDaddy\WordPress\MWC\Common\Interceptors\AbstractInterceptor;
use GoDaddy\WordPress\MWC\Common\Register\Register;
use GoDaddy\WordPress\MWC\Core\Auth\Interceptors\Handlers\UnschedulePlatformTokenRefreshHandler;

/**
 * Cleans up the orphaned mwc_gd_platform_token_refresh recurring action from Action Scheduler.
 *
 * @todo Remove this interceptor after the orphaned job has been cleaned up: https://godaddy-corp.atlassian.net/browse/MWC-19559.
 */
class UnschedulePlatformTokenRefreshInterceptor extends AbstractInterceptor
{
    public const JOB_NAME = 'mwc_gd_platform_token_refresh';

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public function addHooks() : void
    {
        Register::action()
            ->setGroup('shutdown')
            ->setHandler([UnschedulePlatformTokenRefreshHandler::class, 'handle'])
            ->execute();
    }
}
