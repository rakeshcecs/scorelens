<?php
/**
 * Plugin Name: WordPress Site Designer MU-Plugins
 * Description: MU-Plugins for WordPress Site Designer integration
 * Version: 2.0.3
 * Author: GoDaddy
 * Requires PHP: 7.4
 *
 * @package wp-site-designer-mu-plugins
 */

declare( strict_types=1 );

namespace GoDaddy\WordPress\Plugins\SiteDesigner;

use GoDaddy\WordPress\Plugins\SiteDesigner\Api\Media_Sideload_Api;
use GoDaddy\WordPress\Plugins\SiteDesigner\Api\Site_Designer_Api;
use GoDaddy\WordPress\Plugins\SiteDesigner\Auth\JWT_Auth;
use GoDaddy\WordPress\Plugins\SiteDesigner\Auth\Signature_Auth;
use GoDaddy\WordPress\Plugins\SiteDesigner\Auth\WP_Public_Api_Client;
use GoDaddy\WordPress\Plugins\SiteDesigner\Compat\Compatibility_Modal;
use GoDaddy\WordPress\Plugins\SiteDesigner\Compat\Compatibility_Notices;
use GoDaddy\WordPress\Plugins\SiteDesigner\Compat\Plugin_Compatibility;
use GoDaddy\WordPress\Plugins\SiteDesigner\Compat\Theme_Compatibility;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Compatibility_Bridge;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\FullStory_Iframe_Tracker;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Iframe_Support;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Hide_Admin_Bar;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Gutenberg_Support;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Cookie_Status_Bridge;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Navigation_Bridge;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Change_Highlighter;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\GoDaddy_Media_Tab;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Media_Upload;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Safari_Storage_Access;
use GoDaddy\WordPress\Plugins\SiteDesigner\Extensions\Viewport_Bridge;
use GoDaddy\WordPress\Plugins\SiteDesigner\Utils\Config;
use GoDaddy\WordPress\Plugins\SiteDesigner\Utils\Request_Validator;
use GoDaddy\WordPress\Plugins\SiteDesigner\Utils\Iframe_Context_Detector;
use GoDaddy\WordPress\Plugins\SiteDesigner\Woo;

// WP extensions (Mozart-prefixed from gdcorp-wordpress/site-designer-wp-extensions).
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Native_UI_Loader;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Font_Pairing;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Palette_Switcher;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Style_Kit;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Theme_Reset;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Global_Styles_Sync;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\OAuth_Complete;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\FullStory_Tracker;
use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Editor_Welcome_Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load gdmu_site_designer_should_run() scoping functions.
require_once __DIR__ . '/should_run.php';

// Load production autoloader (Mozart-prefixed dependencies + plugin code).
// This is a Composer-generated autoloader located in dependencies/.
$gdmu_site_designer_dependencies_autoloader = __DIR__ . '/dependencies/autoload.php';
if ( file_exists( $gdmu_site_designer_dependencies_autoloader ) ) {
	require $gdmu_site_designer_dependencies_autoloader;
}

// Load dev dependencies autoloader (only present in development environment).
// This includes PHPUnit, Mockery, code standards, etc.
$gdmu_site_designer_vendor_autoloader = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $gdmu_site_designer_vendor_autoloader ) ) {
	require_once $gdmu_site_designer_vendor_autoloader;
}

define( 'GDMU_SITE_DESIGNER_VERSION', '2.0.3' );
define( 'GDMU_SITE_DESIGNER_PATH', __DIR__ );
define( 'GDMU_SITE_DESIGNER_URL', plugins_url( '', __FILE__ ) );
define( 'GDMU_SITE_DESIGNER_PRESENT_OPTION', 'gdmu_site_designer' );

/**
 * Load plugin textdomain.
 *
 * Loads translations from:
 * 1. WP_LANG_DIR/plugins/wp-site-designer-mu-plugins-{locale}.mo (global translations)
 * 2. Plugin's languages directory (bundled translations)
 */
add_action(
	'muplugins_loaded',
	function () {
		// Calculate path relative to WPMU_PLUGIN_DIR.
		$rel_path = str_replace( trailingslashit( WPMU_PLUGIN_DIR ), '', __DIR__ );
		load_muplugin_textdomain( 'wp-site-designer-mu-plugins', $rel_path . '/languages' );
	}
);

$gdmu_site_designer_config = new Config();
$gdmu_site_designer_config->load_from_json( GDMU_SITE_DESIGNER_PATH . '/config/site-designer.json' );

// Compatibility system runs in wp-admin whenever Site Designer is activated,
// regardless of iframe context or native_ui_enabled flag.
add_action(
	'plugins_loaded',
	function () {
		if ( Iframe_Context_Detector::is_plugin_activated() && is_admin() ) {
			Plugin_Compatibility::init();
			Theme_Compatibility::init();
			Compatibility_Notices::init();
			Compatibility_Modal::init();
		}
	},
	0
);

// WP extensions (native UI + design tools) run independently of iframe integration.
// Gated only on native_ui_enabled flag; must not load inside iframe context.
// The flag check MUST run on plugins_loaded (not at MU-plugin load time): this file loads
// before regular plugins, so $GLOBALS['wpaas_feature_flag'] may not exist yet when the
// MU-plugin file is first parsed. Priority 20 runs after typical platform bootstrap hooks.
add_action(
	'plugins_loaded',
	function () use ( $gdmu_site_designer_config ) {
		if ( ! gdmu_site_designer_is_native_ui_enabled() ) {
			return;
		}

		// Early exit if this is an iframe request.
		if ( gdmu_site_designer_is_iframe_request() ) {
			return;
		}

		if ( is_admin() ) {
			FullStory_Tracker::init();
			Editor_Welcome_Guide::init();
		}

		Native_UI_Loader::init( $gdmu_site_designer_config );
		Font_Pairing::init();
		Palette_Switcher::init();
		Style_Kit::init();
		Theme_Reset::init();
		Global_Styles_Sync::init();
		OAuth_Complete::init( $gdmu_site_designer_config );
	},
	20
);

// Early exit if core iframe integration should not run in current context.
if ( ! gdmu_site_designer_should_run() ) {
	return;
}

$gdmu_site_designer_request_validator = new Request_Validator( $gdmu_site_designer_config );
$gdmu_site_designer_request_validator->parse();

// Authentication providers.
$gdmu_site_designer_jwt_auth       = new JWT_Auth( $gdmu_site_designer_config );
$gdmu_site_designer_wp_public_api  = new WP_Public_Api_Client( $gdmu_site_designer_config );
$gdmu_site_designer_signature_auth = new Signature_Auth( $gdmu_site_designer_wp_public_api );

$gdmu_site_designer_api = new Site_Designer_Api(
	$gdmu_site_designer_request_validator,
	$gdmu_site_designer_jwt_auth,
	$gdmu_site_designer_signature_auth
);
$gdmu_site_designer_api->register_endpoints();

$gdmu_site_designer_media_sideload_api = new Media_Sideload_Api(
	$gdmu_site_designer_config,
	$gdmu_site_designer_request_validator
);
$gdmu_site_designer_media_sideload_api->register_endpoints();

add_action(
	'plugins_loaded',
	function () use ( $gdmu_site_designer_request_validator ) {
		// Check if this is a valid iframe request.
		$is_iframe_context = Iframe_Context_Detector::is_valid_request( $gdmu_site_designer_request_validator );
		$is_plugin_active  = Iframe_Context_Detector::is_plugin_activated();
		$is_woo_active     = function_exists( 'WC' );

		// Core functionalities that should run for valid iframe requests.
		if ( $is_iframe_context ) {
			// Enables WordPress to work properly within an iframe (security headers, cookie handling).
			Iframe_Support::init();
			// Hides the WordPress admin bar in iframe context for cleaner UI.
			Hide_Admin_Bar::init();
			// Bridges navigation state changes between iframe and parent window.
			Navigation_Bridge::init();
			// Bridges cookie status and authentication between iframe and parent window.
			Cookie_Status_Bridge::init();
			// Adds Gutenberg customizations for iframe context (content saver, welcome message, status bar).
			Gutenberg_Support::init();
			// Bridges viewport/window size data between iframe and parent window.
			Viewport_Bridge::init();
			// Bridges compatibility status (incompatible plugins/themes) to Site Designer parent window.
			Compatibility_Bridge::init();
			// Enables FullStory session tracker within iframe context.
			FullStory_Iframe_Tracker::init();
			// Handles media upload functionality within iframe context.
			Media_Upload::init();
			// Change highlighter.
			Change_Highlighter::init();
			// GoDaddy Media Library tab for browsing and importing assets via the parent MFE.
			GoDaddy_Media_Tab::init();
		}

		if ( $is_plugin_active ) {
			Safari_Storage_Access::init();
		}

		if ( $is_woo_active ) {
			// Automatically configures WooCommerce and skips setup wizard.
			Woo\Setup::init();
		}
	},
	0
);

Woo\Setup::setup();
