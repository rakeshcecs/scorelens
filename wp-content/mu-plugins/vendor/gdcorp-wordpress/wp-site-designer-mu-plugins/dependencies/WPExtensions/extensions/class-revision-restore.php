<?php
/**
 * Revision Restore
 *
 * Restores a tracked WordPress post (page, post, wp_navigation, wp_template,
 * or wp_template_part) to the content of a specific revision via
 * wp_restore_post_revision(). Authenticated as a logged-in editor via WP
 * nonce — intended for the native UI Undo flow, not server-to-server traffic.
 *
 * Block templates/parts are addressed by their integer wp_id; the string
 * theme//slug id has no DB row and no revisions.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 */

declare( strict_types=1 );

namespace GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Utils\Rate_Limiter;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * REST endpoint for restoring a post revision (undo).
 */
class Revision_Restore {

	private const ALLOWED_POST_TYPES = array(
		'page',
		'post',
		'wp_navigation',
		'wp_template',
		'wp_template_part',
	);

	/**
	 * Register the REST route.
	 */
	public static function init(): void {
		add_action( 'rest_api_init', array( self::class, 'register_routes' ) );
	}

	/**
	 * Register REST routes.
	 */
	public static function register_routes(): void {
		register_rest_route(
			'wp-site-designer/v1',
			'/posts/(?P<post_type>[a-z_]+)/(?P<post_id>\d+)/revisions/(?P<revision_id>\d+)/restore',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'handle_restore' ),
				'permission_callback' => array( self::class, 'check_permission' ),
				'args'                => array(
					'post_type'   => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
						'validate_callback' => function ( $value ) {
							return is_string( $value ) && in_array( $value, self::ALLOWED_POST_TYPES, true );
						},
					),
					'post_id'     => array(
						'required'          => true,
						'type'              => 'integer',
						'sanitize_callback' => 'absint',
						'validate_callback' => function ( $value ) {
							return is_numeric( $value ) && (int) $value > 0;
						},
					),
					'revision_id' => array(
						'required'          => true,
						'type'              => 'integer',
						'sanitize_callback' => 'absint',
						'validate_callback' => function ( $value ) {
							return is_numeric( $value ) && (int) $value > 0;
						},
					),
				),
			)
		);
	}

	/**
	 * Permission callback: requires edit_post cap on the target post and
	 * enforces a per-user fixed-window rate limit.
	 *
	 * @param WP_REST_Request $request REST request.
	 *
	 * @return bool|WP_Error
	 */
	public static function check_permission( WP_REST_Request $request ) {
		$post_id = (int) $request->get_param( 'post_id' );

		if ( $post_id <= 0 || ! current_user_can( 'edit_post', $post_id ) ) {
			return new WP_Error(
				'rest_forbidden',
				'You do not have permission to edit this post.',
				array( 'status' => 403 )
			);
		}

		$identifier = 'revision_restore_' . get_current_user_id();
		if ( ! Rate_Limiter::check( $identifier, 30, 300 ) ) { // 30 per 5 minutes.
			return new WP_Error(
				'rate_limit_exceeded',
				'Too many requests. Please try again later.',
				array( 'status' => 429 )
			);
		}

		return true;
	}

	/**
	 * Handle a restore request.
	 *
	 * @param WP_REST_Request $request REST request.
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public static function handle_restore( WP_REST_Request $request ) {
		$post_type   = (string) $request->get_param( 'post_type' );
		$post_id     = (int) $request->get_param( 'post_id' );
		$revision_id = (int) $request->get_param( 'revision_id' );

		$post = get_post( $post_id );
		if ( ! $post || $post->post_type !== $post_type ) {
			return new WP_Error(
				'invalid_post',
				'The specified post does not exist or does not match the requested post type.',
				array( 'status' => 404 )
			);
		}

		// Defense in depth: a theme/plugin can disable revisions via filter.
		if ( ! post_type_supports( $post->post_type, 'revisions' ) ) {
			return new WP_Error(
				'revisions_not_supported',
				'This post type does not support revisions.',
				array( 'status' => 400 )
			);
		}

		$revision = wp_get_post_revision( $revision_id );
		if ( ! $revision || (int) $revision->post_parent !== $post_id ) {
			return new WP_Error(
				'invalid_revision',
				'The specified revision does not exist or does not belong to this post.',
				array( 'status' => 404 )
			);
		}

		if ( 'trash' === $post->post_status ) {
			$untrashed = wp_untrash_post( $post_id );
			if ( ! $untrashed ) {
				return new WP_Error(
					'untrash_failed',
					'Failed to restore the deleted post.',
					array( 'status' => 500 )
				);
			}

			$published = wp_update_post(
				array(
					'ID'          => $post_id,
					'post_status' => 'publish',
				),
				true
			);
			if ( is_wp_error( $published ) || 0 === $published ) {
				return new WP_Error(
					'publish_failed',
					'Failed to publish the restored post.',
					array( 'status' => 500 )
				);
			}
		}

		$result = wp_restore_post_revision( $revision_id );

		if ( is_wp_error( $result ) ) {
			$code    = $result->get_error_code();
			$message = $result->get_error_message();
			return new WP_Error(
				is_string( $code ) && '' !== $code ? $code : 'restore_failed',
				'' !== $message ? $message : 'Failed to restore the revision.',
				array( 'status' => 500 )
			);
		}

		if ( ! $result ) {
			return new WP_Error(
				'restore_failed',
				'Failed to restore the revision.',
				array( 'status' => 500 )
			);
		}

		// Deterministic newest-revision lookup — default orderby=date can tie on
		// same-second writes that wp_restore_post_revision() just produced.
		$latest              = wp_get_post_revisions(
			$post_id,
			array(
				'numberposts' => 1,
				'orderby'     => 'ID',
				'order'       => 'DESC',
			)
		);
		$current_revision_id = ! empty( $latest ) ? (int) key( $latest ) : null;

		return new WP_REST_Response(
			array(
				'success'              => true,
				'post_type'            => $post_type,
				'post_id'              => $post_id,
				'restored_revision_id' => $revision_id,
				'current_revision_id'  => $current_revision_id,
			),
			200
		);
	}
}
