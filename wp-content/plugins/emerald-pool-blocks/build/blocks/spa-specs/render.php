<?php
/**
 * Spa specifications — server render.
 *
 * A description list, not a table: these are name/value pairs about one product,
 * which is exactly what <dl> describes. Screen readers announce them in pairs.
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

$ep_post_id = (int) ( $block->context['postId'] ?? 0 );

if ( ! $ep_post_id && isset( $_GET['post_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- editor preview only.
	$ep_post_id = (int) $_GET['post_id']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

if ( ! $ep_post_id ) {
	$ep_post_id = (int) get_the_ID();
}

if ( ! $ep_post_id || Meta::POST_TYPE !== get_post_type( $ep_post_id ) ) {
	return;
}

$ep_groups = Meta::grouped_specs( $ep_post_id );

if ( ! $ep_groups ) {
	if ( is_user_logged_in() && current_user_can( 'edit_post', $ep_post_id ) ) {
		printf(
			'<div %1$s>%2$s</div>',
			wp_kses_data( get_block_wrapper_attributes( array( 'class' => 'ep-specs' ) ) ),
			Cards::empty_state( __( 'No specifications recorded yet. Add them in the spa’s sidebar under Custom fields.', 'emerald-pool-blocks' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in empty_state().
		);
	}

	return;
}

$ep_group_labels = Meta::groups();
$ep_columns      = max( 1, min( 3, (int) ( $attributes['columns'] ?? 2 ) ) );
$ep_headings     = ! empty( $attributes['showGroupHeadings'] );
$ep_brochure     = (string) get_post_meta( $ep_post_id, 'spa_brochure_url', true );
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'ep-specs has-' . $ep_columns . '-columns' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
	<?php if ( ! empty( $attributes['heading'] ) ) : ?>
		<h2 class="ep-specs__heading"><?php echo esc_html( (string) $attributes['heading'] ); ?></h2>
	<?php endif; ?>

	<?php foreach ( $ep_group_labels as $ep_group => $ep_label ) : ?>
		<?php if ( empty( $ep_groups[ $ep_group ] ) ) : ?>
			<?php continue; ?>
		<?php endif; ?>

		<section class="ep-specs__group">
			<?php if ( $ep_headings ) : ?>
				<h3 class="ep-specs__group-title"><?php echo esc_html( $ep_label ); ?></h3>
			<?php endif; ?>

			<dl class="ep-specs__list">
				<?php foreach ( $ep_groups[ $ep_group ] as $ep_row_label => $ep_value ) : ?>
					<div class="ep-specs__row">
						<dt><?php echo esc_html( (string) $ep_row_label ); ?></dt>
						<dd><?php echo esc_html( (string) $ep_value ); ?></dd>
					</div>
				<?php endforeach; ?>
			</dl>
		</section>
	<?php endforeach; ?>

	<?php if ( $ep_brochure ) : ?>
		<p class="ep-specs__brochure">
			<a href="<?php echo esc_url( $ep_brochure ); ?>" rel="noopener">
				<?php
				printf(
					/* translators: %s: spa name. */
					esc_html__( 'Download the %s brochure', 'emerald-pool-blocks' ),
					esc_html( get_the_title( $ep_post_id ) )
				);
				?>
			</a>
		</p>
	<?php endif; ?>
</div>
