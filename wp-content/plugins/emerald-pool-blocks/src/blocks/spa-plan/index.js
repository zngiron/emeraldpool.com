/**
 * Spa plan view — registration.
 *
 * Data-driven, so the editor previews the real server render rather than an
 * approximation of it.
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';
import './style.scss';

registerBlockType( metadata.name, {
	edit( { attributes, setAttributes, context } ) {
		const blockProps = useBlockProps();

		return (
			<>
				<InspectorControls>
					<PanelBody title={ __( 'Annotation', 'emerald-pool-blocks' ) }>
						<ToggleControl
							label={ __( 'Show dimensions', 'emerald-pool-blocks' ) }
							checked={ attributes.showDimensions }
							onChange={ ( value ) => setAttributes( { showDimensions: value } ) }
							__nextHasNoMarginBottom
						/>
					</PanelBody>
				</InspectorControls>
				<div { ...blockProps }>
					<ServerSideRender
						block={ metadata.name }
						attributes={ attributes }
						urlQueryArgs={ { post_id: context.postId } }
					/>
				</div>
			</>
		);
	},
} );
