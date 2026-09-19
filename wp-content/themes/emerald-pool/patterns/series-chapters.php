<?php
/**
 * Title: Series chapters
 * Slug: emerald-pool/series-chapters
 * Categories: emerald-pool/product
 * Description: The six series as full-bleed alternating chapters — a photograph or a plan one side, the argument the other.
 * Keywords: series, collection, chapters, range
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

/*
 * Chapter 02, and the replacement for the six identical boxed tiles the first
 * build used. Six tiles told a visitor there were six things; they did not say
 * what any of them was. The content here is genuinely six distinct arguments,
 * so each gets a full band, alternating side to side, with the media bled to the
 * viewport edge and the text held off the centre line.
 *
 * The media alternates in kind as well as in side. Six plan renders in a row is
 * a parts catalogue, and six photographs in a row says nothing about what you
 * are buying, so the chapters run plan, photograph, plan, photograph: the shell
 * you would be sitting in, then somebody sitting in it. A plan is contained on
 * its sheet and never cropped — cropping a drawing throws away the only thing it
 * is for — and a photograph is cropped to fill, because a photograph contained
 * inside a letterbox is a postage stamp.
 *
 * The array is the only thing to edit when the range changes. Columns:
 *   slug, name, class, media file, media kind ('plan'|'photo'), alt, argument.
 */
$ep_series = array(
	array(
		'a-series',
		'A Series',
		'Luxury',
		'spa-a7d.jpg',
		'plan',
		'The Bullfrog A7D seen from above, seven seats and the JetPak wall',
		'Every seat backs onto a JetPak you can lift out with two hands and swap for a different massage. The shell stays; the therapy follows whoever is in it.',
	),
	array(
		'm-series',
		'M Series',
		'Elite',
		'series-m-life.jpg',
		'photo',
		'A family of five in an M Series spa on a roof terrace at dusk',
		'More water, more pumps, elevated seating and the water returns hidden in the shell. The M9 is the largest spa either showroom stocks, and it needs a poured pad.',
	),
	array(
		'x-series',
		'X Series',
		'Comfort',
		'spa-x7.jpg',
		'plan',
		'The Bullfrog X7 seen from above, open seating and no JetPak wall',
		'The same shell and the same insulation without the JetPak wall. The most spa per pound we sell, and the easiest full-size model to get through a side gate.',
	),
	array(
		'stil',
		'STIL',
		'Modern',
		'series-stil-life.jpg',
		'photo',
		'A couple in a STIL spa on a roof terrace, city lights behind them',
		'A flush square cabinet and a low profile, with the hardware behind removable panels. The one architects specify, and the one that stops looking like a hot tub when the cover is on.',
	),
	array(
		'calm',
		'Calm',
		'Value',
		'spa-calm7.jpg',
		'plan',
		'The Bullfrog Calm 7 seen from above, seven seats on one pump',
		'One pump, seven seats, and the same cover and insulation as everything above it — which is where the running cost actually comes from. The answer when the brief is simply "a hot tub".',
	),
	array(
		'swim-series',
		'Swim Series',
		'Performance',
		'series-swim-life.jpg',
		'photo',
		'A family playing at the shallow end of a swim spa, seen from above',
		'Swim at one end against a current, soak at the other. Three lengths from twelve to seventeen feet; the deep one is five feet through, which is the difference between training and treading water.',
	),
);
?>
<!-- wp:group {"className":"ep-night ep-night--deep ep-section","align":"full","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull ep-night ep-night--deep ep-section"><!-- wp:group {"className":"ep-bay ep-reveal","align":"wide","layout":{"type":"default"}} -->
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
	<?php list( $ep_slug, $ep_name, $ep_class, $ep_file, $ep_kind, $ep_alt, $ep_text ) = $ep_item; ?>
<section class="ep-chapter ep-night<?php echo 0 === $ep_i % 2 ? '' : ' ep-night--deep'; ?>">
	<div class="ep-chapter__media ep-chapter__media--<?php echo esc_attr( $ep_kind ); ?>">
		<img
			src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $ep_file ) ); ?>"
			alt="<?php echo esc_attr( $ep_alt ); ?>"
			width="<?php echo 'photo' === $ep_kind ? '1280' : '1000'; ?>"
			height="<?php echo 'photo' === $ep_kind ? '960' : '1000'; ?>"
			sizes="(max-width: 860px) 100vw, 50vw"
			loading="lazy"
			decoding="async">
	</div>
	<div class="ep-chapter__body ep-reveal">
		<p class="ep-numeral ep-numeral--solid"><?php echo esc_html( str_pad( (string) ( $ep_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
		<h3 class="ep-chapter__title"><a href="/series/<?php echo esc_attr( $ep_slug ); ?>/"><?php echo esc_html( $ep_name ); ?></a></h3>
		<p class="ep-chapter__class"><?php echo esc_html( $ep_class ); ?></p>
		<p class="ep-chapter__text"><?php echo esc_html( $ep_text ); ?></p>
	</div>
</section>
<?php endforeach; ?>
<!-- /wp:html --></div>
<!-- /wp:group -->
