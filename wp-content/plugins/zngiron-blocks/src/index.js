/**
 * The plugin's shared stylesheet entry.
 *
 * Only exists so wp-scripts compiles frame.scss into build/style-index.css,
 * which inc/Blocks.php registers as the `zngiron-frame` handle. Blocks list
 * that handle in block.json, so it still loads only on pages that use one.
 */
import './frame.scss';
