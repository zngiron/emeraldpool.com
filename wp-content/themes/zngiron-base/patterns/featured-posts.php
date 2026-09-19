<?php
/**
 * Title: Section — featured models
 * Slug: zngiron-base/featured-posts
 * Categories: zngiron-section
 * Description: A Post Grid over the catalogue, with filter chips, under a two-part section head.
 *
 * @package Zngiron\Theme
 */

?>
<!-- wp:group {"className":"z-section","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull z-section"><!-- wp:group {"className":"z-lede z-reveal","align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide z-lede z-reveal"><!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-small-font-size">On the floor now</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"className":"is-style-statement"} -->
<h3 class="wp-block-heading is-style-statement">The models we keep filled and heated</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">Filter by series. Prices start from the model as we configure it on the floor, before delivery, electrical and options.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:zngiron/post-grid {"postType":"spa","count":6,"columns":3,"showFilters":true,"filterTaxonomy":"spa_series","align":"wide"} /--></div>
<!-- /wp:group -->
