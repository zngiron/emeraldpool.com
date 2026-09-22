/**
 * Specs Table — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, Placeholder, TextControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes, context } ) {
  const { heading, postId } = attributes;
  const blockProps = useBlockProps( { className: 'z-specs' } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Source', 'zngiron-blocks' ) }>
          <TextControl
            label={ __( 'Post ID', 'zngiron-blocks' ) }
            help={ __( 'Leave at 0 to use the post being viewed.', 'zngiron-blocks' ) }
            type="number"
            value={ postId }
            onChange={ ( value ) => setAttributes( { postId: parseInt( value, 10 ) || 0 } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <RichText
          tagName="h2"
          className="z-specs__heading"
          value={ heading }
          onChange={ ( value ) => setAttributes( { heading: value } ) }
          allowedFormats={ [] }
          placeholder={ __( 'Specifications', 'zngiron-blocks' ) }
        />
        <ServerSideRender
          block="zngiron/specs-table"
          attributes={ { ...attributes, heading: '', postId: postId || context?.postId || 0 } }
          EmptyResponsePlaceholder={ () => (
            <Placeholder
              icon="editor-table"
              label={ __( 'Specs Table', 'zngiron-blocks' ) }
              instructions={ __(
                'No specifications to show. Inside a single-post template this fills from the post being viewed; anywhere else, name a Post ID in the Source panel.',
                'zngiron-blocks'
              ) }
            />
          ) }
        />
      </div>
    </>
  );
}
