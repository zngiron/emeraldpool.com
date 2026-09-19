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
					textColor: 'base',
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
			block: 'core/columns',
			settings: {
				name: 'emerald-card-row',
				title: __( 'Card row', 'emerald-pool' ),
				description: __( 'Three cards side by side, stacking on mobile.', 'emerald-pool' ),
				scope: [ 'inserter' ],
				attributes: { className: 'is-style-card-group' },
				innerBlocks: [
					[ 'core/column', {}, [ [ 'core/heading', { level: 3 } ], [ 'core/paragraph', {} ] ] ],
					[ 'core/column', {}, [ [ 'core/heading', { level: 3 } ], [ 'core/paragraph', {} ] ] ],
					[ 'core/column', {}, [ [ 'core/heading', { level: 3 } ], [ 'core/paragraph', {} ] ] ]
				]
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
