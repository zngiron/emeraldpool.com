/**
 * Spa specifications — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl, RangeControl, Notice } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';

export default function Edit( { attributes, setAttributes, context } ) {
	const { heading, showGroupHeadings, columns } = attributes;
	const isSpa = context?.postType === 'spa';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Specifications', 'emerald-pool-blocks' ) }>
					<TextControl
						label={ __( 'Heading', 'emerald-pool-blocks' ) }
						help={ __( 'Leave empty to print the list with no heading.', 'emerald-pool-blocks' ) }
						value={ heading }
						onChange={ ( value ) => setAttributes( { heading: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Group the fields', 'emerald-pool-blocks' ) }
						help={ __( 'Capacity, hydrotherapy, size and buying are printed as sections.', 'emerald-pool-blocks' ) }
						checked={ showGroupHeadings }
						onChange={ ( value ) => setAttributes( { showGroupHeadings: value } ) }
						__nextHasNoMarginBottom
					/>
					<RangeControl
						label={ __( 'Columns', 'emerald-pool-blocks' ) }
						value={ columns }
						onChange={ ( value ) => setAttributes( { columns: value } ) }
						min={ 1 }
						max={ 3 }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...useBlockProps() }>
				{ ! isSpa && (
					<Notice status="info" isDismissible={ false }>
						{ __(
							'This block prints the specs of the spa it sits on. On any other post type it prints nothing.',
							'emerald-pool-blocks'
						) }
					</Notice>
				) }
				<ServerSideRender
					block={ metadata.name }
					attributes={ attributes }
					urlQueryArgs={ { post_id: context?.postId } }
				/>
			</div>
		</>
	);
}
