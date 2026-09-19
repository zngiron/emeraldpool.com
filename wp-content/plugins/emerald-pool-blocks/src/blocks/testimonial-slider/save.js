/**
 * Testimonial slider — only the quotes are saved; the slider frame and its
 * directives are rendered on the server.
 */
import { useInnerBlocksProps } from '@wordpress/block-editor';

export default function save() {
	return <div { ...useInnerBlocksProps.save( { className: 'ep-slider__track' } ) } />;
}
