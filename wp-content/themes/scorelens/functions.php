<?php
/**
 * ScoreLens Theme Functions
 *
 * @package ScoreLens
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ─────────────────────────────────────────────
 * Constants
 * ───────────────────────────────────────────── */
define( 'SCORELENS_VERSION', '2.0.0' );
define( 'SCORELENS_DIR',     get_template_directory() );
define( 'SCORELENS_URI',     get_template_directory_uri() );

/* ─────────────────────────────────────────────
 * Theme Setup
 * ───────────────────────────────────────────── */
function scorelens_setup() {
	load_theme_textdomain( 'scorelens', SCORELENS_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'style', 'script',
	] );

	add_theme_support( 'custom-logo', [
		'height'               => 40,
		'width'                => 160,
		'flex-height'          => true,
		'flex-width'           => true,
		'unlink-homepage-logo' => true,
	] );

	/* Navigation menus — footer is now 2 columns: Product + Company */
	register_nav_menus( [
		'sl-primary'  => esc_html__( 'Primary Navigation', 'scorelens' ),
		'sl-footer-1' => esc_html__( 'Footer: Product',   'scorelens' ),
		'sl-footer-2' => esc_html__( 'Footer: Company',   'scorelens' ),
	] );
}
add_action( 'after_setup_theme', 'scorelens_setup' );

/* ─────────────────────────────────────────────
 * Content Width
 * ───────────────────────────────────────────── */
function scorelens_content_width() {
	$GLOBALS['content_width'] = 1280;
}
add_action( 'after_setup_theme', 'scorelens_content_width', 0 );

/* ─────────────────────────────────────────────
 * Enqueue Assets
 * ───────────────────────────────────────────── */
function scorelens_enqueue_assets() {

	/* Google Fonts */
	wp_enqueue_style(
		'scorelens-fonts',
		'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&display=swap',
		[],
		null
	);

	/* Main stylesheet */
	wp_enqueue_style(
		'scorelens-main',
		SCORELENS_URI . '/assets/css/scorelens.css',
		[ 'scorelens-fonts' ],
		SCORELENS_VERSION
	);

	/* Main script — deferred in footer */
	wp_enqueue_script(
		'scorelens-main',
		SCORELENS_URI . '/assets/js/scorelens.js',
		[],
		SCORELENS_VERSION,
		[ 'strategy' => 'defer', 'in_footer' => true ]
	);
}
add_action( 'wp_enqueue_scripts', 'scorelens_enqueue_assets' );

/* ─────────────────────────────────────────────
 * Resource Hints — preconnect for Google Fonts
 * ───────────────────────────────────────────── */
function scorelens_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = [ 'href' => 'https://fonts.googleapis.com' ];
		$hints[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' ];
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'scorelens_resource_hints', 10, 2 );

/* ─────────────────────────────────────────────
 * Anti-FOUC: read theme preference from
 * localStorage before CSS renders so the
 * correct data-theme attribute is set instantly.
 * ───────────────────────────────────────────── */
function scorelens_theme_preference_script() {
	echo "<script>
(function(){
	try{
		var t=localStorage.getItem('scorelens-theme');
		if(t==='dark'||t==='light'){
			document.documentElement.setAttribute('data-theme',t);
		}
	}catch(e){}
})();
</script>\n";
}
add_action( 'wp_head', 'scorelens_theme_preference_script', 1 );

/* ─────────────────────────────────────────────
 * Primary Nav Fallback
 * ───────────────────────────────────────────── */
function scorelens_primary_nav_fallback() {
	$links = [
		'#sl-features' => __( 'Features',     'scorelens' ),
		'#sl-how'      => __( 'How it works', 'scorelens' ),
		'#sl-pricing'  => __( 'Pricing',      'scorelens' ),
		'#sl-faq'      => __( 'FAQ',          'scorelens' ),
	];
	foreach ( $links as $href => $label ) {
		printf(
			'<a href="%s">%s</a>',
			esc_attr( $href ),
			esc_html( $label )
		);
	}
}

/* ─────────────────────────────────────────────
 * Footer Nav Fallback helper
 * ───────────────────────────────────────────── */
function scorelens_footer_nav_fallback( array $items ) {
	foreach ( $items as $href => $label ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_attr( $href ),
			esc_html( $label )
		);
	}
}

/* ─────────────────────────────────────────────
 * Walker: strips <ul> wrapper so links sit
 * directly inside their container div — used
 * for the primary nav links.
 * ───────────────────────────────────────────── */
class ScoreLens_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item     = $data_object;
		$atts     = [];
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts_str = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$atts_str .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}
		$output .= '<a' . $atts_str . '>'
			. apply_filters( 'the_title', $item->title, $item->ID )
			. '</a>';
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}
