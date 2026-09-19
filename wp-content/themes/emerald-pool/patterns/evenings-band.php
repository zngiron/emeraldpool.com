<?php
/**
 * Title: Evenings — the editorial band
 * Slug: emerald-pool/evenings-band
 * Categories: emerald-pool/editorial
 * Description: A full-bleed photograph of the thing a spa is actually for, with one short argument set into the frame.
 * Keywords: lifestyle, editorial, band, evenings, photograph
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * The interval between chapter 01 (what we sell) and chapter 02 (the range).
 *
 * Two product sections in a row is a catalogue. This band is the sentence
 * between them: one photograph at 21:9, no card, no grid, no price, and one
 * paragraph about the only thing the product is bought for. It is the only band
 * on the page with no call to action in it, which is the point — it is not
 * selling, it is reminding.
 *
 * The frame is 21:9 on desktop and 4:5 on a phone, because a letterbox crop of
 * a person on a 390px screen leaves a face two centimetres tall. The focal point
 * is above centre in both, so the subject survives the narrower crop.
 */
?>
<!-- wp:group {"className":"ep-night ep-band","align":"full","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull ep-night ep-band"><!-- wp:html -->
<figure class="ep-band__frame">
	<img
		class="ep-band__media"
		src="<?php echo esc_url( get_theme_file_uri( 'assets/images/band-evenings.jpg' ) ); ?>"
		alt="A woman alone in a steaming hot tub at dusk, bare autumn trees behind her"
		width="2100"
		height="900"
		sizes="100vw"
		loading="lazy"
		decoding="async">
	<span class="ep-band__scrim" aria-hidden="true"></span>
</figure>
<!-- /wp:html -->

<!-- wp:group {"className":"ep-band__inner ep-reveal","align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group alignwide ep-band__inner ep-reveal"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Between November and March</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":2,"className":"is-style-statement"} -->
<h2 class="wp-block-heading is-style-statement">The forty minutes nobody schedules</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"ep-band__text","fontSize":"medium"} -->
<p class="ep-band__text has-medium-font-size">It rains here from October. The spa is the one part of an Oregon backyard that gets <em>more</em> use when the weather turns — forty minutes after dinner, in the dark, in the rain, with the lid off and the steam going straight up. That is the whole argument. Everything else on this page is detail.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
