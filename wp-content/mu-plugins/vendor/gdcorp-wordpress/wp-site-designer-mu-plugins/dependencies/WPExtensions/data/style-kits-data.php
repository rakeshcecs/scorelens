<?php
/**
 * Style kit theme.json fragments and bundle mappings.
 *
 * Each kit is a separate file in style-kits/ returning a theme.json fragment
 * passed to WP_Theme_JSON_Data::update_with().
 *
 * Must stay in sync with packages/native-ui/src/data/styleKits.ts (slug list).
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array{style_kits: array<string, array>, kit_bundles: array<string, array{palette: string, fontPairing: string}>}
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	'style_kits'  => array(
		'minimal'   => require __DIR__ . '/style-kits/minimal.php',
		'classic'   => require __DIR__ . '/style-kits/classic.php',
		'bold'      => require __DIR__ . '/style-kits/bold.php',
		'soft'      => require __DIR__ . '/style-kits/soft.php',
		'sharp'     => require __DIR__ . '/style-kits/sharp.php',
		'playful'   => require __DIR__ . '/style-kits/playful.php',
		'editorial' => require __DIR__ . '/style-kits/editorial.php',
		'modern'    => require __DIR__ . '/style-kits/modern.php',
	),

	/*
	 * Bundled palette and font pairing for each kit.
	 * When a kit is selected, the associated palette and font pairing options
	 * are also set so the full visual identity changes at once.
	 *
	 * Slugs must match keys in Palette_Switcher::PALETTES and Font_Pairing::PAIRINGS.
	 */
	'kit_bundles' => array(
		'minimal'   => array(
			'palette'     => 'monochrome',
			'fontPairing' => 'minimalist',
		),
		'classic'   => array(
			'palette'     => 'classic',
			'fontPairing' => 'classic-serif',
		),
		'bold'      => array(
			'palette'     => 'bold',
			'fontPairing' => 'bold-impact',
		),
		'soft'      => array(
			'palette'     => 'coastal',
			'fontPairing' => 'humanist',
		),
		'sharp'     => array(
			'palette'     => 'midnight',
			'fontPairing' => 'tech',
		),
		'playful'   => array(
			'palette'     => 'playful',
			'fontPairing' => 'playful',
		),
		'editorial' => array(
			'palette'     => 'luxurious',
			'fontPairing' => 'editorial',
		),
		'modern'    => array(
			'palette'     => 'modern',
			'fontPairing' => 'modern-sans',
		),
	),

);
