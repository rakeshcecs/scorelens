<?php
/**
 * Palette Switcher
 *
 * Applies a color palette to the site via the wp_theme_json_data_user filter.
 * Stores the active palette slug in wp_options; on every request the filter
 * merges the palette colors into theme.json settings.color.palette at the
 * user layer so they override any colors set by site generation.
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

/**
 * Manages color palette selection via REST API and applies it through theme.json user data.
 */
class Palette_Switcher {

	public const OPTION_KEY = 'wp_site_designer_active_palette';

	/**
	 * Palettes keyed by slug.
	 * Must stay in sync with packages/native-ui/src/data/palettes.ts.
	 *
	 * @var array<string, array{name: string, base: string, contrast: string, accent1: string, accent2: string, accent3: string, accent4: string, accent5: string}>
	 */
	private const PALETTES = array(
		'professional' => array(
			'name'     => 'Professional',
			'base'     => '#FFFFFF',
			'contrast' => '#111111',
			'accent1'  => '#9FC2E8',
			'accent2'  => '#6A8FE3',
			'accent3'  => '#0A1F44',
			'accent4'  => '#5F7F99',
			'accent5'  => '#F2F5F9',
		),
		'warm'         => array(
			'name'     => 'Warm',
			'base'     => '#F7F3E9',
			'contrast' => '#5D4427',
			'accent1'  => '#C65D2F',
			'accent2'  => '#E8A87C',
			'accent3'  => '#8B5E3C',
			'accent4'  => '#B8956E',
			'accent5'  => '#FDFBF5',
		),
		'natural'      => array(
			'name'     => 'Natural',
			'base'     => '#F5F3E8',
			'contrast' => '#2D4434',
			'accent1'  => '#8B9D7C',
			'accent2'  => '#B8A989',
			'accent3'  => '#4A6350',
			'accent4'  => '#D4C5A8',
			'accent5'  => '#FDFCF7',
		),
		'chic'         => array(
			'name'     => 'Chic',
			'base'     => '#F7EBE5',
			'contrast' => '#2B1F1F',
			'accent1'  => '#8B6B70',
			'accent2'  => '#C4534D',
			'accent3'  => '#5C4145',
			'accent4'  => '#A68B8F',
			'accent5'  => '#FCF6F4',
		),
		'friendly'     => array(
			'name'     => 'Friendly',
			'base'     => '#FFFFFF',
			'contrast' => '#1A1A1A',
			'accent1'  => '#5B9BD5',
			'accent2'  => '#0E8AAA',
			'accent3'  => '#1E3A5F',
			'accent4'  => '#89C4E1',
			'accent5'  => '#F5F9FC',
		),
		'modern'       => array(
			'name'     => 'Modern',
			'base'     => '#FFFFFF',
			'contrast' => '#1E2A3A',
			'accent1'  => '#F0EEF8',
			'accent2'  => '#8B7AB8',
			'accent3'  => '#4A3B6B',
			'accent4'  => '#5D6B88',
			'accent5'  => '#FAFAFE',
		),
		'classic'      => array(
			'name'     => 'Classic',
			'base'     => '#F5F3F1',
			'contrast' => '#4A4556',
			'accent1'  => '#A16E7C',
			'accent2'  => '#C9A5AE',
			'accent3'  => '#5E5468',
			'accent4'  => '#8C7E8F',
			'accent5'  => '#FAFAF9',
		),
		'playful'      => array(
			'name'     => 'Playful',
			'base'     => '#FFFEF8',
			'contrast' => '#1A1A1A',
			'accent1'  => '#FF8C42',
			'accent2'  => '#267872',
			'accent3'  => '#E85D23',
			'accent4'  => '#7DD3CE',
			'accent5'  => '#FFFEFB',
		),
		'luxurious'    => array(
			'name'     => 'Luxurious',
			'base'     => '#FBF8F3',
			'contrast' => '#2D0A0A',
			'accent1'  => '#8B2C3A',
			'accent2'  => '#C17B85',
			'accent3'  => '#5A1B25',
			'accent4'  => '#A65B66',
			'accent5'  => '#FFFDFB',
		),
		'bold'         => array(
			'name'     => 'Bold',
			'base'     => '#FFFFFF',
			'contrast' => '#1A1A1A',
			'accent1'  => '#E63946',
			'accent2'  => '#457B9D',
			'accent3'  => '#1D3557',
			'accent4'  => '#A8DADC',
			'accent5'  => '#F1FAEE',
		),
		'ocean'        => array(
			'name'     => 'Ocean',
			'base'     => '#FFFFFF',
			'contrast' => '#0B2027',
			'accent1'  => '#40798C',
			'accent2'  => '#70A9A1',
			'accent3'  => '#1B4965',
			'accent4'  => '#9EC5AB',
			'accent5'  => '#F0F7F4',
		),
		'golden'       => array(
			'name'     => 'Golden',
			'base'     => '#FFFDF5',
			'contrast' => '#2C1810',
			'accent1'  => '#D4A03C',
			'accent2'  => '#B8860B',
			'accent3'  => '#5C4017',
			'accent4'  => '#E8C872',
			'accent5'  => '#FFFEF8',
		),
		'monochrome'   => array(
			'name'     => 'Monochrome',
			'base'     => '#FFFFFF',
			'contrast' => '#111111',
			'accent1'  => '#555555',
			'accent2'  => '#888888',
			'accent3'  => '#333333',
			'accent4'  => '#AAAAAA',
			'accent5'  => '#F5F5F5',
		),
		'forest'       => array(
			'name'     => 'Forest',
			'base'     => '#F8F6F0',
			'contrast' => '#1A2E1A',
			'accent1'  => '#4A7C59',
			'accent2'  => '#2D5F3E',
			'accent3'  => '#1A3A26',
			'accent4'  => '#8FBC8F',
			'accent5'  => '#F7FAF5',
		),
		'sunset'       => array(
			'name'     => 'Sunset',
			'base'     => '#FFFBF5',
			'contrast' => '#2D1B0E',
			'accent1'  => '#E07A3A',
			'accent2'  => '#C84B31',
			'accent3'  => '#6B2D14',
			'accent4'  => '#F4A261',
			'accent5'  => '#FFF8F0',
		),
		'coastal'      => array(
			'name'     => 'Coastal',
			'base'     => '#FFFFFF',
			'contrast' => '#1C2B3A',
			'accent1'  => '#5B8FA8',
			'accent2'  => '#D4A574',
			'accent3'  => '#2C5F7C',
			'accent4'  => '#A8C8D8',
			'accent5'  => '#F4F8FA',
		),
		'electric'     => array(
			'name'     => 'Electric',
			'base'     => '#FFFFFF',
			'contrast' => '#0F0F1A',
			'accent1'  => '#6C5CE7',
			'accent2'  => '#00CEC9',
			'accent3'  => '#2D1B69',
			'accent4'  => '#A29BFE',
			'accent5'  => '#F5F3FF',
		),
		'terracotta'   => array(
			'name'     => 'Terracotta',
			'base'     => '#FBF5F0',
			'contrast' => '#3D2519',
			'accent1'  => '#C67B5C',
			'accent2'  => '#A0522D',
			'accent3'  => '#5C3321',
			'accent4'  => '#D4A68C',
			'accent5'  => '#FDF9F6',
		),
		'midnight'     => array(
			'name'     => 'Midnight',
			'base'     => '#F8F9FA',
			'contrast' => '#0D1117',
			'accent1'  => '#58A6FF',
			'accent2'  => '#388BFD',
			'accent3'  => '#161B22',
			'accent4'  => '#79C0FF',
			'accent5'  => '#F0F3F6',
		),
		'botanical'    => array(
			'name'     => 'Botanical',
			'base'     => '#FDFBF7',
			'contrast' => '#2B3A2B',
			'accent1'  => '#7B9E6B',
			'accent2'  => '#C4A35A',
			'accent3'  => '#3D5C3A',
			'accent4'  => '#B5C99A',
			'accent5'  => '#FAFDF5',
		),
		'coral'        => array(
			'name'     => 'Coral',
			'base'     => '#FFFFFF',
			'contrast' => '#1A1A2E',
			'accent1'  => '#FF6B6B',
			'accent2'  => '#EE5A6F',
			'accent3'  => '#2C2C54',
			'accent4'  => '#FFA07A',
			'accent5'  => '#FFF5F5',
		),
		'dark'         => array(
			'name'     => 'Dark',
			'base'     => '#121212',
			'contrast' => '#F5F5F5',
			'accent1'  => '#BB86FC',
			'accent2'  => '#03DAC6',
			'accent3'  => '#CF6679',
			'accent4'  => '#8AB4F8',
			'accent5'  => '#1E1E1E',
		),
		'dark-ember'   => array(
			'name'     => 'Dark Ember',
			'base'     => '#1A1210',
			'contrast' => '#FAF0E6',
			'accent1'  => '#FF6B35',
			'accent2'  => '#E8A87C',
			'accent3'  => '#FFB088',
			'accent4'  => '#C4704E',
			'accent5'  => '#241A16',
		),
		'dark-slate'   => array(
			'name'     => 'Dark Slate',
			'base'     => '#0F1923',
			'contrast' => '#E8ECF1',
			'accent1'  => '#64B5F6',
			'accent2'  => '#4DB6AC',
			'accent3'  => '#90CAF9',
			'accent4'  => '#80CBC4',
			'accent5'  => '#162030',
		),
	);

	/**
	 * Initialize and register hooks.
	 *
	 * @return void
	 */
	public static function init(): void {
		$instance = new self();
		add_action( 'rest_api_init', array( $instance, 'register_routes' ) );
		add_filter( 'wp_theme_json_data_user', array( $instance, 'apply_palette' ) );
	}

	/**
	 * Register REST routes.
	 *
	 * @return void
	 */
	public function register_routes(): void {
		register_rest_route(
			'wp-site-designer/v1',
			'/palette',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_switch' ),
				'permission_callback' => function () {
					if ( ! current_user_can( 'edit_theme_options' ) ) {
						return false;
					}
					$identifier = 'palette_' . get_current_user_id();
					if ( ! Rate_Limiter::check( $identifier, 30, 300 ) ) { // 30 per 5 minutes
						return new WP_Error( 'rate_limit_exceeded', 'Too many requests. Please try again later.', array( 'status' => 429 ) );
					}
					return true;
				},
				'args'                => array(
					'palette' => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
						'validate_callback' => function ( $value ) {
							return 'none' === $value || isset( self::PALETTES[ $value ] );
						},
					),
				),
			)
		);

		register_rest_route(
			'wp-site-designer/v1',
			'/palette',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_active' ),
				'permission_callback' => function () {
					if ( ! current_user_can( 'edit_theme_options' ) ) {
						return false;
					}
					$identifier = 'palette_get_' . get_current_user_id();
					if ( ! Rate_Limiter::check( $identifier, 60, 60 ) ) { // 60 per minute.
						return new WP_Error( 'rate_limit_exceeded', 'Too many requests. Please try again later.', array( 'status' => 429 ) );
					}
					return true;
				},
			)
		);
	}

	/**
	 * Get the currently active palette slug (REST callback).
	 *
	 * @return \WP_REST_Response
	 */
	public function get_active(): \WP_REST_Response {
		$slug = self::get_active_palette();
		return new \WP_REST_Response( array( 'palette' => $slug ), 200 );
	}

	/**
	 * Handle a palette switch request.
	 *
	 * @param \WP_REST_Request $request The REST request.
	 * @return \WP_REST_Response
	 */
	public function handle_switch( \WP_REST_Request $request ): \WP_REST_Response {
		$slug = $request->get_param( 'palette' );

		if ( 'none' === $slug ) {
			delete_option( self::OPTION_KEY );
		} else {
			update_option( self::OPTION_KEY, $slug, false );
		}

		Global_Styles_Sync::flush_theme_json_cache();

		return new \WP_REST_Response(
			array(
				'success' => true,
				'palette' => $slug,
			),
			200
		);
	}

	/**
	 * Merge the active palette into theme.json via the user data filter.
	 *
	 * @param \WP_Theme_JSON_Data $theme_json The incoming theme JSON data.
	 * @return \WP_Theme_JSON_Data
	 */
	public function apply_palette( $theme_json ) {
		$slug = self::get_active_palette();
		if ( ! $slug || ! isset( self::PALETTES[ $slug ] ) ) {
			return $theme_json;
		}

		return $theme_json->update_with(
			array(
				'version'  => 2,
				'settings' => array(
					'color' => array(
						'palette' => self::build_palette_from_colors( self::PALETTES[ $slug ] ),
					),
				),
			)
		);
	}

	/**
	 * Build the 12-entry palette array from a predefined color set.
	 *
	 * @param array $colors Associative array with base, contrast, accent1-5 keys.
	 * @return array The 12-entry palette array for theme.json.
	 */
	private static function build_palette_from_colors( array $colors ): array {
		return array(
			array(
				'color' => $colors['base'],
				'name'  => 'Base',
				'slug'  => 'base',
			),
			array(
				'color' => $colors['contrast'],
				'name'  => 'Contrast',
				'slug'  => 'contrast',
			),
			array(
				'color' => $colors['contrast'],
				'name'  => 'Contrast 3',
				'slug'  => 'contrast-3',
			),
			array(
				'color' => $colors['accent1'],
				'name'  => 'Accent 1',
				'slug'  => 'accent-1',
			),
			array(
				'color' => $colors['accent2'],
				'name'  => 'Accent 2',
				'slug'  => 'accent-2',
			),
			array(
				'color' => $colors['base'],
				'name'  => 'Base 2',
				'slug'  => 'base-2',
			),
			array(
				'color' => $colors['accent3'],
				'name'  => 'Accent 3',
				'slug'  => 'accent-3',
			),
			array(
				'color' => $colors['accent4'],
				'name'  => 'Accent 4',
				'slug'  => 'accent-4',
			),
			array(
				'color' => $colors['accent5'],
				'name'  => 'Accent 5',
				'slug'  => 'accent-5',
			),
			array(
				'color' => self::hex_to_rgba( $colors['contrast'], 0.2 ),
				'name'  => 'Accent 6',
				'slug'  => 'accent-6',
			),
			array(
				'color' => $colors['accent1'],
				'name'  => 'Accent',
				'slug'  => 'accent',
			),
			array(
				'color' => $colors['base'],
				'name'  => 'Background',
				'slug'  => 'background',
			),
		);
	}

	/**
	 * Get the active palette slug.
	 *
	 * @return string
	 */
	public static function get_active_palette(): string {
		return (string) get_option( self::OPTION_KEY, '' );
	}

	/**
	 * Get the 12-entry palette array for a given predefined slug.
	 *
	 * Used by Style_Kit to bundle palette colors into the kit fragment.
	 *
	 * @param string $slug A valid palette slug.
	 * @return array The 12-entry palette array, or empty array if slug not found.
	 */
	public static function get_palette_for_slug( string $slug ): array {
		if ( ! isset( self::PALETTES[ $slug ] ) ) {
			return array();
		}
		return self::build_palette_from_colors( self::PALETTES[ $slug ] );
	}

	/**
	 * Set the active palette slug.
	 *
	 * @param string $slug A valid palette slug or 'none' to clear.
	 * @return bool True on success, false on failure.
	 */
	public static function set_active_palette( string $slug ): bool {
		if ( 'none' === $slug ) {
			return delete_option( self::OPTION_KEY );
		}
		return update_option( self::OPTION_KEY, $slug, false );
	}

	/**
	 * Convert a hex colour to an rgba() string at the given alpha.
	 *
	 * @param string $hex   A 3- or 6-digit hex colour (with or without #).
	 * @param float  $alpha Opacity between 0 and 1.
	 * @return string       CSS rgba() value, e.g. "rgba(17, 17, 17, 0.2)".
	 */
	private static function hex_to_rgba( string $hex, float $alpha ): string {
		$hex = ltrim( $hex, '#' );
		if ( 3 === strlen( $hex ) ) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		return sprintf( 'rgba(%d, %d, %d, %s)', $r, $g, $b, $alpha );
	}
}
