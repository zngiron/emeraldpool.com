<?php
/**
 * Title: Home hero
 * Slug: emerald-pool/hero-home
 * Categories: emerald-pool/hero
 * Description: A full-viewport opening: six people in warm water after dark, the promise bottom-left, the showroom hours bottom-right.
 * Keywords: hero, banner, opening
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * The hero is the thesis, and the thesis is not the shell.
 *
 * The first build opened on an empty spa on a snowy deck, which is a product
 * photograph: it told a visitor what is for sale and nothing about why. What is
 * actually characteristic about this business is the evening the spa buys you —
 * six people in the water after dark, a fire going, nobody looking at a phone.
 * So the frame is a full viewport of that, the argument is one line at display
 * scale, and the two things a visitor came for — which shop, what hours — are
 * pinned to the opposite corner rather than buried three screens down.
 *
 * The focal point is held above centre so the faces sit in the upper third and
 * the scrim, which is heaviest at the bottom, falls on water rather than on
 * anybody's face.
 *
 * `videoUrl` is deliberately empty: emeraldpool.com has no self-hosted clip for
 * this frame, and inventing one would be a lie about the brand's own footage.
 * Point it at an uploaded file and the still becomes the poster for it.
 */
$ep_hero = wp_json_encode(
	array(
		'mediaUrl'       => get_theme_file_uri( 'assets/images/hero-evening.jpg' ),
		'mediaAlt'       => 'Six friends talking in a lit hot tub under a timber pavilion after dark, a fire burning behind them',
		'videoUrl'       => '',
		'focalPoint'     => array(
			'x' => 0.5,
			'y' => 0.38,
		),
		'eyebrow'        => 'Eugene &amp; Bend, Oregon · since 1955',
		'heading'        => 'Warm water is a <em>winter</em> plan',
		'standfirst'     => 'Nobody buys a hot tub in July and regrets it in January. Three generations of getting Oregon backyards right.',
		'metaHeading'    => 'Two showrooms, water in both',
		'metaBody'       => "Eugene · Mon–Sat 9–6\nBend · Mon–Fri 9–6, Sat 9–5\nWet tests by appointment",
		'overlayOpacity' => 58,
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
