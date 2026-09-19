<?php
/**
 * Title: Featured spas
 * Slug: emerald-pool/featured-spas
 * Categories: emerald-pool/product
 * Description: The first chapter of the home page: three models from the catalogue as plan views on the night ground.
 * Keywords: spa, products, grid, hot tubs
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * Chapter 01. The numbers on the home page are not decoration: the four numbered
 * sections are the order a customer actually moves through — see it, understand
 * the range, have it delivered, have it looked after — so the sequence carries
 * information and is set as a sequence.
 *
 * The cards sit on the night ground because the product renders are top-down
 * shells on white; floating them on black is what turns a catalogue thumbnail
 * into an object.
 */
?>
<!-- wp:group {"className":"ep-night ep-section","align":"full","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull ep-night ep-section"><!-- wp:group {"className":"ep-bay ep-reveal","align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ep-bay ep-reveal"><!-- wp:group {"className":"ep-bay__lede","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group ep-bay__lede"><!-- wp:paragraph {"className":"ep-numeral"} -->
<p class="ep-numeral">01</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">See it, on our floor</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":2,"className":"is-style-statement"} -->
<h2 class="wp-block-heading is-style-statement">The three we sell most of</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ep-bay__aside","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group ep-bay__aside"><!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">Every spa below is filled and heated in Eugene or Bend. Prices are what the model costs as it sits on our floor, before delivery and the electrician.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-link-arrow"} -->
<div class="wp-block-button is-style-link-arrow"><a class="wp-block-button__link wp-element-button" href="/spas/">See every model</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ep-reveal","align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ep-reveal"><!-- wp:emerald-pool/spa-grid {"numberOfItems":3,"columns":3} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
