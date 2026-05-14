<?php

namespace Wptool\adminDash\controllers;

use Wptool\adminDash\constants\ErrorCodes;
use Wptool\adminDash\exceptions\GlobalInfoV2RequestFailedException;
use Wptool\adminDash\services\GlobalInfoV2Service;
use Wptool\adminDash\services\container\ServiceContainer;

/**
 * REST controller grouping all WP-admin routes that proxy to the upstream
 * /api/v1/admindash/* endpoints.
 *
 * Add a new `register_rest_route()` entry here for each new upstream
 * admindash/* endpoint we surface to the front-end.
 */
class GlobalInfoV2Controller extends BaseController {

	/** @var GlobalInfoV2Service */
	private $global_info_v2_service;

	/**
	 * @param ServiceContainer $container
	 */
	public function __construct( $container ) {
		parent::__construct( $container );
		$this->global_info_v2_service = $this->container->get( 'global_info_v2_service' );
	}

	/**
	 * Register routes for /api/v1/admindash/* proxies.
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'plan-details',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'plan_details' ),
					'args'                => array(),
					'permission_callback' => array( $this, 'is_authenticated' ),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			'plan-storage',
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'plan_storage' ),
					'args'                => array(),
					'permission_callback' => array( $this, 'is_authenticated' ),
				),
			)
		);
	}

	/**
	 * GET hosting-admin/plan-details
	 *
	 * @return \WP_REST_Response
	 */
	public function plan_details() {
		return $this->run(
			function ( $account_uid ) {
				return $this->global_info_v2_service->get_plan_details( $account_uid );
			},
			'Failed to fetch plan details.'
		);
	}

	/**
	 * GET hosting-admin/plan-storage
	 *
	 * @return \WP_REST_Response
	 */
	public function plan_storage() {
		return $this->run(
			function ( $account_uid ) {
				return $this->global_info_v2_service->get_plan_storage( $account_uid );
			},
			'Failed to fetch plan storage.'
		);
	}

	/**
	 * Shared flow: resolve account UID, invoke the fetcher, surface upstream
	 * status+message on failure.
	 *
	 * @param callable $fetcher          Takes $account_uid, returns array payload.
	 * @param string   $fallback_message Message to use when upstream provides none.
	 * @return \WP_REST_Response
	 */
	private function run( callable $fetcher, $fallback_message ) {
		$account_uid = defined( 'GD_ACCOUNT_UID' ) ? GD_ACCOUNT_UID : null;

		if ( empty( $account_uid ) ) {
			return new \WP_REST_Response(
				array(
					'code'    => ErrorCodes::WRONG_PARAMETER,
					'message' => 'Missing account identifier.',
				),
				400
			);
		}

		try {
			$data = $fetcher( $account_uid );

			return new \WP_REST_Response(
				array( 'data' => $data ),
				200
			);
		} catch ( GlobalInfoV2RequestFailedException $e ) {
			$upstream_status = $e->get_status();
			$upstream_code   = $e->get_upstream_code();
			$message         = $e->getMessage() !== '' ? $e->getMessage() : $fallback_message;

			return new \WP_REST_Response(
				array(
					'code'    => $upstream_code ? $upstream_code : ErrorCodes::UNABLE_TO_PERFORM_OPERATION,
					'status'  => $upstream_status,
					'message' => $message,
				),
				self::map_upstream_status( $upstream_status )
			);
		} catch ( \Exception $e ) {
			return new \WP_REST_Response(
				array(
					'code'    => ErrorCodes::SERVER_ERROR,
					'message' => $fallback_message,
				),
				500
			);
		}
	}

	/**
	 * Map upstream status to the status we return to the browser.
	 * Preserves 4xx semantics (400/403/404/422) and normalizes anything else to 500.
	 *
	 * @param int $status
	 * @return int
	 */
	private static function map_upstream_status( $status ) {
		$passthrough = array( 400, 403, 404, 422 );
		if ( in_array( (int) $status, $passthrough, true ) ) {
			return (int) $status;
		}
		return 500;
	}
}
