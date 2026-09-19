/**
 * Card — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { FrameControls, FramePreview } from '../../components/Frame';

export default function Edit( { attributes, setAttributes } ) {
  const { title, text, url, linkText, frame } = attributes;
  const blockProps = useBlockProps( { className: 'z-card' } );

  return (
    <>
      <InspectorControls>
        <FrameControls frame={ frame } onChange={ ( value ) => setAttributes( { frame: value } ) } />
        <PanelBody title={ __( 'Link', 'zngiron-blocks' ) } initialOpen={ false }>
          <TextControl
            label={ __( 'URL', 'zngiron-blocks' ) }
            value={ url }
            onChange={ ( value ) => setAttributes( { url: value } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <TextControl
            label={ __( 'Link text', 'zngiron-blocks' ) }
            value={ linkText }
            onChange={ ( value ) => setAttributes( { linkText: value } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
        </PanelBody>
      </InspectorControls>

      <article { ...blockProps }>
        <div className="z-card__media">
          <FramePreview frame={ frame } />
        </div>
        <div className="z-card__body">
          <RichText
            tagName="h3"
            className="z-card__title"
            value={ title }
            onChange={ ( value ) => setAttributes( { title: value } ) }
            allowedFormats={ [] }
            placeholder={ __( 'Title', 'zngiron-blocks' ) }
          />
          <RichText
            tagName="p"
            className="z-card__text"
            value={ text }
            onChange={ ( value ) => setAttributes( { text: value } ) }
            placeholder={ __( 'One or two sentences.', 'zngiron-blocks' ) }
          />
        </div>
      </article>
    </>
  );
}
