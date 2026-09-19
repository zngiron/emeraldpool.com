<?php
/**
 * Title: Testimonials
 * Slug: emerald-pool/testimonials
 * Categories: emerald-pool/social
 * Description: Customer quotes beside a lifestyle photograph. Reader-controlled, no autoplay.
 * Keywords: testimonial, review, quote
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"layout":{"type":"constrained","wideSize":"1280px"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%"><!-- wp:image {"sizeSlug":"large","className":"is-style-soft"} -->
<figure class="wp-block-image size-large is-style-soft"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/lifestyle-friends.jpg' ) ); ?>" alt="Three friends talking in a hot tub on a covered patio"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">From our customers</h3>
<!-- /wp:heading -->

<!-- wp:emerald-pool/testimonial-slider {"label":"Customer testimonials"} -->
<div class="ep-slider__track"><!-- wp:quote {"className":"is-style-testimonial"} -->
<blockquote class="wp-block-quote is-style-testimonial"><!-- wp:paragraph -->
<p>They measured the gate before they sold us anything. The spa went in on the first try, and the crew took the packaging away with them.</p>
<!-- /wp:paragraph --><cite>Dana R. — Eugene</cite></blockquote>
<!-- /wp:quote -->

<!-- wp:quote {"className":"is-style-testimonial"} -->
<blockquote class="wp-block-quote is-style-testimonial"><!-- wp:paragraph -->
<p>Four winters in and the only thing we have replaced is a filter. They still test our water for free.</p>
<!-- /wp:paragraph --><cite>Marcus and Jill T. — Bend</cite></blockquote>
<!-- /wp:quote -->

<!-- wp:quote {"className":"is-style-testimonial"} -->
<blockquote class="wp-block-quote is-style-testimonial"><!-- wp:paragraph -->
<p>I swim in mine every morning before work. It has replaced a gym membership I never used.</p>
<!-- /wp:paragraph --><cite>Priya N. — Springfield</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:emerald-pool/testimonial-slider --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
