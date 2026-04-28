<?php

namespace GoDaddy\WordPress\MWC\Core\Auth\API\Controllers\OAuth;

use Exception;
use GoDaddy\WordPress\MWC\Common\API\Controllers\AbstractController;
use GoDaddy\WordPress\MWC\Common\Components\Contracts\ComponentContract;
use GoDaddy\WordPress\MWC\Core\Auth\Providers\GoDaddy\Contracts\ThreeLeggedOAuthTokenProviderContract;
use GoDaddy\WordPress\MWC\Core\Features\ConnectedCommerce\Admin\GoDaddyStorePage;
use WP_Error;
use WP_REST_Response;

/**
 * REST controller for three-legged OAuth tokens.
 */
class TokenController extends AbstractController implements ComponentContract
{
    /** @var string */
    protected $route = 'oauth/token';

    protected ThreeLeggedOAuthTokenProviderContract $authProvider;

    /**
     * Constructor.
     */
    public function __construct(ThreeLeggedOAuthTokenProviderContract $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    /**
     * Initializes the controller.
     */
    public function load() : void
    {
        $this->registerRoutes();
    }

    /**
     * Registers the API routes for the endpoints provided by the controller.
     */
    public function registerRoutes()
    {
        register_rest_route($this->namespace, "/{$this->route}", [
            [
                'methods'             => 'POST',
                'callback'            => [$this, 'createItem'],
                'permission_callback' => [$this, 'createItemPermissionsCheck'],
            ],
        ]);
    }

    /**
     * Retrieves the three-legged OAuth token.
     *
     * @return WP_REST_Response|WP_Error
     */
    public function createItem()
    {
        try {
            $response = $this->authProvider->getCredentials()->toArray();
        } catch (Exception $exception) {
            $response = new WP_Error($exception->getCode() ?: 500, $exception->getMessage(), [
                'status' => $exception->getCode() ?: 500,
            ]);
        }

        return rest_ensure_response($response);
    }

    /**
     * Determines if the current user has permissions to issue requests to create items.
     *
     * @return bool
     */
    public function createItemPermissionsCheck() : bool
    {
        return current_user_can(GoDaddyStorePage::CAPABILITY);
    }

    /**
     * Gets the item schema.
     *
     * @return array<string, mixed>
     */
    public function getItemSchema() : array
    {
        return [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'oauth-token',
            'type'       => 'object',
            'properties' => [
                'accessToken' => [
                    'description' => __('The access token string as issued by the authorization server.', 'mwc-core'),
                    'type'        => 'string',
                    'context'     => ['view'],
                    'readonly'    => true,
                ],
                'expiresIn' => [
                    'description' => __('Number of seconds to expiration of the access token.', 'mwc-core'),
                    'type'        => 'integer',
                    'context'     => ['view'],
                    'readonly'    => true,
                ],
                'scope' => [
                    'description' => __('The scope the token granted.', 'mwc-core'),
                    'type'        => 'string',
                    'context'     => ['view'],
                    'readonly'    => true,
                ],
                'tokenType' => [
                    'description' => __('The type of token this is.', 'mwc-core'),
                    'type'        => 'string',
                    'context'     => ['view'],
                    'readonly'    => true,
                ],
            ],
        ];
    }
}
