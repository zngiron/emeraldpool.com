/**
 * FAQ — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { Button, PanelBody } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
  const { heading, items } = attributes;
  const blockProps = useBlockProps( { className: 'z-faq' } );

  const update = ( index, next ) =>
    setAttributes( { items: items.map( ( item, i ) => ( i === index ? { ...item, ...next } : item ) ) } );

  return (
    <>
      <InspectorControls>
        <PanelBody title={ __( 'Items', 'zngiron-blocks' ) }>
          <Button
            variant="secondary"
            onClick={ () => setAttributes( { items: [ ...items, { question: '', answer: '' } ] } ) }
            __next40pxDefaultSize
          >
            { __( 'Add question', 'zngiron-blocks' ) }
          </Button>
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <RichText
          tagName="h2"
          className="z-faq__heading"
          value={ heading }
          onChange={ ( value ) => setAttributes( { heading: value } ) }
          allowedFormats={ [] }
          placeholder={ __( 'Questions', 'zngiron-blocks' ) }
        />
        { items.map( ( item, index ) => (
          <div className="z-faq__item" key={ index }>
            <RichText
              tagName="p"
              className="z-faq__question"
              value={ item.question }
              onChange={ ( question ) => update( index, { question } ) }
              allowedFormats={ [] }
              placeholder={ __( 'Question', 'zngiron-blocks' ) }
            />
            <RichText
              tagName="p"
              className="z-faq__answer"
              value={ item.answer }
              onChange={ ( answer ) => update( index, { answer } ) }
              placeholder={ __( 'Answer', 'zngiron-blocks' ) }
            />
            <Button
              variant="tertiary"
              isDestructive
              onClick={ () => setAttributes( { items: items.filter( ( _, i ) => i !== index ) } ) }
              __next40pxDefaultSize
            >
              { __( 'Remove', 'zngiron-blocks' ) }
            </Button>
          </div>
        ) ) }
      </div>
    </>
  );
}
