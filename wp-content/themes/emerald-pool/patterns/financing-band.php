<?php
/**
 * Title: Financing band
 * Slug: emerald-pool/financing-band
 * Categories: emerald-pool/section
 * Description: One line about the credit terms, on a hairline rather than in a tinted box.
 * Keywords: financing, credit, payments, terms
 *
 * @package EmeraldPool\Theme
 */

/*
 * This used to be a pale blue panel, which made a routine piece of commercial
 * information look like an offer banner. It is a fact, so it is set as one: a
 * rule, the terms in the data face, and the link to the detail.
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:custom|gutter","right":"var:custom|gutter"}}},"layout":{"type":"constrained","wideSize":"1440px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--custom--gutter);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--custom--gutter)"><!-- wp:group {"className":"ep-finance ep-reveal","align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group alignwide ep-finance ep-reveal"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-small-font-size">Financing</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ep-finance__terms"} -->
<p class="ep-finance__terms">Nothing down, 12 months at 0%</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small","textColor":"text-muted"} -->
<p class="has-text-muted-color has-text-color has-small-font-size">Subject to credit approval through our lending partner. Asking us to run the numbers costs nothing and does not touch your credit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-link-arrow"} -->
<div class="wp-block-button is-style-link-arrow"><a class="wp-block-button__link wp-element-button" href="/financing/">See the terms</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
