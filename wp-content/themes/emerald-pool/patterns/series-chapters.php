<?php
/**
 * Title: Series chapters
 * Slug: emerald-pool/series-chapters
 * Categories: emerald-pool/product
 * Description: The six series as full-bleed alternating chapters — image one side, the argument the other.
 * Keywords: series, collection, chapters, range
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * Chapter 02, and the replacement for the six identical boxed tiles the first
 * build used. Six tiles told a visitor there were six things; they did not say
 * what any of them was. The content here is genuinely six distinct arguments,
 * so each gets a full band, alternating side to side, with the image bled to
 * the viewport edge and the text held off the centre line.
 *
 * The array is the only thing to edit when the range changes.
 */
$ep_series = array(
	array( 'a-series', 'A Series', 'Luxury', 'spa-a7d.jpg', 'Every seat backs onto a JetPak you can lift out with two hands and swap for a different massage. The shell stays; the therapy follows whoever is in it.' ),
	array( 'm-series', 'M Series', 'Elite', 'spa-m8.jpg', 'More water, more pumps, elevated seating and the water returns hidden in the shell. The M9 is the largest spa either showroom stocks, and it needs a poured pad.' ),
	array( 'x-series', 'X Series', 'Comfort', 'spa-x7.jpg', 'The same shell and the same insulation without the JetPak wall. The most spa per pound we sell, and the easiest full-size model to get through a side gate.' ),
	array( 'stil', 'STIL', 'Modern', 'spa-stil7.jpg', 'A flush square cabinet and a low profile, with the hardware behind removable panels. The one architects specify, and the one that stops looking like a hot tub when the cover is on.' ),
	array( 'calm', 'Calm', 'Value', 'spa-calm7.jpg', 'One pump, seven seats, and the same cover and insulation as everything above it — which is where the running cost actually comes from. The answer when the brief is simply "a hot tub".' ),
	array( 'swim-series', 'Swim Series', 'Performance', 'spa-s200.jpg', 'Swim at one end against a current, soak at the other. Three lengths from twelve to seventeen feet; the deep one is five feet through, which is the difference between training and treading water.' ),
);
?>
<!-- wp:group {"className":"ep-night ep-night--deep","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|60","left":"var:custom|gutter","right":"var:custom|gutter"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","wideSize":"1440px"}} -->
<div class="wp-block-group alignfull ep-night ep-night--deep" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--custom--gutter);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--custom--gutter)"><!-- wp:group {"className":"ep-bay ep-reveal","align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide ep-bay ep-reveal"><!-- wp:group {"className":"ep-bay__lede","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group ep-bay__lede"><!-- wp:paragraph {"className":"ep-numeral"} -->
<p class="ep-numeral">02</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Six families, one fit</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":2,"className":"is-style-statement"} -->
<h2 class="wp-block-heading is-style-statement">The range, in six sentences</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"ep-bay__aside","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group ep-bay__aside"><!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">Series is the decision that narrows everything else. Read these six and you will already know which two models to sit in.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull"><!-- wp:html -->
<?php foreach ( $ep_series as $ep_i => $ep_item ) : ?>
<section class="ep-chapter ep-night<?php echo 0 === $ep_i % 2 ? '' : ' ep-night--deep'; ?>">
	<div class="ep-chapter__media">
		<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $ep_item[3] ) ); ?>" alt="<?php echo esc_attr( $ep_item[1] ); ?> spa, seen from above" loading="lazy" decoding="async" width="720" height="540">
	</div>
	<div class="ep-chapter__body ep-reveal">
		<p class="ep-numeral ep-numeral--solid"><?php echo esc_html( str_pad( (string) ( $ep_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
		<h3 class="ep-chapter__title"><a href="/series/<?php echo esc_attr( $ep_item[0] ); ?>/"><?php echo esc_html( $ep_item[1] ); ?></a></h3>
		<p class="ep-chapter__class"><?php echo esc_html( $ep_item[2] ); ?></p>
		<p class="ep-chapter__text"><?php echo esc_html( $ep_item[4] ); ?></p>
	</div>
</section>
<?php endforeach; ?>
<!-- /wp:html --></div>
<!-- /wp:group -->
