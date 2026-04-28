<?php
/**
 * Native UI Loader
 *
 * Loads the Site Designer native UI React app from CDN and injects
 * the configuration needed by the front-end.
 *
 * CDN URL: Config cdn_url from site-designer.json per environment.
 *
 * @see $wp_deps in enqueue_assets() — must match @wordpress/* imports in native-ui.
 *
 * @package wp-site-designer-mu-plugins
 */

declare( strict_types=1 );

namespace GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions;

use GoDaddy\WordPress\Plugins\SiteDesigner\Dependencies\WPExtensions\Utils\CDN_Version_Override;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues the React native UI assets from CDN and renders the mount point.
 */
class Native_UI_Loader {

	/**
	 * Minimum capability required to access the chat panel.
	 * Uses 'edit_posts' to allow editors and above to use AI features.
	 */
	private const REQUIRED_CAPABILITY = 'edit_posts';

	/**
	 * Plugin configuration.
	 *
	 * @var object
	 */
	private object $config;

	/**
	 * Constructor.
	 *
	 * @param object $config Plugin configuration instance.
	 */
	public function __construct( object $config ) {
		$this->config = $config;
	}

	/**
	 * Initialize the class and register hooks.
	 *
	 * @param object $config Plugin configuration instance.
	 * @return void
	 */
	public static function init( object $config ): void {
		$instance = new self( $config );
		add_action( 'admin_head', array( $instance, 'print_early_panel_class' ), 1 );
		add_action( 'wp_head', array( $instance, 'print_early_panel_class' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $instance, 'enqueue_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $instance, 'enqueue_assets' ) );
		add_action( 'admin_bar_menu', array( $instance, 'add_admin_bar_item' ), 80 );
		add_action( 'admin_bar_menu', array( $instance, 'add_version_override_indicator' ), 81 );

		// Add sdui-panel-open class to <html> server-side (like WP adds admin-bar).
		if ( self::is_panel_open() ) {
			add_filter( 'language_attributes', array( $instance, 'add_panel_open_class' ) );
			add_action( 'wp_footer', array( $instance, 'render_panel_placeholder' ) );
			add_action( 'admin_footer', array( $instance, 'render_panel_placeholder' ) );
		}
	}

	/**
	 * Check if the chat panel was left open by reading the cookie set by JS.
	 *
	 * @return bool
	 */
	private static function is_panel_open(): bool {
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Boolean cookie check, value not used.
		return isset( $_COOKIE['sdui_panel_open'] ) && '1' === $_COOKIE['sdui_panel_open'];
	}

	/**
	 * Append sdui-panel-open to the <html> language_attributes output,
	 * so the class is in the initial HTML like WP's admin-bar class.
	 *
	 * @param string $output The existing language attributes.
	 * @return string
	 */
	public function add_panel_open_class( string $output ): string {
		if ( strpos( $output, 'class="' ) !== false ) {
			return str_replace( 'class="', 'class="sdui-panel-open ', $output );
		}
		return $output . ' class="sdui-panel-open"';
	}

	/**
	 * Render the panel placeholder div in the footer so it's in the
	 * initial HTML, no JS needed.
	 *
	 * @return void
	 */
	public function render_panel_placeholder(): void {
		echo '<div id="sdui-panel-placeholder"></div>';
	}

	/**
	 * Print an inline script in <head> that restores the panel-open class
	 * on <html> before the first paint, preventing a layout shift when the
	 * panel was left open on the previous page.
	 *
	 * @return void
	 */
	public function print_early_panel_class(): void {
		$ai_action = $this->get_effective_action();
		if ( in_array( $ai_action, array( 'generate', 'migrate', 'refresh' ), true ) ) {
			?>
			<style>html.sdui-fullscreen,html.sdui-fullscreen body{overflow:hidden!important;height:100%}html.sdui-fullscreen body{font-family:"GD Sherpa",Helvetica,Arial,sans-serif!important;background:transparent!important}html.sdui-fullscreen #wpwrap{display:none!important}</style>
			<script>try{localStorage.removeItem('site-designer-ui-panel-open');var d=document.documentElement;d.classList.remove('sdui-panel-open');d.classList.add('sdui-fullscreen')}catch(e){}</script>
			<?php
			return;
		}
		?>
		<style>html.sdui-panel-open body:not(.wp-admin){margin-right:400px}html.sdui-panel-open #wpcontent,html.sdui-panel-open #wpfooter{margin-right:400px}html.sdui-panel-open body:not(.wp-admin):not(.block-editor-page) header.wp-block-template-part{right:400px}#sdui-panel-placeholder{display:none;position:fixed;right:0;top:var(--wp-admin--admin-bar--height,32px);width:400px;height:calc(100dvh - var(--wp-admin--admin-bar--height,32px));background:linear-gradient(135deg,#1a1230 0%,#110c1d 100%);z-index:99999}html.sdui-panel-open #sdui-panel-placeholder{display:block}@media(max-width:768px){html.sdui-panel-open body:not(.wp-admin),html.sdui-panel-open #wpcontent,html.sdui-panel-open #wpfooter{margin-right:0}html.sdui-panel-open #sdui-panel-placeholder{display:none}}</style>
		<script>try{if(!document.documentElement.classList.contains('sdui-panel-open')&&localStorage.getItem('site-designer-ui-panel-open')==='true'){document.documentElement.classList.add('sdui-panel-open');document.cookie='sdui_panel_open=1;path=/;max-age=31536000;SameSite=Lax;Secure';document.addEventListener('DOMContentLoaded',function(){if(!document.getElementById('sdui-panel-placeholder')){var p=document.createElement('div');p.id='sdui-panel-placeholder';document.body.appendChild(p)}})}}catch(e){}</script>
		<?php
	}

	/**
	 * Add an "Airo for WordPress" item to the WordPress admin bar.
	 *
	 * Shown on both wp-admin and the frontend. JavaScript toggles
	 * visibility based on panel state (visible only when fully closed).
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar The admin bar instance.
	 * @return void
	 */
	public function add_admin_bar_item( \WP_Admin_Bar $wp_admin_bar ): void {
		if ( ! current_user_can( self::REQUIRED_CAPABILITY ) ) {
			return;
		}
		if ( ! get_option( 'wp_site_designer_activated', false ) ) {
			return;
		}

		$icon = '<svg width="16" height="16" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">'
			. '<path d="M7.5391 9.19528C6.57345 8.30205 5.97949 8.58561 5.97949 8.2028C5.97949 7.81999 6.57345 8.10355 7.5391 7.21032C8.50475 6.31709 8.11772 5.65072 8.53158 5.65072C8.94543 5.65072 8.5584 6.31709 9.52405 7.21032C10.4897 8.10355 11.0837 7.81999 11.0837 8.2028C11.0837 8.58561 10.4897 8.30205 9.52405 9.19528C8.5584 10.0885 8.94543 10.7549 8.53158 10.7549C8.11772 10.7549 8.50475 10.0885 7.5391 9.19528Z" fill="currentColor"/>'
			. '<path d="M10.9014 11.3018C10.2806 10.7275 9.98991 10.8187 9.98991 10.5726C9.98991 10.3265 10.2806 10.4176 10.9014 9.84342C11.5221 9.26921 11.3645 8.93197 11.6305 8.93197C11.8966 8.93197 11.7389 9.26921 12.3597 9.84342C12.9805 10.4176 13.2712 10.3265 13.2712 10.5726C13.2712 10.8187 12.9805 10.7275 12.3597 11.3018C11.7389 11.876 11.8966 12.2132 11.6305 12.2132C11.3645 12.2132 11.5221 11.876 10.9014 11.3018Z" fill="currentColor"/>'
			. '<path d="M11.1444 6.86599C10.7306 6.48318 10.5368 6.54395 10.5368 6.37988C10.5368 6.21582 10.7306 6.27658 11.1444 5.89377C11.5583 5.51096 11.4532 5.28613 11.6305 5.28613C11.8079 5.28613 11.7028 5.51096 12.1166 5.89377C12.5305 6.27658 12.7243 6.21582 12.7243 6.37988C12.7243 6.54395 12.5305 6.48318 12.1166 6.86599C11.7028 7.24881 11.8079 7.47363 11.6305 7.47363C11.4532 7.47363 11.5583 7.24881 11.1444 6.86599Z" fill="currentColor"/>'
			. '<path d="M18.375 19.0312C18.5475 19.0316 18.7175 18.9614 18.8394 18.8394C18.9614 18.7175 19.0316 18.5475 19.0312 18.375L19.0312 5.25043C19.0302 4.38039 18.6841 3.54628 18.0689 2.93107C17.4537 2.31586 16.6196 1.96978 15.7496 1.96875L5.24744 1.96875C4.37822 1.96963 3.54485 2.31528 2.93018 2.92987C2.31551 3.54446 1.96974 4.37779 1.96875 5.24701L1.96875 11.6407C1.96983 12.5099 2.31564 13.3431 2.9303 13.9576C3.54497 14.5721 4.37829 14.9177 5.24744 14.9186L13.9906 14.9186L17.911 18.839C18.0329 18.9609 18.2026 19.0312 18.375 19.0312ZM15.7496 3.28125C16.2716 3.2819 16.7721 3.48958 17.1413 3.85873C17.5104 4.22788 17.7181 4.72837 17.7187 5.25043V16.7908L14.7263 13.7984C14.6032 13.6753 14.4364 13.6062 14.2623 13.6061L5.24744 13.6061C4.72626 13.6056 4.22655 13.3984 3.85795 13.03C3.48934 12.6615 3.28194 12.1619 3.28125 11.6407L3.28125 5.24701C3.28186 4.72577 3.48923 4.22606 3.85784 3.85753C4.22645 3.489 4.7262 3.28175 5.24744 3.28125L15.7496 3.28125Z" fill="currentColor"/>'
			. '</svg>';

		$wp_admin_bar->add_node(
			array(
				'id'     => 'sdui-chat',
				'parent' => 'top-secondary',
				'title'  => '<span class="ab-icon" aria-hidden="true">' . $icon . '</span>'
					. '<span class="ab-label">Airo for WordPress</span>'
					. '<span id="sdui-admin-bar-badge" class="sdui-admin-bar-badge"></span>',
				'href'   => '#',
				'meta'   => array(
					'class' => 'sdui-admin-bar-chat',
				),
			)
		);
	}

	/**
	 * Show an admin bar indicator when a CDN version override is active.
	 *
	 * Visible on both admin and frontend pages. Double-gated: only renders
	 * in non-production AND only when a valid override cookie exists.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar The admin bar instance.
	 * @return void
	 */
	public function add_version_override_indicator( \WP_Admin_Bar $wp_admin_bar ): void {
		if ( 'production' === $this->config->get_env() ) {
			return;
		}

		$override = CDN_Version_Override::get_active();
		if ( ! $override ) {
			return;
		}

		$clear_url = add_query_arg( CDN_Version_Override::PARAM_NAME, '', remove_query_arg( CDN_Version_Override::PARAM_NAME ) );

		$wp_admin_bar->add_node(
			array(
				'id'     => 'sdui-version-override',
				'parent' => 'top-secondary',
				'title'  => '🔀 ' . esc_html( $override ),
				'href'   => esc_url( $clear_url ),
				'meta'   => array(
					'title' => 'SDUI version override active — click to reset',
				),
			)
		);
	}

	/**
	 * Enqueue chat panel JavaScript and CSS from CDN.
	 *
	 * @return void
	 */
	public function enqueue_assets(): void {
		// Gate access to users who can edit content.
		if ( ! current_user_can( self::REQUIRED_CAPABILITY ) ) {
			return;
		}

		// If site not activated, only load for explicit ai-action requests,
		// including brief=expert which implies generate mode.
		// Lazy load native ui until site is generated through our experience.
		$ai_action = $this->get_effective_action();
		if ( ! get_option( 'wp_site_designer_activated', false ) && ! $ai_action ) {
			return;
		}

		$cdn_base = $this->get_cdn_base_url();
		$version  = $this->get_asset_version();

		if ( ! $cdn_base ) {
			return;
		}

		// Expert brief mode uses the WordPress Media Library for brand assets.
		// wp_enqueue_media() loads the required scripts (wp.media) on admin pages.
		if ( is_admin() && 'expert' === $this->get_brief_mode() ) {
			wp_enqueue_media();
		}

		// These dependencies must stay in sync with the @wordpress/* runtime
		// imports used in packages/native-ui/src/. If you add a new
		// @wordpress/* runtime import, add the corresponding handle here.
		$wp_deps = array( 'react-jsx-runtime', 'wp-element' );

		wp_enqueue_script(
			'site-designer-native-ui',
			$cdn_base . '/native-ui.js',
			$wp_deps,
			$version,
			array( 'strategy' => 'defer' )
		);

		add_filter( 'script_loader_tag', array( $this, 'add_load_error_handler' ), 10, 2 );

		wp_enqueue_style(
			'site-designer-native-ui',
			$cdn_base . '/native-ui.css',
			array(),
			$version
		);

		// Inject config as JSON — wp_add_inline_script handles escaping
		// and is semantically correct for structured data (vs wp_localize_script).
		$config = apply_filters( 'wp_site_designer_ui_config', $this->get_config() );
		wp_add_inline_script(
			'site-designer-native-ui',
			'window.siteDesignerChat = ' . wp_json_encode( $config ) . ';',
			'before'
		);
	}

	/**
	 * Add an onerror handler to the native-ui script tag so that WordPress
	 * remains fully usable when the JS artifact fails to load (CDN outage,
	 * missing build, network error).
	 *
	 * @param string $tag    The full <script> tag.
	 * @param string $handle The script handle.
	 * @return string Modified tag with onerror fallback.
	 */
	public function add_load_error_handler( string $tag, string $handle ): string {
		if ( 'site-designer-native-ui' !== $handle ) {
			return $tag;
		}

		$cleanup = "document.documentElement.classList.remove('sdui-fullscreen','sdui-panel-open')";

		return str_replace( '<script ', '<script onerror="' . esc_attr( $cleanup ) . '" ', $tag );
	}

	/**
	 * Resolve the CDN base URL for chat panel assets.
	 *
	 * Constructs a versioned URL: {cdn_domain}/{version}
	 * Version is resolved from: query param override (non-prod) > CDN pointer > fallback constant.
	 *
	 * @return string Base URL without trailing slash, or empty string if unavailable.
	 */
	private function get_cdn_base_url(): string {
		$base = $this->config->get_cdn_url();
		if ( ! $base ) {
			return '';
		}

		$version = CDN_Version_Override::resolve( $this->config->get_env() );
		if ( ! $version ) {
			$version = $this->resolve_cdn_version( $base );
		}

		return $version ? $base . '/' . $version : $base;
	}

	/**
	 * Fetch the active version from the CDN pointer file (current-version.json).
	 *
	 * Result is cached in a WordPress transient for 5 minutes.
	 * Falls back to GDMU_SITE_DESIGNER_VERSION constant on failure.
	 *
	 * @param string $cdn_base The bare CDN domain URL.
	 * @return string Version string, or empty string on failure.
	 */
	private function resolve_cdn_version( string $cdn_base ): string {
		$transient_key = 'sdui_native_ui_cdn_version';
		$cached        = get_transient( $transient_key );
		if ( $cached ) {
			return $cached;
		}

		$response = wp_remote_get(
			$cdn_base . '/current-version.json',
			array( 'timeout' => 3 )
		);

		if ( is_wp_error( $response )
			|| 200 !== wp_remote_retrieve_response_code( $response ) ) {
			// Local/dev: if the CDN doesn't serve current-version.json,
			// assume a dev server serving assets at root (no version path).
			if ( in_array( $this->config->get_env(), array( 'local', 'development' ), true ) ) {
				return '';
			}

			// TODO: Remove fallback once we have a production version.
			$fallback = defined( 'GDMU_SITE_DESIGNER_VERSION' )
				? 'v' . GDMU_SITE_DESIGNER_VERSION
				: 'v1.0.0';
			set_transient( $transient_key, $fallback, MINUTE_IN_SECONDS );
			return $fallback;
		}

		$body    = json_decode( wp_remote_retrieve_body( $response ), true );
		$version = $body['version'] ?? '';

		if ( $version && preg_match( '/^[a-z0-9v][a-z0-9.\-]*$/', $version ) ) {
			set_transient( $transient_key, $version, 5 * MINUTE_IN_SECONDS );
			return $version;
		}

		return '';
	}

	/**
	 * Get the asset version string for cache busting.
	 *
	 * @return string
	 */
	private function get_asset_version(): string {
		if ( defined( 'GDMU_SITE_DESIGNER_VERSION' ) ) {
			return (string) GDMU_SITE_DESIGNER_VERSION;
		}

		return '1.0.0';
	}

	/**
	 * Build the configuration array passed to the React app.
	 *
	 * @return array<string, mixed>
	 */
	private function get_config(): array {
		$website_id = defined( 'GD_ACCOUNT_UID' ) ? (string) GD_ACCOUNT_UID : '';
		$brief_mode = $this->get_brief_mode();
		$action     = $this->get_effective_action();

		return array(
			'apiDomain'            => $this->config->get_api_domain(),
			'apiPathPrefix'        => $this->config->get_api_path_prefix(),
			'wsPathPrefix'         => $this->config->get_ws_path_prefix(),
			'websiteId'            => $website_id,
			'environment'          => $this->config->get_env(),
			'adminUrl'             => admin_url(),
			'restUrl'              => rest_url(),
			'version'              => $this->get_asset_version(),
			'action'               => $action,
			'briefMode'            => $brief_mode,
			'wpRestNonce'          => wp_create_nonce( 'wp_rest' ),
			'activePalette'        => Palette_Switcher::get_active_palette(),
			'activeFontPairing'    => Font_Pairing::get_active_font_pairing(),
			'activeStyleKit'       => Style_Kit::get_active_style_kit(),
			'currentPaletteColors' => self::get_current_palette_colors(),
			'isBlockTheme'         => wp_is_block_theme(),
			'isAdmin'              => is_admin(),
			'siteActivated'        => (bool) get_option( 'wp_site_designer_activated', false ),
			'locale'               => get_user_locale(),
			'bundleBaseUrl'        => $this->get_cdn_base_url(),
			'apmServerUrl'         => $this->config->get_apm_server_url(),
			'isPublished'          => (bool) get_option( 'gdl_site_published', false ),
		);
	}

	/**
	 * Resolve brief mode from query string.
	 *
	 * Expert mode is restricted to wp-admin only — it relies on wp_enqueue_media()
	 * and is not intended for frontend access.
	 *
	 * @return string Sanitized brief mode, currently "expert" or empty string.
	 */
	private function get_brief_mode(): string {
		// Expert mode only works in wp-admin.
		if ( ! is_admin() ) {
			return '';
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only routing parameter.
		$brief = isset( $_GET['brief'] ) ? sanitize_text_field( wp_unslash( $_GET['brief'] ) ) : '';

		return 'expert' === $brief ? 'expert' : '';
	}

	/**
	 * Resolve effective action. brief=expert always maps to generate.
	 *
	 * Must stay aligned with the expert-mode URL contract (brief wins over ai-action;
	 * brief=expert alone satisfies the enqueue gate). See monorepo
	 * docs/design/expert-mode-integration-plan.md (Resolved: brief=expert and ai-action).
	 *
	 * Expert mode is restricted to wp-admin only — it relies on wp_enqueue_media()
	 * and is not intended for frontend access.
	 *
	 * @return string Sanitized action value.
	 */
	private function get_effective_action(): string {
		// Expert mode only works in wp-admin (requires wp.media for brand assets).
		if ( is_admin() && 'expert' === $this->get_brief_mode() ) {
			return 'generate';
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only routing parameter.
		return isset( $_GET['ai-action'] ) ? sanitize_text_field( wp_unslash( $_GET['ai-action'] ) ) : '';
	}

	/**
	 * Read the resolved theme.json color palette and return hex values
	 * keyed by our standard slots (base, contrast, accent1–accent5).
	 *
	 * @return array<string, string> Hex colors keyed by slot name, e.g. ['base' => '#FFFFFF', ...].
	 */
	private static function get_current_palette_colors(): array {
		if ( ! function_exists( 'wp_get_global_settings' ) ) {
			return array();
		}

		$palette = wp_get_global_settings( array( 'color', 'palette' ) );
		if ( empty( $palette ) || ! is_array( $palette ) ) {
			return array();
		}

		// Map theme.json slugs to our config keys.
		$slug_map = array(
			'base'     => 'base',
			'contrast' => 'contrast',
			'accent-1' => 'accent1',
			'accent-2' => 'accent2',
			'accent-3' => 'accent3',
			'accent-4' => 'accent4',
			'accent-5' => 'accent5',
		);

		$colors = array();
		foreach ( $palette as $entry ) {
			if ( isset( $entry['slug'], $entry['color'], $slug_map[ $entry['slug'] ] ) ) {
				$colors[ $slug_map[ $entry['slug'] ] ] = $entry['color'];
			}
		}

		return $colors;
	}
}
