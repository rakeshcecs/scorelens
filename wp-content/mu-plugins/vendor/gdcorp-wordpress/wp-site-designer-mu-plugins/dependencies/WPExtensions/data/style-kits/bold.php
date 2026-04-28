<?php
/**
 * Bold style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── BOLD ──────────────────────────────────────────────────
 * Poster-like Brutalist energy. MASSIVE type, thick borders,
 * hard offset shadows, uppercase headings. In your face.
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
					'size'  => '1.5rem',
					'name'  => 'Large',
					'fluid' => array(
						'min' => '1.5rem',
						'max' => '2.25rem',
					),
				),
				array(
					'slug'  => 'x-large',
					'size'  => '2rem',
					'name'  => 'XL',
					'fluid' => array(
						'min' => '2rem',
						'max' => '3.5rem',
					),
				),
				array(
					'slug'  => 'xx-large',
					'size'  => '3rem',
					'name'  => 'XXL',
					'fluid' => array(
						'min' => '3rem',
						'max' => '5.5rem',
					),
				),
				array(
					'slug'  => 'xxx-large',
					'size'  => '4rem',
					'name'  => 'XXXL',
					'fluid' => array(
						'min' => '4rem',
						'max' => '8rem',
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
			'contentSize' => '1280px',
			'wideSize'    => '1400px',
		),
	),
	'styles'   => array(
		'typography' => array( 'lineHeight' => '1.5' ),
		'elements'   => array(
			'button'  => array(
				'border'     => array(
					'radius' => '0px',
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
					'fontWeight'    => '800',
					'textTransform' => 'uppercase',
					'letterSpacing' => '0.05em',
					'fontSize'      => '1rem',
				),
			),
			'link'    => array(
				'typography' => array(
					'textDecoration'      => 'underline',
					'fontWeight'          => '700',
					'textDecorationStyle' => 'initial',
				),
				':hover'     => array( 'typography' => array( 'textDecoration' => 'none' ) ),
			),
			'heading' => array(
				'typography' => array(
					'fontWeight'    => '900',
					'textTransform' => 'uppercase',
					'letterSpacing' => '-0.02em',
					'lineHeight'    => '1.05',
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
							'radius' => '0px',
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
					'radius' => '0px',
					'width'  => '3px',
					'style'  => 'solid',
				),
			),
			'core/separator' => array(
				'border' => array(
					'width' => '3px',
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
						'width' => '6px',
						'style' => 'solid',
					),
					'radius' => '0px',
				),
				'spacing'    => array(
					'padding' => array( 'left' => '2rem' ),
				),
				'typography' => array(
					'fontStyle'     => 'normal',
					'fontWeight'    => '700',
					'fontSize'      => '1.25rem',
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
				'dimensions' => array( 'minHeight' => '500px' ),
				'border'     => array( 'radius' => '0px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '2.5rem' ),
			),
		),
		'css'        => '.wp-block-button__link{transition:transform 0.15s ease,box-shadow 0.15s ease;} .wp-element-button,.wp-block-button__link{box-shadow:5px 5px 0 currentColor;} .wp-element-button:hover,.wp-block-button__link:hover{box-shadow:2px 2px 0 currentColor;transform:translate(3px,3px);} .entry-content h2::after{content:"";display:block;width:5rem;height:5px;background:currentColor;margin-top:0.5rem;} .entry-content h2.has-text-align-center::after{margin-inline:auto;} .entry-content h2.has-text-align-right::after{margin-inline-start:auto;}',
	),
);
