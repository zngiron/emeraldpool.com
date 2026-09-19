/**
 * Editor variations for core blocks.
 *
 * These are shortcuts, not new blocks: each one is a core block with the theme's
 * preferred attributes pre-filled, so an editor lands on the right spacing and
 * colour without knowing the token names.
 */
( function ( wp ) {
	'use strict';

	var __ = wp.i18n.__;

	var variations = [
		{
			block: 'core/group',
			settings: {
				name: 'emerald-section',
				title: __( 'Section', 'emerald-pool' ),
				description: __( 'A full-width band with section padding and a constrained inner layout.', 'emerald-pool' ),
				scope: [ 'inserter' ],
				attributes: {
					align: 'full',
					layout: { type: 'constrained' },
					style: {
						spacing: {
							padding: {
								top: 'var:preset|spacing|60',
								bottom: 'var:preset|spacing|60'
							}
						}
					}
				}
			}
		},
		{
			block: 'core/group',
			settings: {
				name: 'emerald-section-deep',
				title: __( 'Section — deep', 'emerald-pool' ),
				description: __( 'A dark band for closing calls to action and financing notes.', 'emerald-pool' ),
				scope: [ 'inserter' ],
				attributes: {
					align: 'full',
					backgroundColor: 'deep',
					textColor: 'sand',
					layout: { type: 'constrained' },
					style: {
						spacing: {
							padding: {
								top: 'var:preset|spacing|60',
								bottom: 'var:preset|spacing|60'
							}
						}
					}
				}
			}
		},
		{
			block: 'core/group',
			settings: {
				name: 'emerald-section-night',
				title: __( 'Section — night', 'emerald-pool' ),
				description: __( 'A full-width band on the deep night ground, with grain. The design\'s default for product and closing sections.', 'emerald-pool' ),
				scope: [ 'inserter' ],
				attributes: {
					align: 'full',
					className: 'ep-night',
					layout: { type: 'constrained' },
					style: {
						spacing: {
							padding: {
								top: 'var:preset|spacing|70',
								bottom: 'var:preset|spacing|70'
							}
						}
					}
				}
			}
		}
	];

	// Core styles the design has no use for. Unregistered client-side because
	// that is where core registers them.
	var retiredStyles = [
		[ 'core/image', 'rounded' ],
		[ 'core/separator', 'dots' ]
	];

	wp.domReady( function () {
		variations.forEach( function ( variation ) {
			wp.blocks.registerBlockVariation( variation.block, variation.settings );
		} );

		retiredStyles.forEach( function ( style ) {
			wp.blocks.unregisterBlockStyle( style[ 0 ], style[ 1 ] );
		} );
	} );
} )( window.wp );
