<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Webhooks;

use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\TypeHelper;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Providers\DataObjects\Categories\Category;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Webhooks\Adapters\V2\ListWebhookPayloadAdapter;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Webhooks\Handlers\AbstractWebhookHandler;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\MissingCategoryRemoteIdException;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Mapping\Repositories\ListMapRepository;
use GoDaddy\WordPress\MWC\Core\Webhooks\DataObjects\Webhook;
use GoDaddy\WordPress\MWC\Core\Webhooks\Exceptions\WebhookProcessingException;
use GoDaddy\WordPress\MWC\Core\Webhooks\Repositories\WebhooksRepository;

/**
 * Abstract class for handling webhooks related to Lists.
 */
abstract class AbstractListWebhookHandler extends AbstractWebhookHandler
{
    protected ListMapRepository $listMapRepository;

    public function __construct(ListMapRepository $listMapRepository, WebhooksRepository $webhooksRepository)
    {
        $this->listMapRepository = $listMapRepository;

        parent::__construct($webhooksRepository);
    }

    /** {@inheritDoc} */
    protected function getLocalId(Webhook $webhook) : ?int
    {
        if (! $webhook->remoteResourceId) {
            throw new WebhookProcessingException('List ID not found in webhook data.');
        }

        return $this->getLocalIdFromMapRepository($this->listMapRepository, $webhook->remoteResourceId);
    }

    /**
     * Converts the webhook payload to a Category DTO.
     *
     * @param Webhook $webhook
     * @return Category
     * @throws WebhookProcessingException
     */
    protected function getCategory(Webhook $webhook) : Category
    {
        try {
            return ListWebhookPayloadAdapter::getNewInstance()
                ->convertResponse(TypeHelper::array(ArrayHelper::get(json_decode($webhook->payload, true), 'data'), []));
        } catch (MissingCategoryRemoteIdException $e) {
            throw new WebhookProcessingException($e->getMessage());
        }
    }
}
