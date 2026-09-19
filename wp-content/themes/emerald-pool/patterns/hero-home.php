<?php
/**
 * Title: Home hero
 * Slug: emerald-pool/hero-home
 * Categories: emerald-pool/hero
 * Description: A full-viewport opening: the backyard at dusk, the promise bottom-left, the showroom hours bottom-right.
 * Keywords: hero, banner, opening
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * The hero is the thesis. What is characteristic about this business is not a
 * product shot — it is the moment the product exists for: a lit, steaming spa in
 * a wet Oregon winter, at dusk, when nobody else is outside. So the frame is a
 * full viewport of that, the argument is one line at display scale, and the two
 * things a visitor actually came for — which shop, what hours — are pinned to
 * the opposite corner rather than buried three screens down.
 *
 * `videoUrl` is deliberately empty: emeraldpool.com has no self-hosted clip for
 * this frame, and inventing one would be a lie about the brand's own footage.
 * Point it at an uploaded file and the still becomes the poster for it.
 */
$ep_hero = wp_json_encode(
	array(
		'mediaUrl'       => get_theme_file_uri( 'assets/images/hero-winter.jpg' ),
		'mediaAlt'       => 'A lit hot tub in use on a winter evening, steam rising into the cold',
		'videoUrl'       => '',
		'eyebrow'        => 'Eugene &amp; Bend, Oregon · since 1955',
		'heading'        => 'Warm water is a <em>winter</em> plan',
		'standfirst'     => 'Nobody buys a hot tub in July and regrets it in January. Three generations of getting Oregon backyards right.',
		'metaHeading'    => 'Two showrooms, water in both',
		'metaBody'       => "Eugene · Mon–Sat 9–6\nBend · Mon–Fri 9–6, Sat 9–5\nWet tests by appointment",
		'overlayOpacity' => 64,
		'minHeight'      => 92,
		'showScrollCue'  => true,
		'align'          => 'full',
	)
);
?>
<!-- wp:emerald-pool/spa-hero <?php echo $ep_hero; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON block attributes. ?> -->
<div class="ep-hero__actions"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"ember","textColor":"abyss"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-abyss-color has-ember-background-color has-text-color has-background wp-element-button" href="/spa-type/hot-tubs/">See the models</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline-quiet"} -->
<div class="wp-block-button is-style-outline-quiet"><a class="wp-block-button__link wp-element-button" href="/contact/">Book a wet test</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:emerald-pool/spa-hero -->
