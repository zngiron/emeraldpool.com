/**
 * FAQ accordion — inner content only.
 *
 * The block is dynamic so the server can read the questions and publish the
 * structured data; the inner blocks still save normally so the questions stay in
 * post content and remain editable and searchable.
 */
import { useInnerBlocksProps } from '@wordpress/block-editor';

export default function save() {
	return <div { ...useInnerBlocksProps.save( { className: 'ep-faq__items' } ) } />;
}
