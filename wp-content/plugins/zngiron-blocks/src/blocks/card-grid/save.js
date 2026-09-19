/**
 * Card Grid — save. The wrapper is rendered by render.php; only the inner
 * blocks are stored.
 */
import { useInnerBlocksProps, useBlockProps } from '@wordpress/block-editor';

export default function save() {
  return <div { ...useInnerBlocksProps.save( useBlockProps.save() ) } />;
}
