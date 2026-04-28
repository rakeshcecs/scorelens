<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Inventory\Providers\GoDaddy\Http\GraphQL\Queries;

use GoDaddy\WordPress\MWC\Common\Http\GraphQL\AbstractGraphQLOperation;

/**
 * GraphQL operation for querying SKUs with their inventory counts.
 */
class ListInventoryCountsOperation extends AbstractGraphQLOperation
{
    protected $operation = 'query GetSkusWithInventoryCounts($skuIds: [String!]!) {
  skus(id: { in: $skuIds }) {
    edges {
      node {
        id
        code
        backorderLimit
        metafields {
          edges {
            node {
              namespace
              key
              value
              type
            }
          }
        }
        inventoryCounts(first: 100) {
          edges {
            node {
              id
              quantity
              onHand
              type
              createdAt
              updatedAt
              location {
                id
              }
            }
          }
        }
      }
    }
  }
}';
}
