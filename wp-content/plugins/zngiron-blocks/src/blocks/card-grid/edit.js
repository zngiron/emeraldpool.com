/**
 * Card Grid — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

const ALLOWED = [ 'zngiron/card' ];
const TEMPLATE = [ [ 'zngiron/card' ], [ 'zngiron/card' ], [ 'zngiron/card' ] ];

export default function Edit( { attributes, setAttributes } ) {
  const { columns } = attributes;
  const blockProps = useBlockProps( { className: `z-card-grid has-${ columns }-columns` } );
  const innerBlocksProps = useInnerBlocksProps( blockProps, {
    allowedBlocks: ALLOWED,
    template: TEMPLATE,
    orientation: 'horizontal',
  } );

  return (
    <>
      <InspectorControls>
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
        </PanelBody>
      </InspectorControls>

      <div { ...innerBlocksProps } />
    </>
  );
}
