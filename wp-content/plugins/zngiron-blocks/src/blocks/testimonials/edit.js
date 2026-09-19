/**
 * Testimonials — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { Button, PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
  const { heading, items } = attributes;
  const blockProps = useBlockProps( { className: 'z-testimonials' } );

  const update = ( index, next ) =>
    setAttributes( { items: items.map( ( item, i ) => ( i === index ? { ...item, ...next } : item ) ) } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Quotes', 'zngiron-blocks' ) }>
          { items.map( ( item, index ) => (
            <div key={ index }>
              <TextControl
                label={ __( 'Name', 'zngiron-blocks' ) }
                value={ item.name || '' }
                onChange={ ( name ) => update( index, { name } ) }
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <TextControl
                label={ __( 'Role or place', 'zngiron-blocks' ) }
                value={ item.role || '' }
                onChange={ ( role ) => update( index, { role } ) }
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <Button
                variant="tertiary"
                isDestructive
                onClick={ () => setAttributes( { items: items.filter( ( _, i ) => i !== index ) } ) }
                __next40pxDefaultSize
              >
                { __( 'Remove quote', 'zngiron-blocks' ) }
              </Button>
            </div>
          ) ) }
          <Button
            variant="secondary"
            onClick={ () => setAttributes( { items: [ ...items, { quote: '', name: '', role: '' } ] } ) }
            __next40pxDefaultSize
          >
            { __( 'Add quote', 'zngiron-blocks' ) }
          </Button>
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <RichText
          tagName="h2"
          className="z-testimonials__heading"
          value={ heading }
          onChange={ ( value ) => setAttributes( { heading: value } ) }
          allowedFormats={ [] }
          placeholder={ __( 'What people say', 'zngiron-blocks' ) }
        />
        { items.map( ( item, index ) => (
          <figure className="z-testimonial" key={ index }>
            <RichText
              tagName="blockquote"
              className="z-testimonial__quote"
              value={ item.quote }
              onChange={ ( quote ) => update( index, { quote } ) }
              placeholder={ __( 'Quote', 'zngiron-blocks' ) }
            />
            <figcaption className="z-testimonial__by">
              { item.name }
              { item.role ? ` — ${ item.role }` : '' }
            </figcaption>
          </figure>
        ) ) }
      </div>
    </>
  );
}
