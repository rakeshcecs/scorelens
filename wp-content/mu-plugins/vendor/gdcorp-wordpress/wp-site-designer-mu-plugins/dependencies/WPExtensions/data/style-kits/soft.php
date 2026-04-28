<?php
/**
 * Soft style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── SOFT ──────────────────────────────────────────────────
 * Dreamy SaaS aesthetic. Everything rounded, blur shadows,
 * generous whitespace, lightweight headings. Cloud-like.
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
						'max' => '2.75rem',
					),
				),
				array(
					'slug'  => 'xx-large',
					'size'  => '2rem',
					'name'  => 'XXL',
					'fluid' => array(
						'min' => '2rem',
						'max' => '3.75rem',
					),
				),
				array(
					'slug'  => 'xxx-large',
					'size'  => '2.5rem',
					'name'  => 'XXXL',
					'fluid' => array(
						'min' => '2.5rem',
						'max' => '4.75rem',
					),
				),
			),
		),
		'spacing'    => array(
			'spacingSizes' => array(
				array(
					'slug' => '20',
					'size' => '0.75rem',
					'name' => 'XS',
				),
				array(
					'slug' => '30',
					'size' => '1.5rem',
					'name' => 'S',
				),
				array(
					'slug' => '40',
					'size' => '2.5rem',
					'name' => 'M',
				),
				array(
					'slug' => '50',
					'size' => '4rem',
					'name' => 'L',
				),
				array(
					'slug' => '60',
					'size' => '6.5rem',
					'name' => 'XL',
				),
				array(
					'slug' => '70',
					'size' => '10rem',
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
		'typography' => array( 'lineHeight' => '1.6' ),
		'elements'   => array(
			'button'  => array(
				'border'     => array(
					'radius' => '9999px',
					'style'  => 'none',
					'width'  => '0px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-1)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '0.875rem',
						'bottom' => '0.875rem',
						'left'   => '2.25rem',
						'right'  => '2.25rem',
					),
				),
				'typography' => array(
					'fontWeight'    => '400',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
					'fontSize'      => 'inherit',
				),
			),
			'link'    => array(
				'typography' => array(
					'textDecoration'      => 'none',
					'textDecorationStyle' => 'initial',
					'fontWeight'          => '400',
				),
				':hover'     => array( 'typography' => array( 'textDecoration' => 'underline' ) ),
			),
			'heading' => array(
				'typography' => array(
					'fontWeight'    => '300',
					'letterSpacing' => '0em',
					'lineHeight'    => '1.2',
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
							'style'  => 'none',
							'width'  => '0px',
						),
						'color'   => array(
							'background' => 'var(--wp--preset--color--accent-1)',
							'text'       => 'var(--wp--preset--color--base)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.875rem',
								'bottom' => '0.875rem',
								'left'   => '2.25rem',
								'right'  => '2.25rem',
							),
						),
					),
					'outline' => array(
						'border'  => array(
							'radius' => '9999px',
							'style'  => 'solid',
							'width'  => '1px',
						),
						'color'   => array(
							'background' => 'transparent',
							'text'       => 'var(--wp--preset--color--contrast)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.875rem',
								'bottom' => '0.875rem',
								'left'   => '2.25rem',
								'right'  => '2.25rem',
							),
						),
					),
				),
			),
			'core/image'     => array(
				'border' => array(
					'radius' => '24px',
					'width'  => '0px',
					'style'  => 'none',
				),
			),
			'core/separator' => array(
				'border' => array(
					'width' => '1px',
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
						'width' => '0px',
						'style' => 'none',
					),
					'radius' => '16px',
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
					'fontStyle'     => 'italic',
					'fontWeight'    => '300',
					'fontSize'      => 'inherit',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
				),
			),
			'core/cover'     => array(
				'spacing'    => array(
					'padding' => array(
						'top'    => '6rem',
						'bottom' => '6rem',
					),
				),
				'dimensions' => array( 'minHeight' => '450px' ),
				'border'     => array( 'radius' => '24px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '2.5rem' ),
			),
		),
		'css'        => '.wp-element-button,.wp-block-button__link{box-shadow:0 8px 30px rgba(0,0,0,0.12);} .wp-block-image img{box-shadow:0 12px 40px rgba(0,0,0,0.1);} .wp-block-cover{overflow:hidden;}',
	),
);
