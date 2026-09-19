/**
 * Testimonial slider — editor.
 *
 * In the editor every quote is shown stacked, because editing something that is
 * hidden behind a control nobody can click is a bad time.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

const ALLOWED = [ 'core/quote' ];

const TEMPLATE = [
	[
		'core/quote',
		{
			className: 'is-style-testimonial',
			citation: __( 'Customer name, town', 'emerald-pool-blocks' ),
		},
	],
	[
		'core/quote',
		{
			className: 'is-style-testimonial',
			citation: __( 'Customer name, town', 'emerald-pool-blocks' ),
		},
	],
];

export default function Edit( { attributes, setAttributes } ) {
	const { label } = attributes;

	const blockProps = useBlockProps( { className: 'ep-slider is-editing' } );
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'ep-slider__track' },
		{ allowedBlocks: ALLOWED, template: TEMPLATE }
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Slider', 'emerald-pool-blocks' ) }>
					<TextControl
						label={ __( 'Accessible label', 'emerald-pool-blocks' ) }
						help={ __( 'Names the region for screen reader users.', 'emerald-pool-blocks' ) }
						value={ label }
						onChange={ ( value ) => setAttributes( { label: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div { ...innerBlocksProps } />
			</div>
		</>
	);
}
