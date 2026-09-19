/**
 * Media Text — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, ToggleGroupControl, ToggleGroupControlOption } from '@wordpress/components';
import { FrameControls, FramePreview } from '../../components/Frame';
import { ButtonsControls, ButtonsPreview } from '../../components/Buttons';
import Eyebrow from '../../components/Eyebrow';

export default function Edit( { attributes, setAttributes } ) {
  const { eyebrow, heading, text, mediaSide, buttons, frame } = attributes;
  const blockProps = useBlockProps( { className: `z-media-text is-media-${ mediaSide }` } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Layout', 'zngiron-blocks' ) }>
          <ToggleGroupControl
            label={ __( 'Media side', 'zngiron-blocks' ) }
            value={ mediaSide }
            onChange={ ( value ) => setAttributes( { mediaSide: value } ) }
            isBlock
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          >
            <ToggleGroupControlOption value="left" label={ __( 'Left', 'zngiron-blocks' ) } />
            <ToggleGroupControlOption value="right" label={ __( 'Right', 'zngiron-blocks' ) } />
          </ToggleGroupControl>
        </PanelBody>
        <FrameControls frame={ frame } onChange={ ( value ) => setAttributes( { frame: value } ) } />
        <ButtonsControls buttons={ buttons } onChange={ ( value ) => setAttributes( { buttons: value } ) } />
      </InspectorControls>

      <div { ...blockProps }>
        <div className="z-media-text__media">
          <FramePreview frame={ frame } />
        </div>
        <div className="z-media-text__copy">
          <Eyebrow value={ eyebrow } onChange={ ( value ) => setAttributes( { eyebrow: value } ) } />
          <RichText
            tagName="h2"
            className="z-media-text__heading"
            value={ heading }
            onChange={ ( value ) => setAttributes( { heading: value } ) }
            placeholder={ __( 'Heading', 'zngiron-blocks' ) }
          />
          <RichText
            tagName="p"
            className="z-media-text__text"
            value={ text }
            onChange={ ( value ) => setAttributes( { text: value } ) }
            placeholder={ __( 'Two or three sentences.', 'zngiron-blocks' ) }
          />
          <ButtonsPreview buttons={ buttons } />
        </div>
      </div>
    </>
  );
}
