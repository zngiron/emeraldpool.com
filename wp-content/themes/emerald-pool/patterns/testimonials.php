<?php
/**
 * Title: Testimonials
 * Slug: emerald-pool/testimonials
 * Categories: emerald-pool/social
 * Description: A full-bleed lifestyle photograph with the quotes set over it. Reader-controlled, no autoplay.
 * Keywords: testimonial, review, quote
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * The one place on the page where a photograph of people carries the whole band
 * rather than sitting in a column beside it. The quotes are set over the image
 * at display scale, so the section reads as a spread rather than as a widget.
 *
 * The slider is still reader-controlled: nothing advances on its own, off-screen
 * quotes are inert, and position is announced politely.
 */
?>
<!-- wp:group {"className":"ep-quote-band ep-night","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80","left":"var:custom|gutter","right":"var:custom|gutter"}}},"layout":{"type":"constrained","wideSize":"1440px"}} -->
<div class="wp-block-group alignfull ep-quote-band ep-night" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--custom--gutter);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--custom--gutter)"><!-- wp:html -->
<img class="ep-quote-band__media" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/lifestyle-friends.jpg' ) ); ?>" alt="Three friends talking in a lit hot tub on a covered patio after dark" loading="lazy" decoding="async" width="1600" height="1067">
<span class="ep-quote-band__scrim" aria-hidden="true"></span>
<!-- /wp:html -->

<!-- wp:group {"className":"ep-quote-band__inner ep-reveal","align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group alignwide ep-quote-band__inner ep-reveal"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
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
<!-- /wp:group --></div>
<!-- /wp:group -->
