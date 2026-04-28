<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Services;

use GoDaddy\WordPress\MWC\Common\Exceptions\AdapterException;
use GoDaddy\WordPress\MWC\Common\Models\Term;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Operations\Contracts\CreateOrUpdateCategoryOperationContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Operations\Contracts\ListCategoriesOperationContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Operations\Contracts\ReadCategoryOperationContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Services\Contracts\CategoriesServiceContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Services\Responses\Contracts\CreateOrUpdateCategoryResponseContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Services\Responses\Contracts\ListCategoriesResponseContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Services\Responses\Contracts\ReadCategoryResponseContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Services\Responses\CreateOrUpdateCategoryResponse;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\CommerceException;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\Contracts\CommerceExceptionContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\GatewayRequestException;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\MissingCategoryLocalIdException;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\MissingCategoryRemoteIdException;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Models\Contracts\CommerceContextContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\Contracts\CatalogProviderContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ListObject;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ListRequestInputs\CreateListInput;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ListRequestInputs\QueryListsInput;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataObjects\ListRequestInputs\UpdateListInput;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Providers\DataSources\Adapters\ListAdapter;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\V2\Catalog\Services\Contracts\ListsMappingServiceContract;

/**
 * Handles communication between Managed WooCommerce and the Commerce Catalog v2 API for category ("List") CRUD operations.
 */
class CategoriesService implements CategoriesServiceContract
{
    /** context of the current site - contains the store ID */
    protected CommerceContextContract $commerceContext;

    /** provider to the external API's CRUD operations */
    protected CatalogProviderContract $catalogProvider;

    /** service that handles mapping local entities to their remote equivalents */
    protected ListsMappingServiceContract $listsMappingService;

    protected ListAdapter $listAdapter;

    public function __construct(
        CommerceContextContract $commerceContext,
        CatalogProviderContract $catalogProvider,
        ListsMappingServiceContract $listsMappingService,
        ListAdapter $listAdapter
    ) {
        $this->commerceContext = $commerceContext;
        $this->catalogProvider = $catalogProvider;
        $this->listsMappingService = $listsMappingService;
        $this->listAdapter = $listAdapter;
    }

    /**
     * Creates or updates a category.
     *
     * @param CreateOrUpdateCategoryOperationContract $operation
     * @return CreateOrUpdateCategoryResponseContract
     * @throws MissingCategoryLocalIdException|GatewayRequestException|CommerceExceptionContract|AdapterException
     */
    public function createOrUpdateCategory(CreateOrUpdateCategoryOperationContract $operation) : CreateOrUpdateCategoryResponseContract
    {
        $category = $operation->getCategory();
        $localId = $category->getId();

        if (! $localId) {
            throw new MissingCategoryLocalIdException('Cannot create a category without a local ID.');
        }

        if ($remoteId = $this->listsMappingService->getRemoteId($category)) {
            return $this->updateCategory($operation, $remoteId);
        } else {
            return $this->createCategory($operation);
        }
    }

    /**
     * Creates a category in the remote platform.
     *
     * @param CreateOrUpdateCategoryOperationContract $operation
     * @return CreateOrUpdateCategoryResponseContract
     * @throws MissingCategoryRemoteIdException|GatewayRequestException|CommerceExceptionContract|AdapterException
     */
    public function createCategory(CreateOrUpdateCategoryOperationContract $operation) : CreateOrUpdateCategoryResponseContract
    {
        $list = $this->catalogProvider
            ->lists()
            ->create($this->getCreateListInput($operation));

        if (empty($list->id)) {
            throw MissingCategoryRemoteIdException::withDefaultMessage();
        }

        $this->listsMappingService->saveRemoteId($operation->getCategory(), $list->id);

        // @TODO hierarchy handling would go here, after the list exists remotely

        return CreateOrUpdateCategoryResponse::getNewInstance($list->id);
    }

    /**
     * Prepares the input for creating a category in the remote API.
     *
     * @param CreateOrUpdateCategoryOperationContract $operation
     * @return CreateListInput
     * @throws AdapterException
     */
    protected function getCreateListInput(CreateOrUpdateCategoryOperationContract $operation) : CreateListInput
    {
        $list = $this->adaptCategoryForRemoteOperation($operation->getCategory());

        return CreateListInput::getNewInstance([
            'list'    => $list,
            'storeId' => $this->commerceContext->getStoreId(),
        ]);
    }

    /**
     * Updates a category.
     *
     * @param CreateOrUpdateCategoryOperationContract $operation
     * @param string $remoteId
     * @return CreateOrUpdateCategoryResponseContract
     * @throws MissingCategoryRemoteIdException|GatewayRequestException|CommerceExceptionContract|AdapterException
     */
    public function updateCategory(CreateOrUpdateCategoryOperationContract $operation, string $remoteId) : CreateOrUpdateCategoryResponseContract
    {
        $list = $this->catalogProvider
            ->lists()
            ->update($this->getUpdateListInput($operation, $remoteId));

        if (empty($list->id)) {
            throw MissingCategoryRemoteIdException::withDefaultMessage();
        }

        // @TODO hierarchy handling would go here, after the list exists remotely

        return CreateOrUpdateCategoryResponse::getNewInstance($list->id);
    }

    /**
     * Prepares the input for updating a category in the remote API.
     *
     * @param CreateOrUpdateCategoryOperationContract $operation
     * @param string $remoteId
     * @return UpdateListInput
     * @throws AdapterException
     */
    protected function getUpdateListInput(CreateOrUpdateCategoryOperationContract $operation, string $remoteId) : UpdateListInput
    {
        $list = $this->adaptCategoryForRemoteOperation($operation->getCategory());
        $list->id = $remoteId; // Set the remote ID for the update operation

        return UpdateListInput::getNewInstance([
            'list'    => $list,
            'storeId' => $this->commerceContext->getStoreId(),
        ]);
    }

    /**
     * Reads a category from the remote platform.
     *
     * @param ReadCategoryOperationContract $operation
     * @return ReadCategoryResponseContract
     * @throws CommerceExceptionContract
     */
    public function readCategory(ReadCategoryOperationContract $operation) : ReadCategoryResponseContract
    {
        // TODO: Implement readCategory() method.
        throw new CommerceException('Reading categories is not yet implemented.');
    }

    /**
     * Lists categories from the remote platform.
     *
     * @param ListCategoriesOperationContract $operation
     * @return ListCategoriesResponseContract
     * @throws CommerceExceptionContract
     */
    public function listCategories(ListCategoriesOperationContract $operation) : ListCategoriesResponseContract
    {
        return $this->catalogProvider->lists()->query(
            $this->getQueryListsInput($operation)
        );
    }

    protected function getQueryListsInput(ListCategoriesOperationContract $operation) : QueryListsInput
    {
        return QueryListsInput::getNewInstance([
            'name'    => $operation->getAltId(),
            'storeId' => $this->commerceContext->getStoreId(),
        ]);
    }

    /**
     * Converts a local {@see Term} to a remote {@see ListObject} for the API.
     *
     * @param Term $localCategory
     * @return ListObject
     * @throws AdapterException
     */
    protected function adaptCategoryForRemoteOperation(Term $localCategory) : ListObject
    {
        return $this->listAdapter->convertToSource($localCategory);
    }
}
