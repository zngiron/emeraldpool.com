/**
 * Compare Table — editor.
 *
 * Three slots, any of which may be empty; the render drops empty ones, so a
 * two-way comparison needs no separate control.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, Placeholder, SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import ServerSideRender from '@wordpress/server-side-render';

const SLOTS = [ 0, 1, 2 ];

export default function Edit( { attributes, setAttributes } ) {
  const { heading, postIds } = attributes;
  const blockProps = useBlockProps( { className: 'z-compare' } );

  const { postType, posts } = useSelect( ( select ) => {
    const core = select( coreStore );
    const types = ( core.getPostTypes( { per_page: -1 } ) || [] ).filter(
      ( type ) => type.viewable && ! [ 'post', 'page', 'attachment' ].includes( type.slug )
    );
    const slug = types[ 0 ]?.slug || 'post';

    return {
      postType: slug,
      posts: core.getEntityRecords( 'postType', slug, { per_page: -1, status: 'publish' } ) || [],
    };
  }, [] );

  const options = [
    { label: __( 'None', 'zngiron-blocks' ), value: 0 },
    ...posts.map( ( post ) => ( { label: post.title?.rendered || post.slug, value: post.id } ) ),
  ];

  const setSlot = ( index, value ) => {
    const next = [ ...postIds ];
    next[ index ] = parseInt( value, 10 ) || 0;
    setAttributes( { postIds: next.filter( Boolean ) } );
  };

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Posts', 'zngiron-blocks' ) }>
          { SLOTS.map( ( index ) => (
            <SelectControl
              key={ index }
              label={ `${ __( 'Column', 'zngiron-blocks' ) } ${ index + 1 } (${ postType })` }
              value={ postIds[ index ] || 0 }
              options={ options }
              onChange={ ( value ) => setSlot( index, value ) }
              __next40pxDefaultSize
              __nextHasNoMarginBottom
            />
          ) ) }
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <RichText
          tagName="h2"
          className="z-compare__heading"
          value={ heading }
          onChange={ ( value ) => setAttributes( { heading: value } ) }
          allowedFormats={ [] }
          placeholder={ __( 'Side by side', 'zngiron-blocks' ) }
        />
        <ServerSideRender
          block="zngiron/compare-table"
          attributes={ { ...attributes, heading: '' } }
          EmptyResponsePlaceholder={ () => (
            <Placeholder
              icon="columns"
              label={ __( 'Compare Table', 'zngiron-blocks' ) }
              instructions={ __(
                'Choose two or three posts in the Posts panel on the right. The table builds itself from the fields flagged for comparison.',
                'zngiron-blocks'
              ) }
            />
          ) }
        />
      </div>
    </>
  );
}
