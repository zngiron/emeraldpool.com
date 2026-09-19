/**
 * Hero — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, ToggleGroupControl, ToggleGroupControlOption } from '@wordpress/components';
import { FrameControls, FramePreview } from '../../components/Frame';
import { ButtonsControls, ButtonsPreview } from '../../components/Buttons';
import Eyebrow from '../../components/Eyebrow';

export default function Edit( { attributes, setAttributes } ) {
  const { eyebrow, heading, text, meta, height, buttons, frame } = attributes;
  const blockProps = useBlockProps( { className: `z-hero is-height-${ height }` } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Layout', 'zngiron-blocks' ) }>
          <ToggleGroupControl
            label={ __( 'Height', 'zngiron-blocks' ) }
            value={ height }
            onChange={ ( value ) => setAttributes( { height: value } ) }
            isBlock
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          >
            <ToggleGroupControlOption value="full" label={ __( 'Full', 'zngiron-blocks' ) } />
            <ToggleGroupControlOption value="tall" label={ __( 'Tall', 'zngiron-blocks' ) } />
            <ToggleGroupControlOption value="short" label={ __( 'Short', 'zngiron-blocks' ) } />
          </ToggleGroupControl>
        </PanelBody>
        <FrameControls frame={ frame } onChange={ ( value ) => setAttributes( { frame: value } ) } />
        <ButtonsControls buttons={ buttons } onChange={ ( value ) => setAttributes( { buttons: value } ) } />
      </InspectorControls>

      <div { ...blockProps }>
        <div className="z-hero__frame">
          <FramePreview frame={ frame } />
        </div>
        <div className="z-hero__scrim" aria-hidden="true" />
        <div className="z-hero__copy">
          <Eyebrow value={ eyebrow } onChange={ ( value ) => setAttributes( { eyebrow: value } ) } />
          <RichText
            tagName="h1"
            className="z-hero__heading"
            value={ heading }
            onChange={ ( value ) => setAttributes( { heading: value } ) }
            placeholder={ __( 'Heading', 'zngiron-blocks' ) }
          />
          <RichText
            tagName="p"
            className="z-hero__text"
            value={ text }
            onChange={ ( value ) => setAttributes( { text: value } ) }
            placeholder={ __( 'Supporting sentence', 'zngiron-blocks' ) }
          />
          <ButtonsPreview buttons={ buttons } />
          <RichText
            tagName="p"
            className="z-hero__meta"
            value={ meta }
            onChange={ ( value ) => setAttributes( { meta: value } ) }
            allowedFormats={ [] }
            placeholder={ __( 'Meta line', 'zngiron-blocks' ) }
          />
        </div>
      </div>
    </>
  );
}
