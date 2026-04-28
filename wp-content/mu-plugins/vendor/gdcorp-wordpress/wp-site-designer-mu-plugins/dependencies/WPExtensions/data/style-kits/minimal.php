<?php
/**
 * Minimal style kit theme.json fragment.
 *
 * @package gdcorp-wordpress/site-designer-ui-extensions
 * @return array
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ─── MINIMAL ───────────────────────────────────────────────
 * Near-wireframe aesthetic. Stripped of all decoration.
 * Tiny type scale, ultra-tight spacing, no shadows/borders/radius.
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
					'size'  => '1.125rem',
					'name'  => 'Large',
					'fluid' => array(
						'min' => '1.125rem',
						'max' => '1.25rem',
					),
				),
				array(
					'slug'  => 'x-large',
					'size'  => '1.25rem',
					'name'  => 'XL',
					'fluid' => array(
						'min' => '1.25rem',
						'max' => '1.75rem',
					),
				),
				array(
					'slug'  => 'xx-large',
					'size'  => '1.5rem',
					'name'  => 'XXL',
					'fluid' => array(
						'min' => '1.5rem',
						'max' => '2.25rem',
					),
				),
				array(
					'slug'  => 'xxx-large',
					'size'  => '1.75rem',
					'name'  => 'XXXL',
					'fluid' => array(
						'min' => '1.75rem',
						'max' => '2.75rem',
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
					'size' => '0.75rem',
					'name' => 'M',
				),
				array(
					'slug' => '50',
					'size' => '1.25rem',
					'name' => 'L',
				),
				array(
					'slug' => '60',
					'size' => '2rem',
					'name' => 'XL',
				),
				array(
					'slug' => '70',
					'size' => '3rem',
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
					'style'  => 'none',
					'width'  => '0px',
				),
				'color'      => array(
					'background' => 'var(--wp--preset--color--contrast)',
					'text'       => 'var(--wp--preset--color--base)',
				),
				'spacing'    => array(
					'padding' => array(
						'top'    => '0.5rem',
						'bottom' => '0.5rem',
						'left'   => '0.875rem',
						'right'  => '0.875rem',
					),
				),
				'typography' => array(
					'fontWeight'    => '400',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
					'fontSize'      => '0.8125rem',
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
					'letterSpacing' => '0em',
					'lineHeight'    => '1.2',
					'textTransform' => 'none',
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
							'style'  => 'none',
							'width'  => '0px',
						),
						'color'   => array(
							'background' => 'var(--wp--preset--color--contrast)',
							'text'       => 'var(--wp--preset--color--base)',
						),
						'spacing' => array(
							'padding' => array(
								'top'    => '0.5rem',
								'bottom' => '0.5rem',
								'left'   => '0.875rem',
								'right'  => '0.875rem',
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
								'left'   => '0.875rem',
								'right'  => '0.875rem',
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
					'padding' => array( 'left' => '1rem' ),
				),
				'typography' => array(
					'fontStyle'     => 'normal',
					'fontWeight'    => '400',
					'fontSize'      => 'inherit',
					'textTransform' => 'none',
					'letterSpacing' => '0em',
				),
			),
			'core/cover'     => array(
				'spacing'    => array(
					'padding' => array(
						'top'    => '3rem',
						'bottom' => '3rem',
					),
				),
				'dimensions' => array( 'minHeight' => '250px' ),
				'border'     => array( 'radius' => '0px' ),
			),
			'core/columns'   => array(
				'spacing' => array( 'blockGap' => '0.75rem' ),
			),
		),
		'css'        => '',
	),
);
