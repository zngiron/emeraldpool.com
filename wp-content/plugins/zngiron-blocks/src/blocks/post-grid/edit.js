/**
 * Post Grid — editor.
 *
 * The query is described with selects fed from core data, so the block works
 * for any registered post type and taxonomy rather than a hard-coded pair.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes } ) {
  const { postType, taxonomy, term, count, columns, orderBy, order, showFilters, filterTaxonomy } =
    attributes;
  const blockProps = useBlockProps();

  const { postTypes, taxonomies, terms } = useSelect(
    ( select ) => {
      const core = select( coreStore );
      const all = core.getPostTypes( { per_page: -1 } ) || [];

      return {
        postTypes: all.filter( ( type ) => type.viewable && type.slug !== 'attachment' ),
        taxonomies: core.getTaxonomies( { per_page: -1 } ) || [],
        terms: taxonomy ? core.getEntityRecords( 'taxonomy', taxonomy, { per_page: -1 } ) || [] : [],
      };
    },
    [ taxonomy ]
  );

  const asOptions = ( items, labelKey = 'name', valueKey = 'slug' ) => [
    { label: __( 'Any', 'zngiron-blocks' ), value: '' },
    ...items.map( ( item ) => ( { label: item[ labelKey ], value: item[ valueKey ] } ) ),
  ];

  const typeTaxonomies = taxonomies.filter(
    ( tax ) => ! postType || ( tax.types || [] ).includes( postType )
  );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Query', 'zngiron-blocks' ) }>
          <SelectControl
            label={ __( 'Post type', 'zngiron-blocks' ) }
            value={ postType }
            options={ asOptions( postTypes ) }
            onChange={ ( value ) => setAttributes( { postType: value, taxonomy: '', term: '' } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <SelectControl
            label={ __( 'Taxonomy', 'zngiron-blocks' ) }
            value={ taxonomy }
            options={ asOptions( typeTaxonomies ) }
            onChange={ ( value ) => setAttributes( { taxonomy: value, term: '' } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          { taxonomy && (
            <SelectControl
              label={ __( 'Term', 'zngiron-blocks' ) }
              value={ term }
              options={ asOptions( terms ) }
              onChange={ ( value ) => setAttributes( { term: value } ) }
              __next40pxDefaultSize
              __nextHasNoMarginBottom
            />
          ) }
          <RangeControl
            label={ __( 'Number of posts', 'zngiron-blocks' ) }
            value={ count }
            onChange={ ( value ) => setAttributes( { count: value } ) }
            min={ 1 }
            max={ 24 }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <SelectControl
            label={ __( 'Order by', 'zngiron-blocks' ) }
            value={ orderBy }
            options={ [
              { label: __( 'Menu order', 'zngiron-blocks' ), value: 'menu_order' },
              { label: __( 'Date', 'zngiron-blocks' ), value: 'date' },
              { label: __( 'Title', 'zngiron-blocks' ), value: 'title' },
            ] }
            onChange={ ( value ) => setAttributes( { orderBy: value } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <SelectControl
            label={ __( 'Order', 'zngiron-blocks' ) }
            value={ order }
            options={ [
              { label: __( 'Ascending', 'zngiron-blocks' ), value: 'ASC' },
              { label: __( 'Descending', 'zngiron-blocks' ), value: 'DESC' },
            ] }
            onChange={ ( value ) => setAttributes( { order: value } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
        </PanelBody>

        <PanelBody title={ __( 'Layout', 'zngiron-blocks' ) }>
          <RangeControl
            label={ __( 'Columns', 'zngiron-blocks' ) }
            value={ columns }
            onChange={ ( value ) => setAttributes( { columns: value } ) }
            min={ 2 }
            max={ 4 }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <ToggleControl
            label={ __( 'Filter chips', 'zngiron-blocks' ) }
            checked={ showFilters }
            onChange={ ( value ) => setAttributes( { showFilters: value } ) }
            __nextHasNoMarginBottom
          />
          { showFilters && (
            <SelectControl
              label={ __( 'Filter by', 'zngiron-blocks' ) }
              value={ filterTaxonomy }
              options={ asOptions( typeTaxonomies ) }
              onChange={ ( value ) => setAttributes( { filterTaxonomy: value } ) }
              __next40pxDefaultSize
              __nextHasNoMarginBottom
            />
          ) }
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <ServerSideRender block="zngiron/post-grid" attributes={ attributes } />
      </div>
    </>
  );
}
