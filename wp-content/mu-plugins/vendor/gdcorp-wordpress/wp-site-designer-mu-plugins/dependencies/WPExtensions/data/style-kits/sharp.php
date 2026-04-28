<?php
/**
 * Sharp style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── SHARP ─────────────────────────────────────────────────
 * Swiss/typographic grid. Zero radius, hairline borders,
 * uppercase tracked headings, tight spacing. Precision.
 */
return array(
	'version'  => 2,
	'settings' => array(
		'typography' => array(
			'fontSizes' => array(
				array(
					'slug' => 'small',
					'size' => '0.8125rem',
					'name' => 'Small',
				),
				array(
					'slug' => 'medium',
					'size' => '0.9375rem',
					'name' => 'Medium',
				),
				array(
					'slug'  => 'large',
					'size'  => '1rem',
					'name'  => 'Large',
					'fluid' => array(
						'min' => '1rem',
						'max' => '1.5rem',
					),
				),
				array(
					'slug'  => 'x-large',
					'size'  => '1.25rem',
					'name'  => 'XL',
					'fluid' => array(
						'min' => '1.25rem',
						'max' => '2rem',
					),
				),
				array(
					'slug'  => 'xx-large',
					'size'  => '1.5rem',
					'name'  => 'XXL',
					'fluid' => array(
						'min' => '1.5rem',
						'max' => '3rem',
					),
				),
				array(
					'slug'  => 'xxx-large',
					'size'  => '2rem',
					'name'  => 'XXXL',
					'fluid' => array(
						'min' => '2rem',
						'max' => '4rem',
					),
				),
			),
		),
		'spacing'    => array(
			'spacingSizes' => array(
				array(
					'slug' => '20',
					'size' => '0.25rem',
					'name' => 'XS',
				),
				array(
					'slug' => '30',
					'size' => '0.5rem',
					'name' => 'S',
				),
				array(
					'slug' => '40',
					'size' => '1rem',
					'name' => 'M',
				),
				array(
					'slug' => '50',
					'size' => '1.75rem',
					'name' => 'L',
				),
				array(
					'slug' => '60',
					'size' => '3rem',
					'name' => 'XL',
				),
				array(
					'slug' => '70',
					'size' => '4.5rem',
					'name' => 'XXL',
				),
			),
		),
		'layout'     => array(
			'contentSize' => '1140px',
			'wideSize'    => '1140px',
		),
	),
	'styles'   => array(
		'typography' => array( 'lineHeight' => '1.5' ),
		'elements'   => array(
			'button'  => array(
				'border'     => array(
					'radius' => '0px',
					'style'  => 'solid',
					'width'  => '1px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-1)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '0.5rem',
						'bottom' => '0.5rem',
						'left'   => '1.25rem',
						'right'  => '1.25rem',
					),
				),
				'typography' => array(
					'fontWeight'    => '400',
					'textTransform' => 'uppercase',
					'letterSpacing' => '0.1em',
					'fontSize'      => '0.75rem',
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
					'fontWeight'    => '400',
					'textTransform' => 'uppercase',
					'letterSpacing' => '0.08em',
					'lineHeight'    => '1.15',
				),
			),
		),
		'blocks'     => array(
			'core/button'    => array(
				'border'     => array(
					'radius' => '0px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--accent-1)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'variations' => array(
					'fill'    => array(
						'border'  => array(
							'radius' => '0px',
							'style'  => 'solid',
							'width'  => '1px',
						),
						'color'   => array(
							'background' => 'var(--wp--preset--color--accent-1)',
							'text'       => 'var(--wp--preset--color--base)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.5rem',
								'bottom' => '0.5rem',
								'left'   => '1.25rem',
								'right'  => '1.25rem',
							),
						),
					),
					'outline' => array(
						'border'  => array(
							'radius' => '0px',
							'style'  => 'solid',
							'width'  => '1px',
						),
						'color'   => array(
							'background' => 'transparent',
							'text'       => 'var(--wp--preset--color--contrast)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.5rem',
								'bottom' => '0.5rem',
								'left'   => '1.25rem',
								'right'  => '1.25rem',
							),
						),
					),
				),
			),
			'core/image'     => array(
				'border' => array(
					'radius' => '0px',
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
						'width' => '1px',
						'style' => 'solid',
					),
					'radius' => '0px',
				),
				'spacing'    => array(
					'padding' => array( 'left' => '1.25rem' ),
				),
				'typography' => array(
					'fontStyle'     => 'normal',
					'fontWeight'    => '400',
					'fontSize'      => '0.875rem',
					'textTransform' => 'uppercase',
					'letterSpacing' => '0.03em',
				),
			),
			'core/cover'     => array(
				'spacing'    => array(
					'padding' => array(
						'top'    => '4rem',
						'bottom' => '4rem',
					),
				),
				'dimensions' => array( 'minHeight' => '350px' ),
				'border'     => array( 'radius' => '0px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '0.75rem' ),
			),
		),
		'css'        => '.entry-content h2::after{content:"";display:block;width:2rem;height:1px;background:currentColor;margin-top:0.75rem;} .entry-content h2.has-text-align-center::after{margin-inline:auto;} .entry-content h2.has-text-align-right::after{margin-inline-start:auto;}',
	),
);
