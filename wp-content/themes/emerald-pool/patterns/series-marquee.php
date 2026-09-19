<?php
/**
 * Title: Series marquee
 * Slug: emerald-pool/series-marquee
 * Categories: emerald-pool/section
 * Description: The six series names running across a single band, each linking to its collection.
 * Keywords: marquee, series, band, ticker
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * A transition between the hero and the catalogue that says what is on sale
 * without spending a section on it. The list is printed twice because the CSS
 * translates the track by exactly half its width — that is what makes the loop
 * seamless without measuring anything in JavaScript. Both copies are real links,
 * but the duplicate is hidden from assistive technology so the six names are
 * announced once.
 */
$ep_series = array(
	'a-series'    => 'A Series',
	'm-series'    => 'M Series',
	'x-series'    => 'X Series',
	'stil'        => 'STIL',
	'calm'        => 'Calm',
	'swim-series' => 'Swim Series',
);
?>
<!-- wp:html -->
<div class="ep-marquee ep-night ep-night--deep">
	<div class="ep-marquee__track">
		<div class="ep-marquee__list">
			<?php foreach ( $ep_series as $ep_slug => $ep_name ) : ?>
				<a class="ep-marquee__item" href="/series/<?php echo esc_attr( $ep_slug ); ?>/"><?php echo esc_html( $ep_name ); ?></a>
			<?php endforeach; ?>
		</div>
		<div class="ep-marquee__list" aria-hidden="true">
			<?php foreach ( $ep_series as $ep_slug => $ep_name ) : ?>
				<span class="ep-marquee__item"><?php echo esc_html( $ep_name ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<!-- /wp:html -->
