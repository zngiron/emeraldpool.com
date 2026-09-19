/**
 * Marquee — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
  const { text, speed } = attributes;
  const blockProps = useBlockProps( { className: 'z-marquee' } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Motion', 'zngiron-blocks' ) }>
          <RangeControl
            label={ __( 'Seconds per loop', 'zngiron-blocks' ) }
            value={ speed }
            onChange={ ( value ) => setAttributes( { speed: value } ) }
            min={ 10 }
            max={ 90 }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <RichText
          tagName="p"
          className="z-marquee__text"
          value={ text }
          onChange={ ( value ) => setAttributes( { text: value } ) }
          allowedFormats={ [] }
          placeholder={ __( 'Words to loop', 'zngiron-blocks' ) }
        />
      </div>
    </>
  );
}
