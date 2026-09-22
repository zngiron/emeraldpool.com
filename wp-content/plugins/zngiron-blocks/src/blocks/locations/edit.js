/**
 * Locations — editor.
 *
 * The addresses are config, not content, so there is nothing to type here: the
 * preview is the server render and the only choices are which stores to show.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, Placeholder, ToggleControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes } ) {
  const { heading, showHours } = attributes;
  const blockProps = useBlockProps( { className: 'z-locations' } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Display', 'zngiron-blocks' ) }>
          <ToggleControl
            label={ __( 'Show opening hours', 'zngiron-blocks' ) }
            checked={ showHours }
            onChange={ ( value ) => setAttributes( { showHours: value } ) }
            __nextHasNoMarginBottom
          />
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <RichText
          tagName="h2"
          className="z-locations__heading"
          value={ heading }
          onChange={ ( value ) => setAttributes( { heading: value } ) }
          allowedFormats={ [] }
          placeholder={ __( 'Where to find us', 'zngiron-blocks' ) }
        />
        <ServerSideRender
          block="zngiron/locations"
          attributes={ { ...attributes, heading: '' } }
          EmptyResponsePlaceholder={ () => (
            <Placeholder
              icon="location"
              label={ __( 'Locations', 'zngiron-blocks' ) }
              instructions={ __(
                'No locations are configured. Add them to the locations array in config/brand.json.',
                'zngiron-blocks'
              ) }
            />
          ) }
        />
      </div>
    </>
  );
}
