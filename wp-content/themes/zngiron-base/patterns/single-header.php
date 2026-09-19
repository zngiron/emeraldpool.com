<?php
/**
 * Title: Opening — single post header
 * Slug: zngiron-base/single-header
 * Categories: zngiron-opening
 * Description: Title, date and terms over a full-bleed featured image in a fixed ratio.
 *
 * @package Zngiron\Theme
 */

?>
<!-- wp:group {"className":"z-section is-tight","align":"full","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull z-section is-tight"><!-- wp:post-terms {"term":"category","fontSize":"small"} /-->

<!-- wp:post-title {"level":1} /-->

<!-- wp:post-excerpt {"fontSize":"medium","textColor":"muted"} /-->

<!-- wp:post-featured-image {"aspectRatio":"16/9","align":"wide"} /--></div>
<!-- /wp:group -->
