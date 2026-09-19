/**
 * Stats — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { Button, PanelBody, TextControl, ToggleControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
  const { heading, items } = attributes;
  const blockProps = useBlockProps( { className: 'z-stats' } );

  const update = ( index, next ) =>
    setAttributes( { items: items.map( ( item, i ) => ( i === index ? { ...item, ...next } : item ) ) } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Figures', 'zngiron-blocks' ) }>
          { items.map( ( item, index ) => (
            <div key={ index }>
              <TextControl
                label={ __( 'Value', 'zngiron-blocks' ) }
                type="number"
                value={ item.value ?? '' }
                onChange={ ( value ) => update( index, { value: parseFloat( value ) || 0 } ) }
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <TextControl
                label={ __( 'Label', 'zngiron-blocks' ) }
                value={ item.label || '' }
                onChange={ ( label ) => update( index, { label } ) }
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <TextControl
                label={ __( 'Prefix', 'zngiron-blocks' ) }
                value={ item.prefix || '' }
                onChange={ ( prefix ) => update( index, { prefix } ) }
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <TextControl
                label={ __( 'Suffix', 'zngiron-blocks' ) }
                value={ item.suffix || '' }
                onChange={ ( suffix ) => update( index, { suffix } ) }
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <ToggleControl
                label={ __( 'Plain number (a year, never counted)', 'zngiron-blocks' ) }
                checked={ !! item.plain }
                onChange={ ( plain ) => update( index, { plain } ) }
                __nextHasNoMarginBottom
              />
              <Button
                variant="tertiary"
                isDestructive
                onClick={ () => setAttributes( { items: items.filter( ( _, i ) => i !== index ) } ) }
                __next40pxDefaultSize
              >
                { __( 'Remove figure', 'zngiron-blocks' ) }
              </Button>
            </div>
          ) ) }
          <Button
            variant="secondary"
            onClick={ () => setAttributes( { items: [ ...items, { value: 0, label: '' } ] } ) }
            __next40pxDefaultSize
          >
            { __( 'Add figure', 'zngiron-blocks' ) }
          </Button>
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <RichText
          tagName="h2"
          className="z-stats__heading"
          value={ heading }
          onChange={ ( value ) => setAttributes( { heading: value } ) }
          allowedFormats={ [] }
          placeholder={ __( 'Heading', 'zngiron-blocks' ) }
        />
        <dl className="z-stats__list">
          { items.map( ( item, index ) => (
            <div className="z-stats__row" key={ index }>
              <dt className="z-stats__figure">
                { item.prefix }
                { item.value }
                { item.suffix }
              </dt>
              <dd className="z-stats__label">{ item.label }</dd>
            </div>
          ) ) }
        </dl>
      </div>
    </>
  );
}
