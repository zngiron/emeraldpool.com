/**
 * Buttons — a small repeater shared by Hero, Media Text and Card Grid.
 *
 * Two styles only. A block that needs a third kind of call to action needs a
 * different block, not another option here.
 */
import { __ } from '@wordpress/i18n';
import {
  Button,
  PanelBody,
  SelectControl,
  TextControl,
} from '@wordpress/components';

export const BUTTON_DEFAULTS = { text: '', url: '', style: 'primary' };

/**
 * Inspector controls for a buttons attribute.
 *
 * @param {Object}   props          Component props.
 * @param {Array}    props.buttons  Button list.
 * @param {Function} props.onChange Receives the next list.
 * @return {JSX.Element} Controls.
 */
export function ButtonsControls( { buttons = [], onChange } ) {
  const update = ( index, next ) =>
    onChange( buttons.map( ( button, i ) => ( i === index ? { ...button, ...next } : button ) ) );

  return (
    <PanelBody title={ __( 'Buttons', 'zngiron-blocks' ) } initialOpen={ false }>
      { buttons.map( ( button, index ) => (
        <div className="z-buttons-control" key={ index }>
          <TextControl
            label={ __( 'Text', 'zngiron-blocks' ) }
            value={ button.text || '' }
            onChange={ ( text ) => update( index, { text } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <TextControl
            label={ __( 'Link', 'zngiron-blocks' ) }
            value={ button.url || '' }
            onChange={ ( url ) => update( index, { url } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <SelectControl
            label={ __( 'Style', 'zngiron-blocks' ) }
            value={ button.style || 'primary' }
            options={ [
              { label: __( 'Primary', 'zngiron-blocks' ), value: 'primary' },
              { label: __( 'Secondary', 'zngiron-blocks' ), value: 'secondary' },
            ] }
            onChange={ ( style ) => update( index, { style } ) }
            __next40pxDefaultSize
            __nextHasNoMarginBottom
          />
          <Button
            variant="tertiary"
            isDestructive
            onClick={ () => onChange( buttons.filter( ( _, i ) => i !== index ) ) }
            __next40pxDefaultSize
          >
            { __( 'Remove button', 'zngiron-blocks' ) }
          </Button>
        </div>
      ) ) }

      <Button
        variant="secondary"
        onClick={ () => onChange( [ ...buttons, { ...BUTTON_DEFAULTS } ] ) }
        __next40pxDefaultSize
      >
        { __( 'Add button', 'zngiron-blocks' ) }
      </Button>
    </PanelBody>
  );
}

/**
 * Editor preview of the button row.
 *
 * @param {Object} props         Component props.
 * @param {Array}  props.buttons Button list.
 * @return {JSX.Element|null} Preview.
 */
export function ButtonsPreview( { buttons = [] } ) {
  const visible = buttons.filter( ( button ) => button.text );

  if ( ! visible.length ) {
    return null;
  }

  return (
    <div className="z-buttons">
      { visible.map( ( button, index ) => (
        <span className={ `z-button is-style-${ button.style || 'primary' }` } key={ index }>
          { button.text }
        </span>
      ) ) }
    </div>
  );
}
