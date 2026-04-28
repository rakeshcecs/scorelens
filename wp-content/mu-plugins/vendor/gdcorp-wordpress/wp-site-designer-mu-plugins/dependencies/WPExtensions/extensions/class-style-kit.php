<?php
/**
 * Style Kit
 *
 * Applies a comprehensive set of FSE style overrides (button shape, spacing,
 * image treatment, font size scale, shadows, custom CSS) via the
 * wp_theme_json_data_user filter. Does not touch color palette or font families —
 * those are handled by Palette_Switcher and Font_Pairing respectively.
 * On switch, also writes the full visual identity (kit + bundled palette/font)
 * into the wp_global_styles post for editor parity.
 *
 * Must stay in sync with packages/native-ui/src/data/styleKits.ts (slug list).
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
 * Manages style kit selection via REST API and applies FSE style overrides through theme.json user data.
 */
class Style_Kit {

	public const OPTION_KEY   = 'wp_site_designer_active_style_kit';
	public const SNAPSHOT_KEY = 'wp_site_designer_pre_kit_snapshot';

	/**
	 * Style kits keyed by slug, lazy-loaded from Data/style-kits-data.php.
	 *
	 * @var array<string, array>|null
	 */
	private static ?array $style_kits = null;

	/**
	 * Bundled palette + font pairing per kit, lazy-loaded from Data/style-kits-data.php.
	 *
	 * @var array<string, array{palette: string, fontPairing: string}>|null
	 */
	private static ?array $kit_bundles = null;

	/**
	 * Lazy-load style kit data from the external data file.
	 *
	 * @return void
	 */
	private static function load_data(): void {
		if ( null !== self::$style_kits ) {
			return;
		}
		$data              = require __DIR__ . '/../data/style-kits-data.php';
		self::$style_kits  = $data['style_kits'];
		self::$kit_bundles = $data['kit_bundles'];
	}

	/**
	 * Get all style kits.
	 *
	 * @return array<string, array>
	 */
	private static function get_style_kits(): array {
		self::load_data();
		return self::$style_kits;
	}

	/**
	 * Get all kit bundles.
	 *
	 * @return array<string, array{palette: string, fontPairing: string}>
	 */
	private static function get_kit_bundles(): array {
		self::load_data();
		return self::$kit_bundles;
	}

	/**
	 * Initialize and register hooks.
	 *
	 * @return void
	 */
	public static function init(): void {
		$instance = new self();
		add_action( 'rest_api_init', array( $instance, 'register_routes' ) );
		add_filter( 'wp_theme_json_data_user', array( $instance, 'apply_style_kit' ) );
	}

	/**
	 * Register REST routes.
	 *
	 * @return void
	 */
	public function register_routes(): void {
		register_rest_route(
			'wp-site-designer/v1',
			'/style-kit',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_switch' ),
				'permission_callback' => function () {
					if ( ! current_user_can( 'edit_theme_options' ) ) {
						return false;
					}
					$identifier = 'style_kit_' . get_current_user_id();
					if ( ! Rate_Limiter::check( $identifier, 60, 300 ) ) {
						return new WP_Error( 'rate_limit_exceeded', 'Too many requests. Please try again later.', array( 'status' => 429 ) );
					}
					return true;
				},
				'args'                => array(
					'styleKit' => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
						'validate_callback' => function ( $value ) {
							return 'none' === $value || isset( self::get_style_kits()[ $value ] );
						},
					),
				),
			)
		);

		register_rest_route(
			'wp-site-designer/v1',
			'/style-kit',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_active' ),
				'permission_callback' => function () {
					if ( ! current_user_can( 'edit_theme_options' ) ) {
						return false;
					}
					$identifier = 'style_kit_get_' . get_current_user_id();
					if ( ! Rate_Limiter::check( $identifier, 60, 60 ) ) { // 60 per minute.
						return new WP_Error( 'rate_limit_exceeded', 'Too many requests. Please try again later.', array( 'status' => 429 ) );
					}
					return true;
				},
			)
		);
	}

	/**
	 * Get the currently active style kit slug (REST callback).
	 *
	 * @return \WP_REST_Response
	 */
	public function get_active(): \WP_REST_Response {
		$slug = self::get_active_style_kit();
		return new \WP_REST_Response( array( 'styleKit' => $slug ), 200 );
	}

	/**
	 * Handle a style kit switch request.
	 *
	 * @param \WP_REST_Request $request The REST request.
	 * @return \WP_REST_Response
	 */
	public function handle_switch( \WP_REST_Request $request ): \WP_REST_Response {
		$slug = $request->get_param( 'styleKit' );

		$errors = array();

		if ( 'none' === $slug ) {
			delete_option( self::OPTION_KEY );
			self::restore_pre_kit_snapshot();
		} else {
			update_option( self::OPTION_KEY, $slug, false );

			// Also apply the bundled palette and font pairing via their
			// dedicated setter methods to keep storage logic encapsulated.
			if ( isset( self::get_kit_bundles()[ $slug ] ) ) {
				$bundle = self::get_kit_bundles()[ $slug ];
				if ( ! Palette_Switcher::set_active_palette( $bundle['palette'] ) ) {
					$errors[] = 'palette';
				}
				if ( ! Font_Pairing::set_active_font_pairing( $bundle['fontPairing'] ) ) {
					$errors[] = 'fontPairing';
				}
			}

			// Write kit styles into the global styles post so the editor
			// and frontend render identically from the same source.
			self::apply_kit_to_global_styles( $slug );
		}

		Global_Styles_Sync::flush_theme_json_cache();

		$response = array(
			'success'  => empty( $errors ),
			'styleKit' => $slug,
		);

		if ( ! empty( $errors ) ) {
			$response['failedUpdates'] = $errors;
		}

		return new \WP_REST_Response( $response, 200 );
	}

	/**
	 * Merge the active style kit into theme.json via the user data filter.
	 *
	 * Only applies the kit's own fragment (button shapes, spacing, font sizes,
	 * shadows, CSS). Palette and font families are owned by Palette_Switcher
	 * and Font_Pairing respectively.
	 *
	 * @param \WP_Theme_JSON_Data $theme_json The incoming theme JSON data.
	 * @return \WP_Theme_JSON_Data
	 */
	public function apply_style_kit( $theme_json ) {
		$slug       = self::get_active_style_kit();
		$style_kits = self::get_style_kits();
		if ( ! $slug || ! isset( $style_kits[ $slug ] ) ) {
			return $theme_json;
		}

		return $theme_json->update_with( $style_kits[ $slug ] );
	}

	/**
	 * Find the wp_global_styles post for the active theme.
	 *
	 * @return \WP_Post|null The global styles post, or null if not found.
	 */
	private static function get_global_styles_post(): ?\WP_Post {
		$query = new \WP_Query(
			array(
				'post_type'               => 'wp_global_styles',
				'post_status'             => array( 'publish', 'draft' ),
				'posts_per_page'          => 1,
				'no_found_rows'           => true,
				'update_post_meta_caches' => false,
				'update_post_term_caches' => false,
				'tax_query'               => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- required to find the correct wp_global_styles post for the active theme.
					array(
						'taxonomy' => 'wp_theme',
						'field'    => 'name',
						'terms'    => get_stylesheet(),
					),
				),
			)
		);

		return $query->have_posts() ? $query->posts[0] : null;
	}

	/**
	 * Save content to the global styles post.
	 *
	 * @param int   $post_id The post ID.
	 * @param array $content The decoded post content to save.
	 */
	private static function save_global_styles( int $post_id, array $content ): void {
		$encoded = wp_json_encode( $content );
		if ( ! $encoded ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- intentional error logging for failed JSON encode.
			error_log( 'Style_Kit: failed to encode global styles for post ' . $post_id );
			return;
		}

		Global_Styles_Sync::set_internal_update( true );
		try {
			// wp_update_post runs wp_unslash then sanitization on post_content.
			// wp_slash ensures the JSON survives the round-trip intact.
			wp_update_post(
				array(
					'ID'           => $post_id,
					'post_content' => wp_slash( $encoded ),
				)
			);
		} finally {
			Global_Styles_Sync::set_internal_update( false );
		}
	}

	/**
	 * Write the kit's styles directly into the wp_global_styles post.
	 *
	 * This ensures the editor and frontend render identically — both read
	 * from the same post rather than fighting over filter vs post specificity.
	 *
	 * @param string $slug The style kit slug.
	 */
	private static function apply_kit_to_global_styles( string $slug ): void {
		$style_kits = self::get_style_kits();
		if ( ! isset( $style_kits[ $slug ] ) ) {
			return;
		}

		$kit = $style_kits[ $slug ];

		$post = self::get_global_styles_post();
		if ( ! $post ) {
			return;
		}

		$content = json_decode( $post->post_content, true );
		if ( ! is_array( $content ) ) {
			$content = array(
				'version'                     => 3,
				'isGlobalStylesUserThemeJSON' => true,
			);
		}

		// Snapshot the current post content before applying the kit so we
		// can restore it when switching back to "none". Only snapshot if
		// no kit is currently active (i.e. this is the first kit being
		// applied). Switching between kits re-uses the original snapshot.
		if ( ! get_option( self::SNAPSHOT_KEY ) ) {
			update_option( self::SNAPSHOT_KEY, $post->post_content, false );
		}

		// Merge kit's element-level button styles.
		if ( isset( $kit['styles']['elements']['button'] ) ) {
			$content['styles']['elements']['button'] = $kit['styles']['elements']['button'];
		}

		// Merge kit's block-level button styles (including variations).
		if ( isset( $kit['styles']['blocks']['core/button'] ) ) {
			$content['styles']['blocks']['core/button'] = $kit['styles']['blocks']['core/button'];
		}

		// Merge kit's element-level link, heading, caption styles.
		foreach ( array( 'link', 'heading', 'caption' ) as $element ) {
			if ( isset( $kit['styles']['elements'][ $element ] ) ) {
				$content['styles']['elements'][ $element ] = $kit['styles']['elements'][ $element ];
			}
		}

		// Merge kit's block-level styles (image, separator, quote, cover).
		if ( isset( $kit['styles']['blocks'] ) ) {
			foreach ( $kit['styles']['blocks'] as $block_name => $block_styles ) {
				$content['styles']['blocks'][ $block_name ] = $block_styles;
			}
		}

		// Merge kit's top-level typography (lineHeight).
		if ( isset( $kit['styles']['typography'] ) ) {
			if ( ! isset( $content['styles']['typography'] ) ) {
				$content['styles']['typography'] = array();
			}
			$content['styles']['typography'] = array_merge(
				$content['styles']['typography'],
				$kit['styles']['typography']
			);
		}

		// Merge kit's custom CSS.
		if ( isset( $kit['styles']['css'] ) ) {
			$content['styles']['css'] = $kit['styles']['css'];
		}

		// Merge kit's settings (fontSizes, spacing, layout).
		// The wp_global_styles post may store fontSizes/spacingSizes in
		// origin-keyed format (e.g. {"default": [...], "theme": [...]}).
		// Using array_replace_recursive would corrupt this structure by
		// merging flat sequential arrays into the origin-keyed object.
		// Instead, write each setting path explicitly under the "theme" key
		// when the existing value is origin-keyed, or replace directly
		// when it is a flat array.
		if ( isset( $kit['settings'] ) ) {
			if ( ! isset( $content['settings'] ) ) {
				$content['settings'] = array();
			}
			self::merge_settings_into_post( $content['settings'], $kit['settings'] );
		}

		// Merge bundled palette and font data into the post using flat arrays
		// (the wp_global_styles post stores theme.json v2 format, not origin-keyed).
		$bundles = self::get_kit_bundles();
		if ( isset( $bundles[ $slug ] ) ) {
			$bundle = $bundles[ $slug ];

			$palette_entries = Palette_Switcher::get_palette_for_slug( $bundle['palette'] );
			if ( ! empty( $palette_entries ) ) {
				$content['settings']['color']['palette'] = $palette_entries;
			}

			$font_update = Font_Pairing::get_font_update_for_slug( $bundle['fontPairing'] );
			if ( ! empty( $font_update ) ) {
				if ( isset( $font_update['settings']['typography']['fontFamilies'] ) ) {
					$content['settings']['typography']['fontFamilies'] = $font_update['settings']['typography']['fontFamilies'];
				}
				if ( isset( $font_update['styles']['typography']['fontFamily'] ) ) {
					$content['styles']['typography']['fontFamily'] = $font_update['styles']['typography']['fontFamily'];
				}
				if ( isset( $font_update['styles']['elements']['heading']['typography']['fontFamily'] ) ) {
					if ( ! isset( $content['styles']['elements']['heading']['typography'] ) ) {
						$content['styles']['elements']['heading']['typography'] = array();
					}
					$content['styles']['elements']['heading']['typography']['fontFamily'] = $font_update['styles']['elements']['heading']['typography']['fontFamily'];
				}
			}
		}

		self::save_global_styles( $post->ID, $content );
	}

	/**
	 * Restore the global styles post to its pre-kit state.
	 *
	 * Uses the snapshot saved before the first kit was applied. Clears
	 * the snapshot option after restoring.
	 */
	private static function restore_pre_kit_snapshot(): void {
		$snapshot = get_option( self::SNAPSHOT_KEY );
		if ( ! $snapshot ) {
			return;
		}

		$post = self::get_global_styles_post();
		if ( ! $post ) {
			delete_option( self::SNAPSHOT_KEY );
			return;
		}

		// Validate the snapshot is valid JSON before restoring.
		$decoded = json_decode( $snapshot, true );
		if ( ! is_array( $decoded ) ) {
			delete_option( self::SNAPSHOT_KEY );
			return;
		}

		self::save_global_styles( $post->ID, $decoded );
		delete_option( self::SNAPSHOT_KEY );
	}

	/**
	 * Merge kit settings into existing post settings without corrupting
	 * origin-keyed arrays (fontSizes, spacingSizes, etc.).
	 *
	 * The wp_global_styles post may store arrays like fontSizes in
	 * origin-keyed format: {"default": [...], "theme": [...]}. Flat
	 * sequential arrays from the kit are written under the "theme" key
	 * to match WordPress convention. Scalar settings (e.g. layout
	 * contentSize) are merged directly.
	 *
	 * @param array $post_settings Existing post settings (modified by reference).
	 * @param array $kit_settings  Kit settings to merge.
	 */
	private static function merge_settings_into_post( array &$post_settings, array $kit_settings ): void {
		// Settings paths that contain sequential arrays which must not be
		// merged with array_replace_recursive into origin-keyed structures.
		$array_paths = array(
			array( 'typography', 'fontSizes' ),
			array( 'spacing', 'spacingSizes' ),
		);

		// Work with a copy so we can remove handled paths without mutating
		// the input while we're still reading from it.
		$remaining = $kit_settings;

		foreach ( $array_paths as $path ) {
			// Read the value from the original kit settings.
			$kit_value = $kit_settings;
			foreach ( $path as $key ) {
				if ( ! isset( $kit_value[ $key ] ) ) {
					$kit_value = null;
					break;
				}
				$kit_value = $kit_value[ $key ];
			}

			if ( null === $kit_value ) {
				continue;
			}

			// Navigate to the parent in the post settings, creating as needed.
			$target = &$post_settings;
			foreach ( $path as $i => $key ) {
				if ( count( $path ) - 1 === $i ) {
					// Final key — check if the existing value is origin-keyed.
					if ( isset( $target[ $key ] ) && is_array( $target[ $key ] ) && ! wp_is_numeric_array( $target[ $key ] ) ) {
						// Origin-keyed: write under "theme".
						$target[ $key ]['theme'] = $kit_value;
					} else {
						// Flat or missing: replace directly.
						$target[ $key ] = $kit_value;
					}
				} else {
					if ( ! isset( $target[ $key ] ) ) {
						$target[ $key ] = array();
					}
					$target = &$target[ $key ];
				}
			}
			unset( $target );

			// Remove the handled path from the copy so it's not double-merged.
			$ref = &$remaining;
			foreach ( $path as $i => $key ) {
				if ( count( $path ) - 1 === $i ) {
					unset( $ref[ $key ] );
				} else {
					if ( ! isset( $ref[ $key ] ) ) {
						break;
					}
					$ref = &$ref[ $key ];
				}
			}
			unset( $ref );
		}

		// Merge remaining scalar/non-array settings directly.
		if ( ! empty( $remaining ) ) {
			$post_settings = array_replace_recursive( $post_settings, $remaining );
		}
	}

	/**
	 * Get the active style kit slug.
	 *
	 * @return string
	 */
	public static function get_active_style_kit(): string {
		return (string) get_option( self::OPTION_KEY, '' );
	}
}
