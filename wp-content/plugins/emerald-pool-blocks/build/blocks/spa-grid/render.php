<?php
/**
 * Spa grid — server render.
 *
 * @package EmeraldPool\Blocks
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner content (unused).
 * @var WP_Block $block      Block instance.
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

$ep_columns  = max( 2, min( 4, (int) ( $attributes['columns'] ?? 3 ) ) );
$ep_tax_query = array();

/*
 * On a spa_type or spa_series archive with no term set on the block, take the
 * term being viewed. That is what lets the taxonomy templates drop core's query
 * loop and use the real card — the plan on its sand field, the spec chips and
 * the price — instead of a bare featured image cropped to 4:3.
 */
if ( empty( $attributes['spaType'] ) && empty( $attributes['series'] ) && is_tax( array( 'spa_type', 'spa_series' ) ) ) {
	$ep_term = get_queried_object();
	if ( $ep_term instanceof \WP_Term ) {
		$attributes[ 'spa_type' === $ep_term->taxonomy ? 'spaType' : 'series' ] = $ep_term->slug;
	}
}

if ( ! empty( $attributes['spaType'] ) ) {
	$ep_tax_query[] = array(
		'taxonomy' => 'spa_type',
		'field'    => 'slug',
		'terms'    => sanitize_title( (string) $attributes['spaType'] ),
	);
}

if ( ! empty( $attributes['series'] ) ) {
	$ep_tax_query[] = array(
		'taxonomy' => 'spa_series',
		'field'    => 'slug',
		'terms'    => sanitize_title( (string) $attributes['series'] ),
	);
}

$ep_current = (int) ( $block->context['postId'] ?? 0 );

if ( ! $ep_current && isset( $_GET['post_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- editor preview only.
	$ep_current = (int) $_GET['post_id']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

$ep_query = new \WP_Query(
	array(
		'post_type'              => Meta::POST_TYPE,
		'post_status'            => 'publish',
		'posts_per_page'         => max( 1, (int) ( $attributes['numberOfItems'] ?? 6 ) ),
		'orderby'                => in_array( $attributes['orderBy'] ?? '', array( 'title', 'date' ), true ) ? $attributes['orderBy'] : 'menu_order',
		// Newest first only when ordering by date; menu_order and title read top-down.
		'order'                  => 'date' === ( $attributes['orderBy'] ?? '' ) ? 'DESC' : 'ASC',
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'post__not_in'           => ! empty( $attributes['excludeCurrent'] ) && $ep_current ? array( $ep_current ) : array(),
		'tax_query'              => $ep_tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		'update_post_term_cache' => true,
	)
);

if ( ! $ep_query->have_posts() ) {
	printf(
		'<div %1$s>%2$s</div>',
		wp_kses_data( get_block_wrapper_attributes( array( 'class' => 'ep-grid-block' ) ) ),
		Cards::empty_state( __( 'No spas match this selection yet. Publish a spa, or widen the filter in the sidebar.', 'emerald-pool-blocks' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in empty_state().
	);

	return;
}

/*
 * Collect the cards once, tracking which series are present so the chips only
 * ever offer filters that will return something.
 */
$ep_cards  = array();
$ep_counts = array( '' => 0 );
$ep_labels = array( '' => __( 'all series', 'emerald-pool-blocks' ) );

foreach ( $ep_query->posts as $ep_post ) {
	$ep_id         = (int) $ep_post->ID;
	$ep_slug       = Cards::first_term_slug( $ep_id, 'spa_series' );
	$ep_cards[]    = array(
		'series' => $ep_slug,
		'html'   => Cards::card( $ep_id, array( 'show_price' => ! empty( $attributes['showPrice'] ) ) ),
	);
	$ep_counts[''] = ( $ep_counts[''] ?? 0 ) + 1;

	if ( $ep_slug ) {
		$ep_counts[ $ep_slug ] = ( $ep_counts[ $ep_slug ] ?? 0 ) + 1;
		$ep_labels[ $ep_slug ] = Cards::first_term_name( $ep_id, 'spa_series' );
	}
}

$ep_show_filters = ! empty( $attributes['showFilters'] ) && count( $ep_labels ) > 2;

$ep_context = array(
	'activeSeries'    => '',
	'counts'          => $ep_counts,
	'labels'          => $ep_labels,
	/* translators: 1: number of models, 2: series name. */
	'messageTemplate' => __( 'Showing %1$s models in %2$s.', 'emerald-pool-blocks' ),
);

$ep_wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'ep-grid-block has-' . $ep_columns . '-columns',
	)
);
?>
<div
	<?php echo $ep_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
	<?php if ( $ep_show_filters ) : ?>
		data-wp-interactive="emerald-pool/spa-grid"
		<?php echo wp_interactivity_data_wp_context( $ep_context ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
	<?php endif; ?>
>
	<?php if ( $ep_show_filters ) : ?>
		<div class="ep-grid__filters" role="group" aria-label="<?php esc_attr_e( 'Filter spas by series', 'emerald-pool-blocks' ); ?>">
			<?php foreach ( $ep_labels as $ep_slug => $ep_label ) : ?>
				<button
					type="button"
					class="ep-filter"
					data-series="<?php echo esc_attr( (string) $ep_slug ); ?>"
					data-wp-on--click="actions.filter"
					data-wp-bind--aria-pressed="state.isPressed"
					aria-pressed="<?php echo '' === $ep_slug ? 'true' : 'false'; ?>"
				>
					<?php echo esc_html( ucfirst( (string) $ep_label ) ); ?>
					<span class="ep-filter__count"><?php echo esc_html( (string) ( $ep_counts[ $ep_slug ] ?? 0 ) ); ?></span>
				</button>
			<?php endforeach; ?>
		</div>
		<p class="screen-reader-text" aria-live="polite" data-wp-text="state.resultsMessage"></p>
	<?php endif; ?>

	<ul class="ep-grid" role="list">
		<?php foreach ( $ep_cards as $ep_card ) : ?>
			<li
				class="ep-grid__item"
				data-series="<?php echo esc_attr( (string) $ep_card['series'] ); ?>"
				<?php if ( $ep_show_filters ) : ?>
					data-wp-bind--hidden="state.isHidden"
				<?php endif; ?>
			>
				<?php echo $ep_card['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in Cards::card(). ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php
wp_reset_postdata();
