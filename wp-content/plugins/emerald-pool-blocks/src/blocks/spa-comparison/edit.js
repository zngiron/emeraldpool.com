/**
 * Spa comparison — editor.
 *
 * The picker is a plain checkbox list rather than a search field: a dealer has
 * tens of models, not thousands, and seeing the whole catalogue is faster than
 * typing into it.
 */
import { __, sprintf } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl, TextControl, ToggleControl, Spinner } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';

const MAX_SPAS = 3;

export default function Edit( { attributes, setAttributes } ) {
	const { postIds, showImages, caption } = attributes;

	const spas = useSelect(
		( select ) =>
			select( coreStore ).getEntityRecords( 'postType', 'spa', {
				per_page: 100,
				status: 'publish',
				orderby: 'title',
				order: 'asc',
				_fields: 'id,title',
			} ),
		[]
	);

	const toggle = ( id ) => {
		const next = postIds.includes( id )
			? postIds.filter( ( value ) => value !== id )
			: [ ...postIds, id ].slice( -MAX_SPAS );

		setAttributes( { postIds: next } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Spas to compare', 'emerald-pool-blocks' ) }>
					<p className="ep-picker__hint">
						{ sprintf(
							/* translators: %d: maximum number of spas. */
							__( 'Pick up to %d. Choosing a fourth replaces the oldest choice.', 'emerald-pool-blocks' ),
							MAX_SPAS
						) }
					</p>
					{ ! spas && <Spinner /> }
					{ spas && spas.length === 0 && (
						<p>{ __( 'No spas published yet.', 'emerald-pool-blocks' ) }</p>
					) }
					{ ( spas || [] ).map( ( spa ) => (
						<CheckboxControl
							key={ spa.id }
							label={ spa.title.rendered || __( '(no title)', 'emerald-pool-blocks' ) }
							checked={ postIds.includes( spa.id ) }
							onChange={ () => toggle( spa.id ) }
							__nextHasNoMarginBottom
						/>
					) ) }
				</PanelBody>
				<PanelBody title={ __( 'Presentation', 'emerald-pool-blocks' ) }>
					<ToggleControl
						label={ __( 'Show photographs', 'emerald-pool-blocks' ) }
						checked={ showImages }
						onChange={ ( value ) => setAttributes( { showImages: value } ) }
						__nextHasNoMarginBottom
					/>
					<TextControl
						label={ __( 'Table caption', 'emerald-pool-blocks' ) }
						help={ __( 'Describes the table for screen readers and prints above it.', 'emerald-pool-blocks' ) }
						value={ caption }
						onChange={ ( value ) => setAttributes( { caption: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...useBlockProps() }>
				<ServerSideRender block={ metadata.name } attributes={ attributes } />
			</div>
		</>
	);
}
