<?php
/**
 * Modern style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── MODERN ────────────────────────────────────────────────
 * Clean contemporary confidence. Medium radius, blur shadow,
 * balanced proportions. The "safe upgrade" that still feels fresh.
 */
return array(
	'version'  => 2,
	'settings' => array(
		'typography' => array(
			'fontSizes' => array(
				array(
					'slug' => 'small',
					'size' => '0.875rem',
					'name' => 'Small',
				),
				array(
					'slug' => 'medium',
					'size' => '1rem',
					'name' => 'Medium',
				),
				array(
					'slug'  => 'large',
					'size'  => '1.25rem',
					'name'  => 'Large',
					'fluid' => array(
						'min' => '1.25rem',
						'max' => '1.75rem',
					),
				),
				array(
					'slug'  => 'x-large',
					'size'  => '1.5rem',
					'name'  => 'XL',
					'fluid' => array(
						'min' => '1.5rem',
						'max' => '2.5rem',
					),
				),
				array(
					'slug'  => 'xx-large',
					'size'  => '2rem',
					'name'  => 'XXL',
					'fluid' => array(
						'min' => '2rem',
						'max' => '3.5rem',
					),
				),
				array(
					'slug'  => 'xxx-large',
					'size'  => '2.5rem',
					'name'  => 'XXXL',
					'fluid' => array(
						'min' => '2.5rem',
						'max' => '5rem',
					),
				),
			),
		),
		'spacing'    => array(
			'spacingSizes' => array(
				array(
					'slug' => '20',
					'size' => '0.5rem',
					'name' => 'XS',
				),
				array(
					'slug' => '30',
					'size' => '1.25rem',
					'name' => 'S',
				),
				array(
					'slug' => '40',
					'size' => '2rem',
					'name' => 'M',
				),
				array(
					'slug' => '50',
					'size' => '3rem',
					'name' => 'L',
				),
				array(
					'slug' => '60',
					'size' => '5rem',
					'name' => 'XL',
				),
				array(
					'slug' => '70',
					'size' => '7.5rem',
					'name' => 'XXL',
				),
			),
		),
		'layout'     => array(
			'contentSize' => '1200px',
			'wideSize'    => '1320px',
		),
	),
	'styles'   => array(
		'typography' => array( 'lineHeight' => '1.65' ),
		'elements'   => array(
			'button'  => array(
				'border'     => array(
					'radius' => '12px',
					'style'  => 'none',
					'width'  => '0px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-3)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '0.75rem',
						'bottom' => '0.75rem',
						'left'   => '1.75rem',
						'right'  => '1.75rem',
					),
				),
				'typography' => array(
					'fontWeight'    => '600',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
					'fontSize'      => 'inherit',
				),
			),
			'link'    => array(
				'typography' => array(
					'textDecoration'      => 'underline',
					'textDecorationStyle' => 'initial',
					'fontWeight'          => '400',
				),
				':hover'     => array( 'typography' => array( 'textDecoration' => 'none' ) ),
			),
			'heading' => array(
				'typography' => array(
					'fontWeight'    => '600',
					'letterSpacing' => '-0.02em',
					'lineHeight'    => '1.15',
					'textTransform' => 'none',
				),
			),
		),
		'blocks'     => array(
			'core/button'    => array(
				'border'     => array(
					'radius' => '12px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-3)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'variations' => array(
					'fill'    => array(
						'border'  => array(
							'radius' => '12px',
							'style'  => 'none',
							'width'  => '0px',
						),
						'color'   => array(
							'background' => 'var(--wp--preset--color--accent-3)',
							'text'       => 'var(--wp--preset--color--base)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.75rem',
								'bottom' => '0.75rem',
								'left'   => '1.75rem',
								'right'  => '1.75rem',
							),
						),
					),
					'outline' => array(
						'border'  => array(
							'radius' => '12px',
							'style'  => 'solid',
							'width'  => '1px',
						),
						'color'   => array(
							'background' => 'transparent',
							'text'       => 'var(--wp--preset--color--contrast)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.75rem',
								'bottom' => '0.75rem',
								'left'   => '1.75rem',
								'right'  => '1.75rem',
							),
						),
					),
				),
			),
			'core/image'     => array(
				'border' => array(
					'radius' => '12px',
					'width'  => '0px',
					'style'  => 'none',
				),
			),
			'core/separator' => array(
				'border' => array(
					'width' => '2px',
					'style' => 'solid',
				),
			),
			'core/quote'     => array(
				'border'     => array(
					'top'    => array(
						'width' => '0px',
						'style' => 'none',
					),
					'right'  => array(
						'width' => '0px',
						'style' => 'none',
					),
					'bottom' => array(
						'width' => '0px',
						'style' => 'none',
					),
					'left'   => array(
						'width' => '4px',
						'style' => 'solid',
					),
					'radius' => '0px',
				),
				'spacing'    => array(
					'padding' => array( 'left' => '1.5rem' ),
				),
				'typography' => array(
					'fontStyle'     => 'italic',
					'fontWeight'    => '400',
					'fontSize'      => 'inherit',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
				),
			),
			'core/cover'     => array(
				'spacing'    => array(
					'padding' => array(
						'top'    => '5rem',
						'bottom' => '5rem',
					),
				),
				'dimensions' => array( 'minHeight' => '400px' ),
				'border'     => array( 'radius' => '12px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '2rem' ),
			),
		),
		'css'        => '.wp-block-button__link{transition:transform 0.15s ease,box-shadow 0.15s ease;} .wp-element-button,.wp-block-button__link{box-shadow:0 4px 14px rgba(0,0,0,0.15);} .wp-element-button:hover,.wp-block-button__link:hover{box-shadow:0 6px 20px rgba(0,0,0,0.2);transform:translateY(-1px);} .wp-block-image img{box-shadow:0 4px 20px rgba(0,0,0,0.08);} .wp-block-cover{overflow:hidden;}',
	),
);
