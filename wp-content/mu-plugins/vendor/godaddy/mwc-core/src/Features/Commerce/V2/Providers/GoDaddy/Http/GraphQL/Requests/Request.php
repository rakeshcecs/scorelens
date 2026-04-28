<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Providers\GoDaddy\Http\GraphQL\Requests;

use GoDaddy\WordPress\MWC\Core\Features\Commerce\Providers\Http\GraphQL\Requests\AbstractRequest;

/**
 * GraphQL request class for communicating with the Commerce Catalog API v2.
 */
class Request extends AbstractRequest
{
    /**
     * {@inheritDoc}
     */
    protected function getPathPrefix() : string
    {
        if ($this->shouldUseGatewayUrl()) {
            return '/v2/commerce/stores/'.$this->storeId.'/catalog-subgraph';
        }

        return '/v1/commerce/proxy/v2/stores/'.$this->storeId.'/catalog-subgraph';
    }
}
