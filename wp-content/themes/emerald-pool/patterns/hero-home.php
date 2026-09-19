<?php
/**
 * Title: Home hero
 * Slug: emerald-pool/hero-home
 * Categories: emerald-pool/hero
 * Description: Full-bleed opening image with the headline promise and two next steps.
 * Keywords: hero, banner, opening
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

$ep_hero = wp_json_encode(
	array(
		'mediaUrl'       => get_theme_file_uri( 'assets/images/hero-backyard.jpg' ),
		'mediaAlt'       => 'An Oregon backyard at dusk, steam rising off a lit hot tub under fir trees',
		'eyebrow'        => 'Eugene &amp; Bend, Oregon',
		'heading'        => 'Warm water is a winter plan',
		'standfirst'     => 'Three generations of getting Oregon backyards right — hot tubs, swim spas, pools, and the patio around them.',
		'overlayOpacity' => 58,
		'minHeight'      => 74,
		'align'          => 'full',
	)
);
?>
<!-- wp:emerald-pool/spa-hero <?php echo $ep_hero; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON block attributes. ?> -->
<div class="ep-hero__actions"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"accent","textColor":"deep"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-deep-color has-accent-background-color has-text-color has-background wp-element-button" href="/spa-type/hot-tubs/">Browse hot tubs</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline-quiet"} -->
<div class="wp-block-button is-style-outline-quiet"><a class="wp-block-button__link wp-element-button" href="/contact/">Book a site visit</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:emerald-pool/spa-hero -->
