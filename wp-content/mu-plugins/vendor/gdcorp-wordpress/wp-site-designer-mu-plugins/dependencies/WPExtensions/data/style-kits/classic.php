<?php
/**
 * Classic style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── CLASSIC ───────────────────────────────────────────────
 * Traditional, refined. Small radius, subtle offset shadow,
 * standard proportions with a bookish feel.
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
						'max' => '4.5rem',
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
					'size' => '1rem',
					'name' => 'S',
				),
				array(
					'slug' => '40',
					'size' => '1.5rem',
					'name' => 'M',
				),
				array(
					'slug' => '50',
					'size' => '2.5rem',
					'name' => 'L',
				),
				array(
					'slug' => '60',
					'size' => '4rem',
					'name' => 'XL',
				),
				array(
					'slug' => '70',
					'size' => '6rem',
					'name' => 'XXL',
				),
			),
		),
		'layout'     => array(
			'contentSize' => '1140px',
			'wideSize'    => '1200px',
		),
	),
	'styles'   => array(
		'typography' => array( 'lineHeight' => '1.7' ),
		'elements'   => array(
			'button'  => array(
				'border'     => array(
					'radius' => '4px',
					'style'  => 'solid',
					'width'  => '1px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-1)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '0.625rem',
						'bottom' => '0.625rem',
						'left'   => '1.5rem',
						'right'  => '1.5rem',
					),
				),
				'typography' => array(
					'fontWeight'    => '500',
					'textTransform' => 'none',
					'letterSpacing' => '0.01em',
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
					'letterSpacing' => '0.01em',
					'lineHeight'    => '1.25',
					'textTransform' => 'none',
				),
			),
		),
		'blocks'     => array(
			'core/button'    => array(
				'border'     => array(
					'radius' => '4px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-1)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'variations' => array(
					'fill'    => array(
						'border'  => array(
							'radius' => '4px',
							'style'  => 'solid',
							'width'  => '1px',
						),
						'color'   => array(
							'background' => 'var(--wp--preset--color--accent-1)',
							'text'       => 'var(--wp--preset--color--base)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.625rem',
								'bottom' => '0.625rem',
								'left'   => '1.5rem',
								'right'  => '1.5rem',
							),
						),
					),
					'outline' => array(
						'border'  => array(
							'radius' => '4px',
							'style'  => 'solid',
							'width'  => '1px',
						),
						'color'   => array(
							'background' => 'transparent',
							'text'       => 'var(--wp--preset--color--contrast)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.625rem',
								'bottom' => '0.625rem',
								'left'   => '1.5rem',
								'right'  => '1.5rem',
							),
						),
					),
				),
			),
			'core/image'     => array(
				'border' => array(
					'radius' => '4px',
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
						'width' => '3px',
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
				'border'     => array( 'radius' => '0px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '1.5rem' ),
			),
		),
		'css'        => '.wp-element-button,.wp-block-button__link{box-shadow:2px 2px 0 rgba(0,0,0,0.1);} .entry-content h2::after{content:"";display:block;width:3rem;height:2px;background:currentColor;margin-top:0.75rem;opacity:0.25;} .entry-content h2.has-text-align-center::after{margin-inline:auto;} .entry-content h2.has-text-align-right::after{margin-inline-start:auto;}',
	),
);
