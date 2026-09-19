/**
 * Eyebrow — the small line above a heading.
 *
 * A separate component only so every block spells the class and the element the
 * same way; it is a rich text field with no formatting.
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

/**
 * @param {Object}   props           Component props.
 * @param {string}   props.value     Current text.
 * @param {Function} props.onChange  Receives the next text.
 * @return {JSX.Element} Editable eyebrow.
 */
export default function Eyebrow( { value, onChange } ) {
  return (
    <RichText
      tagName="p"
      className="z-eyebrow"
      value={ value }
      onChange={ onChange }
      allowedFormats={ [] }
      placeholder={ __( 'Eyebrow', 'zngiron-blocks' ) }
    />
  );
}
