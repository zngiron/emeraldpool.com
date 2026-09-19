/**
 * FAQ accordion — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';

const ALLOWED = [ 'core/details' ];

const TEMPLATE = [
	[ 'core/details', { summary: __( 'Ask the question the way a customer would', 'emerald-pool-blocks' ) } ],
	[ 'core/details', { summary: __( 'Add a second question', 'emerald-pool-blocks' ) } ],
];

export default function Edit( { attributes, setAttributes } ) {
	const { heading, emitSchema } = attributes;

	const blockProps = useBlockProps( { className: 'ep-faq' } );
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'ep-faq__items' },
		{ allowedBlocks: ALLOWED, template: TEMPLATE }
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Questions', 'emerald-pool-blocks' ) }>
					<TextControl
						label={ __( 'Heading', 'emerald-pool-blocks' ) }
						value={ heading }
						onChange={ ( value ) => setAttributes( { heading: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Publish FAQ structured data', 'emerald-pool-blocks' ) }
						help={ __(
							'Adds schema.org FAQPage markup for these questions. Turn it off if another block on the page already publishes it.',
							'emerald-pool-blocks'
						) }
						checked={ emitSchema }
						onChange={ ( value ) => setAttributes( { emitSchema: value } ) }
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ heading && <h2 className="ep-faq__heading">{ heading }</h2> }
				<div { ...innerBlocksProps } />
			</div>
		</>
	);
}
