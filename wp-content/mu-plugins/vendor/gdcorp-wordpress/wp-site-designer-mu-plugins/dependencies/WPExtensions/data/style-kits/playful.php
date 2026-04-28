<?php
/**
 * Playful style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── PLAYFUL ───────────────────────────────────────────────
 * Creative agency energy. Oversized type, big rounded corners,
 * retro layered shadows, very loose spacing. Fun & bouncy.
 */
return array(
	'version'  => 2,
	'settings' => array(
		'typography' => array(
			'fontSizes' => array(
				array(
					'slug' => 'small',
					'size' => '1rem',
					'name' => 'Small',
				),
				array(
					'slug' => 'medium',
					'size' => '1.125rem',
					'name' => 'Medium',
				),
				array(
					'slug'  => 'large',
					'size'  => '1.375rem',
					'name'  => 'Large',
					'fluid' => array(
						'min' => '1.375rem',
						'max' => '2rem',
					),
				),
				array(
					'slug'  => 'x-large',
					'size'  => '1.75rem',
					'name'  => 'XL',
					'fluid' => array(
						'min' => '1.75rem',
						'max' => '3rem',
					),
				),
				array(
					'slug'  => 'xx-large',
					'size'  => '2.5rem',
					'name'  => 'XXL',
					'fluid' => array(
						'min' => '2.5rem',
						'max' => '4.5rem',
					),
				),
				array(
					'slug'  => 'xxx-large',
					'size'  => '3.5rem',
					'name'  => 'XXXL',
					'fluid' => array(
						'min' => '3.5rem',
						'max' => '7rem',
					),
				),
			),
		),
		'spacing'    => array(
			'spacingSizes' => array(
				array(
					'slug' => '20',
					'size' => '1rem',
					'name' => 'XS',
				),
				array(
					'slug' => '30',
					'size' => '1.75rem',
					'name' => 'S',
				),
				array(
					'slug' => '40',
					'size' => '3rem',
					'name' => 'M',
				),
				array(
					'slug' => '50',
					'size' => '5rem',
					'name' => 'L',
				),
				array(
					'slug' => '60',
					'size' => '8rem',
					'name' => 'XL',
				),
				array(
					'slug' => '70',
					'size' => '12rem',
					'name' => 'XXL',
				),
			),
		),
		'layout'     => array(
			'contentSize' => '1280px',
			'wideSize'    => '1400px',
		),
	),
	'styles'   => array(
		'typography' => array( 'lineHeight' => '1.6' ),
		'elements'   => array(
			'button'  => array(
				'border'     => array(
					'radius' => '9999px',
					'style'  => 'solid',
					'width'  => '3px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-1)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '1rem',
						'bottom' => '1rem',
						'left'   => '2.5rem',
						'right'  => '2.5rem',
					),
				),
				'typography' => array(
					'fontWeight'    => '700',
					'fontSize'      => '1.125rem',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
				),
			),
			'link'    => array(
				'typography' => array(
					'textDecoration'      => 'underline',
					'textDecorationStyle' => 'wavy',
					'fontWeight'          => '400',
				),
				':hover'     => array( 'typography' => array( 'textDecoration' => 'none' ) ),
			),
			'heading' => array(
				'typography' => array(
					'fontWeight'    => '800',
					'letterSpacing' => '-0.03em',
					'lineHeight'    => '1.05',
					'textTransform' => 'none',
				),
			),
		),
		'blocks'     => array(
			'core/button'    => array(
				'border'     => array(
					'radius' => '9999px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-1)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'variations' => array(
					'fill'    => array(
						'border'  => array(
							'radius' => '9999px',
							'style'  => 'solid',
							'width'  => '3px',
						),
						'color'   => array(
							'background' => 'var(--wp--preset--color--accent-1)',
							'text'       => 'var(--wp--preset--color--base)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '1rem',
								'bottom' => '1rem',
								'left'   => '2.5rem',
								'right'  => '2.5rem',
							),
						),
					),
					'outline' => array(
						'border'  => array(
							'radius' => '9999px',
							'style'  => 'solid',
							'width'  => '3px',
						),
						'color'   => array(
							'background' => 'transparent',
							'text'       => 'var(--wp--preset--color--contrast)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '1rem',
								'bottom' => '1rem',
								'left'   => '2.5rem',
								'right'  => '2.5rem',
							),
						),
					),
				),
			),
			'core/image'     => array(
				'border' => array(
					'radius' => '20px',
					'width'  => '0px',
					'style'  => 'none',
				),
			),
			'core/separator' => array(
				'border' => array(
					'width' => '3px',
					'style' => 'dashed',
				),
			),
			'core/quote'     => array(
				'border'     => array(
					'top'    => array(
						'width' => '3px',
						'style' => 'solid',
					),
					'right'  => array(
						'width' => '3px',
						'style' => 'solid',
					),
					'bottom' => array(
						'width' => '3px',
						'style' => 'solid',
					),
					'left'   => array(
						'width' => '3px',
						'style' => 'solid',
					),
					'radius' => '20px',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '2rem',
						'bottom' => '2rem',
						'left'   => '2rem',
						'right'  => '2rem',
					),
				),
				'typography' => array(
					'fontStyle'     => 'normal',
					'fontWeight'    => '600',
					'fontSize'      => '1.25rem',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
				),
			),
			'core/cover'     => array(
				'spacing'    => array(
					'padding' => array(
						'top'    => '8rem',
						'bottom' => '8rem',
					),
				),
				'dimensions' => array( 'minHeight' => '550px' ),
				'border'     => array( 'radius' => '20px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '3rem' ),
			),
		),
		'css'        => '.wp-block-button__link{transition:transform 0.15s ease,box-shadow 0.15s ease;} .wp-element-button,.wp-block-button__link{box-shadow:4px 4px 0 currentColor;} .wp-element-button:hover,.wp-block-button__link:hover{box-shadow:2px 2px 0 currentColor;transform:translate(2px,2px);} .wp-block-image img{box-shadow:6px 6px 0 rgba(0,0,0,0.15);} .wp-block-cover{overflow:hidden;} .entry-content h2::after{content:"";display:block;width:100%;height:3px;background:currentColor;border-radius:3px;margin-top:0.5rem;}',
	),
);
