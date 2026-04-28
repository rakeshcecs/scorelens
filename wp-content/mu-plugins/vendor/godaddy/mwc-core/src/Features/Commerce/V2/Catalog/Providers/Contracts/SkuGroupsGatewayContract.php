<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\Contracts;

use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\Contracts\CommerceExceptionContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ProductRequestInputs\CreateSkuGroupInput;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ProductRequestInputs\GetSkuGroupInput;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ProductRequestInputs\UpdateSkuGroupInput;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ProductRequestInputs\UpdateSkuGroupRelationshipsInput;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ProductRequestOutputs\SkuGroupRequestOutput;

/**
 * Contract for SKU groups gateways.
 */
interface SkuGroupsGatewayContract
{
    /**
     * Creates a SKU group.
     *
     * @param CreateSkuGroupInput $input
     * @return SkuGroupRequestOutput
     * @throws CommerceExceptionContract
     */
    public function create(CreateSkuGroupInput $input) : SkuGroupRequestOutput;

    /**
     * Updates a SKU group.
     *
     * @param UpdateSkuGroupInput $input
     * @return SkuGroupRequestOutput
     * @throws CommerceExceptionContract
     */
    public function update(UpdateSkuGroupInput $input) : SkuGroupRequestOutput;

    /**
     * Updates SKU group relationships.
     *
     * @param UpdateSkuGroupRelationshipsInput $input
     * @throws CommerceExceptionContract
     */
    public function updateRelationships(UpdateSkuGroupRelationshipsInput $input) : void;

    /**
     * Gets a SKU Group.
     *
     * @param GetSkuGroupInput $input
     * @return SkuGroupRequestOutput
     * @throws CommerceExceptionContract
     */
    public function get(GetSkuGroupInput $input) : SkuGroupRequestOutput;
}
