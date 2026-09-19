/**
 * Hero — saved content.
 *
 * Only the inner buttons are stored. The frame is rendered on the server so the
 * markup can change in a later release without invalidating a single saved post.
 */
import { useInnerBlocksProps } from '@wordpress/block-editor';

export default function save() {
	return <div { ...useInnerBlocksProps.save( { className: 'ep-hero__actions' } ) } />;
}
