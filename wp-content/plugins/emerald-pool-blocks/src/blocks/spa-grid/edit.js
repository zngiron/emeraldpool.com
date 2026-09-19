/**
 * Spa grid — editor.
 *
 * The preview is the real server render, so what an editor sees is what ships.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, RangeControl, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';

/**
 * Build select options from a taxonomy's terms.
 *
 * @param {string} taxonomy Taxonomy REST slug.
 * @param {string} allLabel Label for the "no filter" option.
 * @return {Array} Option list.
 */
function useTermOptions( taxonomy, allLabel ) {
	const terms = useSelect(
		( select ) =>
			select( coreStore ).getEntityRecords( 'taxonomy', taxonomy, {
				per_page: 100,
				_fields: 'id,name,slug',
			} ),
		[ taxonomy ]
	);

	return [
		{ label: allLabel, value: '' },
		...( terms || [] ).map( ( term ) => ( { label: term.name, value: term.slug } ) ),
	];
}

export default function Edit( { attributes, setAttributes, context } ) {
	const { spaType, series, numberOfItems, columns, orderBy, showFilters, showPrice, excludeCurrent } =
		attributes;

	const typeOptions = useTermOptions( 'spa_type', __( 'All types', 'emerald-pool-blocks' ) );
	const seriesOptions = useTermOptions( 'spa_series', __( 'All series', 'emerald-pool-blocks' ) );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Which spas', 'emerald-pool-blocks' ) }>
					<SelectControl
						label={ __( 'Type', 'emerald-pool-blocks' ) }
						value={ spaType }
						options={ typeOptions }
						onChange={ ( value ) => setAttributes( { spaType: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<SelectControl
						label={ __( 'Series', 'emerald-pool-blocks' ) }
						value={ series }
						options={ seriesOptions }
						onChange={ ( value ) => setAttributes( { series: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<RangeControl
						label={ __( 'How many', 'emerald-pool-blocks' ) }
						value={ numberOfItems }
						onChange={ ( value ) => setAttributes( { numberOfItems: value } ) }
						min={ 1 }
						max={ 24 }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<SelectControl
						label={ __( 'Order by', 'emerald-pool-blocks' ) }
						value={ orderBy }
						options={ [
							{ label: __( 'Manual order', 'emerald-pool-blocks' ), value: 'menu_order' },
							{ label: __( 'Name', 'emerald-pool-blocks' ), value: 'title' },
							{ label: __( 'Newest', 'emerald-pool-blocks' ), value: 'date' },
						] }
						onChange={ ( value ) => setAttributes( { orderBy: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Hide the spa being viewed', 'emerald-pool-blocks' ) }
						help={ __(
							'Use on a spa page so the grid shows siblings rather than repeating this model.',
							'emerald-pool-blocks'
						) }
						checked={ excludeCurrent }
						onChange={ ( value ) => setAttributes( { excludeCurrent: value } ) }
						__nextHasNoMarginBottom
					/>
				</PanelBody>
				<PanelBody title={ __( 'Presentation', 'emerald-pool-blocks' ) }>
					<RangeControl
						label={ __( 'Columns', 'emerald-pool-blocks' ) }
						value={ columns }
						onChange={ ( value ) => setAttributes( { columns: value } ) }
						min={ 2 }
						max={ 4 }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Show series filter chips', 'emerald-pool-blocks' ) }
						help={ __( 'Filters run in the browser. The grid never reloads the page.', 'emerald-pool-blocks' ) }
						checked={ showFilters }
						onChange={ ( value ) => setAttributes( { showFilters: value } ) }
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Show starting price', 'emerald-pool-blocks' ) }
						checked={ showPrice }
						onChange={ ( value ) => setAttributes( { showPrice: value } ) }
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...useBlockProps() }>
				<ServerSideRender
					block={ metadata.name }
					attributes={ attributes }
					urlQueryArgs={ { post_id: context?.postId } }
				/>
			</div>
		</>
	);
}
