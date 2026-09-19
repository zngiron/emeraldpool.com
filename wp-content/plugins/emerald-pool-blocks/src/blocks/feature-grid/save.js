/**
 * Feature grid — saved content is the features themselves; the grid frame is
 * rendered on the server.
 */
import { useInnerBlocksProps } from '@wordpress/block-editor';

export default function save() {
	return <div { ...useInnerBlocksProps.save() } />;
}
