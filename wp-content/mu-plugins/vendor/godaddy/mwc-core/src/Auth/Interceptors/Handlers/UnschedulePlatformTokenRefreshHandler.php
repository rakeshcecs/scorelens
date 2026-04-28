<?php

namespace GoDaddy\WordPress\MWC\Core\Auth\Interceptors\Handlers;

use DateInterval;
use DateTime;
use Exception;
use GoDaddy\WordPress\MWC\Common\Exceptions\SentryException;
use GoDaddy\WordPress\MWC\Common\Interceptors\Handlers\AbstractInterceptorHandler;
use GoDaddy\WordPress\MWC\Common\Schedule\Schedule;
use GoDaddy\WordPress\MWC\Core\Auth\Interceptors\UnschedulePlatformTokenRefreshInterceptor;

/**
 * Unschedules the orphaned platform token refresh recurring action.
 */
class UnschedulePlatformTokenRefreshHandler extends AbstractInterceptorHandler
{
    /**
     * {@inheritDoc}
     */
    public function run(...$args) : void
    {
        try {
            Schedule::recurringAction()
                ->setName(UnschedulePlatformTokenRefreshInterceptor::JOB_NAME)
                ->setScheduleAt(new DateTime('now'))
                ->setInterval(new DateInterval('PT1M'))
                ->unschedule(true);
        } catch (Exception $exception) {
            SentryException::getNewInstance('Failed to unschedule platform token refresh job.', $exception);
        }
    }
}
