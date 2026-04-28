<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\GoDaddy;

use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\Contracts\CatalogProviderContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\Contracts\ListsGatewayContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\Contracts\SkuGroupsGatewayContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\Contracts\SkusGatewayContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\GoDaddy\Gateways\ListsGateway;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\GoDaddy\Gateways\SkuGroupsGateway;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\GoDaddy\Gateways\SkusGateway;

/**
 * GoDaddy V2 Catalog provider.
 */
class CatalogProvider implements CatalogProviderContract
{
    protected ListsGatewayContract $listsGateway;
    protected SkuGroupsGatewayContract $skuGroupsGateway;
    protected SkusGatewayContract $skusGateway;

    public function __construct(
        ListsGatewayContract $listsGateway,
        SkuGroupsGatewayContract $skuGroupsGateway,
        SkusGatewayContract $skusGateway
    ) {
        $this->listsGateway = $listsGateway;
        $this->skuGroupsGateway = $skuGroupsGateway;
        $this->skusGateway = $skusGateway;
    }

    /**
     * Returns the {@see ListsGateway} handler.
     *
     * @return ListsGatewayContract
     */
    public function lists() : ListsGatewayContract
    {
        return $this->listsGateway;
    }

    /**
     * Returns the {@see SkuGroupsGateway} handler.
     *
     * @return SkuGroupsGatewayContract
     */
    public function skuGroups() : SkuGroupsGatewayContract
    {
        return $this->skuGroupsGateway;
    }

    /**
     * Returns the {@see SkusGateway} handler.
     *
     * @return SkusGatewayContract
     */
    public function skus() : SkusGatewayContract
    {
        return $this->skusGateway;
    }
}
