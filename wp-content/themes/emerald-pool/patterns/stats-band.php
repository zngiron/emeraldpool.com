<?php
/**
 * Title: Stats band
 * Slug: emerald-pool/stats-band
 * Categories: emerald-pool/section
 * Description: Chapter four: four figures about the business against a heading that stays put while they pass.
 * Keywords: stats, numbers, about, trust
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * Chapter 04. The close of the argument: a business that has been doing this
 * since Eisenhower. The figures are rendered at their real value on the server
 * and only replayed by the block's view script, so the section is complete
 * before any JavaScript runs.
 */
$ep_stats = wp_json_encode(
	array(
		'heading'    => 'Seventy years of the same job',
		'standfirst' => 'Three generations, two showrooms, one service department. Nothing here is franchised.',
		'items'      => array(
			array( 'value' => 1955, 'label' => 'Trading in Oregon since', 'format' => 'plain' ),
			array( 'value' => 3, 'label' => 'Generations of the same family behind the counter' ),
			array( 'value' => 11000, 'label' => 'Spas delivered and set across the Willamette Valley and Central Oregon', 'prefix' => 'over' ),
			array( 'value' => 12, 'label' => 'Technicians and delivery crew on staff, none of them subcontracted' ),
		),
	)
);
?>
<!-- wp:group {"className":"ep-night","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80","left":"var:custom|gutter","right":"var:custom|gutter"}}},"layout":{"type":"constrained","wideSize":"1440px"}} -->
<div class="wp-block-group alignfull ep-night" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--custom--gutter);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--custom--gutter)"><!-- wp:group {"className":"ep-reveal","align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ep-reveal"><!-- wp:paragraph {"className":"ep-numeral"} -->
<p class="ep-numeral">04</p>
<!-- /wp:paragraph -->

<!-- wp:emerald-pool/spa-stats <?php echo $ep_stats; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON block attributes. ?> /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
