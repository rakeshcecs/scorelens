<?php
/**
 * Editorial style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── EDITORIAL ─────────────────────────────────────────────
 * Luxury magazine. Ghost/outline buttons, condensed type,
 * uppercase tracked headings, razor-thin borders. Haute.
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
					'size'  => '1.125rem',
					'name'  => 'Large',
					'fluid' => array(
						'min' => '1.125rem',
						'max' => '1.625rem',
					),
				),
				array(
					'slug'  => 'x-large',
					'size'  => '1.375rem',
					'name'  => 'XL',
					'fluid' => array(
						'min' => '1.375rem',
						'max' => '2.25rem',
					),
				),
				array(
					'slug'  => 'xx-large',
					'size'  => '1.75rem',
					'name'  => 'XXL',
					'fluid' => array(
						'min' => '1.75rem',
						'max' => '3.5rem',
					),
				),
				array(
					'slug'  => 'xxx-large',
					'size'  => '2.25rem',
					'name'  => 'XXXL',
					'fluid' => array(
						'min' => '2.25rem',
						'max' => '5.5rem',
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
					'size' => '1.75rem',
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
			'contentSize' => '1080px',
			'wideSize'    => '1280px',
		),
	),
	'styles'   => array(
		'typography' => array( 'lineHeight' => '1.65' ),
		'elements'   => array(
			'button'  => array(
				'border'     => array(
					'radius' => '0px',
					'style'  => 'solid',
					'width'  => '1px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--contrast)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '0.75rem',
						'bottom' => '0.75rem',
						'left'   => '2rem',
						'right'  => '2rem',
					),
				),
				'typography' => array(
					'textTransform' => 'uppercase',
					'letterSpacing' => '0.15em',
					'fontSize'      => '0.6875rem',
					'fontWeight'    => '500',
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
					'fontWeight'    => '200',
					'textTransform' => 'uppercase',
					'letterSpacing' => '0.12em',
					'lineHeight'    => '1.1',
				),
			),
		),
		'blocks'     => array(
			'core/button'    => array(
				'border'     => array(
					'radius' => '0px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--contrast)',
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
							'background' => 'var(--wp--preset--color--contrast)',
							'text'       => 'var(--wp--preset--color--base)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.75rem',
								'bottom' => '0.75rem',
								'left'   => '2rem',
								'right'  => '2rem',
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
								'top'    => '0.75rem',
								'bottom' => '0.75rem',
								'left'   => '2rem',
								'right'  => '2rem',
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
						'width' => '1px',
						'style' => 'solid',
					),
					'right'  => array(
						'width' => '0px',
						'style' => 'none',
					),
					'bottom' => array(
						'width' => '1px',
						'style' => 'solid',
					),
					'left'   => array(
						'width' => '0px',
						'style' => 'none',
					),
					'radius' => '0px',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '1.5rem',
						'bottom' => '1.5rem',
					),
				),
				'typography' => array(
					'fontStyle'     => 'normal',
					'fontWeight'    => '400',
					'fontSize'      => '0.875rem',
					'textTransform' => 'uppercase',
					'letterSpacing' => '0.05em',
				),
			),
			'core/cover'     => array(
				'spacing'    => array(
					'padding' => array(
						'top'    => '6rem',
						'bottom' => '6rem',
					),
				),
				'dimensions' => array( 'minHeight' => '500px' ),
				'border'     => array( 'radius' => '0px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '1.75rem' ),
			),
		),
		'css'        => '.wp-element-button,.wp-block-button__link{background:transparent !important;color:inherit !important;} .wp-element-button:hover,.wp-block-button__link:hover{background:var(--wp--preset--color--contrast) !important;color:var(--wp--preset--color--base,#fff) !important;} .entry-content h2::before{content:"";display:block;width:2rem;height:1px;background:currentColor;margin-bottom:1rem;opacity:0.4;} .entry-content h2.has-text-align-center::before{margin-inline:auto;} .entry-content h2.has-text-align-right::before{margin-inline-start:auto;}',
	),
);
