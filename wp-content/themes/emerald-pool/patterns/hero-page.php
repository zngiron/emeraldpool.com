<?php
/**
 * Title: Page hero
 * Slug: emerald-pool/hero-page
 * Categories: emerald-pool/hero
 * Description: A shorter hero for section landing pages.
 * Keywords: hero, header, section
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

$ep_hero = wp_json_encode(
	array(
		'mediaUrl'       => get_theme_file_uri( 'assets/images/hero-hot-tubs.jpg' ),
		'mediaAlt'       => 'A hot tub on a covered deck, lid open, water still',
		'eyebrow'        => 'Hot tubs',
		'heading'        => 'Six to nine seats, built for Oregon',
		'standfirst'     => 'Every model here is insulated for a wet, cold winter and serviced by our own people.',
		'overlayOpacity' => 52,
		'minHeight'      => 46,
		'align'          => 'full',
	)
);
?>
<!-- wp:emerald-pool/spa-hero <?php echo $ep_hero; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON block attributes. ?> -->
<div class="ep-hero__actions"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"accent","textColor":"deep"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-deep-color has-accent-background-color has-text-color has-background wp-element-button" href="/contact/">Request a quote</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:emerald-pool/spa-hero -->
