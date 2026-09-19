<?php
/**
 * Title: Journal grid
 * Slug: emerald-pool/blog-grid
 * Categories: emerald-pool/editorial
 * Description: The latest three posts, image-led, on a warm sand ground.
 * Keywords: blog, posts, journal, articles
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * The one sand-ground band on the page. It sits between the two shops and the
 * footer so the closing statement lands on night again, and it gives the warm
 * token a section of its own rather than leaving it to do everything in
 * one-line accents.
 */
?>
<!-- wp:group {"className":"ep-section","align":"full","backgroundColor":"sand","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull ep-section has-sand-background-color has-background"><!-- wp:group {"className":"ep-bay ep-reveal","align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ep-bay ep-reveal"><!-- wp:group {"className":"ep-bay__lede","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group ep-bay__lede"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">From the journal</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":2,"className":"is-style-statement"} -->
<h2 class="wp-block-heading is-style-statement">Reading before buying</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ep-bay__aside","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group ep-bay__aside"><!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">Written by the people who deliver and service them, not by a marketing department.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-link-arrow"} -->
<div class="wp-block-button is-style-link-arrow"><a class="wp-block-button__link wp-element-button" href="/journal/">Everything we have written</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"align":"wide","className":"ep-journal ep-reveal","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide ep-journal ep-reveal"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","className":"is-style-frame"} /-->

<!-- wp:post-terms {"term":"category"} /-->

<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"large"} /-->

<!-- wp:post-excerpt {"excerptLength":22,"fontSize":"small"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>No posts yet.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
