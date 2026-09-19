<?php
/**
 * Title: Section — journal grid
 * Slug: zngiron-base/journal-grid
 * Categories: zngiron-section
 * Description: The three most recent journal posts, rendered as the same Card the catalogue uses.
 *
 * @package Zngiron\Theme
 */

?>
<!-- wp:group {"className":"z-section","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull z-section"><!-- wp:group {"className":"z-lede z-reveal","align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide z-lede z-reveal"><!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-small-font-size">From the service counter</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"className":"is-style-statement"} -->
<h3 class="wp-block-heading is-style-statement">Things worth knowing before you ask</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">Buying guides, maintenance notes and seasonal reminders, written by the people who take the calls.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:zngiron/post-grid {"postType":"post","count":3,"columns":3,"orderBy":"date","order":"DESC","align":"wide"} /--></div>
<!-- /wp:group -->
