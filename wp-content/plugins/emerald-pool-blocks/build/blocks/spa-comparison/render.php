<?php
/**
 * Spa comparison — server render.
 *
 * A genuine <table>: this is tabular data with a row header per spec and a
 * column header per model, so the semantics carry the meaning for free.
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

$ep_ids = array_values( array_filter( array_map( 'intval', (array) ( $attributes['postIds'] ?? array() ) ) ) );
$ep_ids = array_slice( $ep_ids, 0, 3 );

if ( count( $ep_ids ) < 2 ) {
	printf(
		'<div %1$s>%2$s</div>',
		wp_kses_data( get_block_wrapper_attributes( array( 'class' => 'ep-compare' ) ) ),
		Cards::empty_state( __( 'Choose at least two spas in the block sidebar to build the comparison.', 'emerald-pool-blocks' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in empty_state().
	);

	return;
}

// Collect each spa's specs, then build the union of rows so no field is dropped.
$ep_rows  = array();
$ep_specs = array();

foreach ( $ep_ids as $ep_id ) {
	if ( Meta::POST_TYPE !== get_post_type( $ep_id ) ) {
		continue;
	}

	$ep_flat = array();

	foreach ( Meta::grouped_specs( $ep_id ) as $ep_group ) {
		foreach ( $ep_group as $ep_label => $ep_value ) {
			$ep_flat[ $ep_label ] = $ep_value;
			$ep_rows[ $ep_label ] = true;
		}
	}

	$ep_specs[ $ep_id ] = $ep_flat;
}

$ep_show_images = ! empty( $attributes['showImages'] );
$ep_caption     = (string) ( $attributes['caption'] ?? '' );
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'ep-compare' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
	<div class="ep-compare__scroll" tabindex="0" role="region" aria-label="<?php esc_attr_e( 'Spa comparison table', 'emerald-pool-blocks' ); ?>">
		<table class="ep-compare__table">
			<?php if ( $ep_caption ) : ?>
				<caption><?php echo esc_html( $ep_caption ); ?></caption>
			<?php endif; ?>
			<thead>
				<tr>
					<th scope="col"><span class="screen-reader-text"><?php esc_html_e( 'Specification', 'emerald-pool-blocks' ); ?></span></th>
					<?php foreach ( array_keys( $ep_specs ) as $ep_id ) : ?>
						<th scope="col">
							<?php if ( $ep_show_images && has_post_thumbnail( $ep_id ) ) : ?>
								<span class="ep-compare__media">
									<?php echo get_the_post_thumbnail( $ep_id, 'emerald-card', array( 'loading' => 'lazy' ) ); ?>
								</span>
							<?php endif; ?>
							<span class="ep-compare__series"><?php echo esc_html( Cards::first_term_name( $ep_id, 'spa_series' ) ); ?></span>
							<a class="ep-compare__name" href="<?php echo esc_url( (string) get_permalink( $ep_id ) ); ?>">
								<?php echo esc_html( get_the_title( $ep_id ) ); ?>
							</a>
						</th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( array_keys( $ep_rows ) as $ep_label ) : ?>
					<tr>
						<th scope="row"><?php echo esc_html( (string) $ep_label ); ?></th>
						<?php foreach ( $ep_specs as $ep_values ) : ?>
							<td>
								<?php
								echo isset( $ep_values[ $ep_label ] )
									? esc_html( (string) $ep_values[ $ep_label ] )
									: '<span aria-hidden="true">—</span><span class="screen-reader-text">' . esc_html__( 'not specified', 'emerald-pool-blocks' ) . '</span>';
								?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
