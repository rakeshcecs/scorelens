<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\EligibleApiVersion\Http;

use GoDaddy\WordPress\MWC\Common\Helpers\TypeHelper;
use GoDaddy\WordPress\MWC\Common\Traits\CanGetEnvironmentBasedConfigValueTrait;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Providers\Http\Requests\AbstractRequest;

class Request extends AbstractRequest
{
    use CanGetEnvironmentBasedConfigValueTrait;

    /** {@inheritDoc} */
    protected function getBaseUrl() : string
    {
        $apiUrl = $this->getEnvironmentConfigValue('commerce.catalog.api.url');

        return TypeHelper::string($apiUrl, '');
    }

    /** {@inheritDoc} */
    protected function getPathPrefix() : string
    {
        return "/v1/commerce/proxy/catalog/internal/stores/{$this->storeId}/eligibleVersion";
    }
}
