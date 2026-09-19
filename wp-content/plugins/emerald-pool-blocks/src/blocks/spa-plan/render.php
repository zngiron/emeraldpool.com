<?php
/**
 * Spa plan view — server render.
 *
 * The single-spa opening. Same language as the card's media: the render is a
 * drawing on paper, so it gets a sheet, a centre cross and its dimensions in
 * the margin — at the scale of a hero rather than a thumbnail.
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

$ep_id = (int) ( $block->context['postId'] ?? get_the_ID() );

if ( ! $ep_id || ! has_post_thumbnail( $ep_id ) ) {
	return;
}

$ep_poster = (string) get_the_post_thumbnail_url( $ep_id, 'large' );
$ep_video  = Media::video( $ep_id, $ep_poster, 'ep-plan__video' );
$ep_dims   = ! empty( $attributes['showDimensions'] ) ? Meta::display_value( $ep_id, 'spa_dimensions' ) : '';
$ep_series = Cards::first_term_name( $ep_id, 'spa_series' );

$ep_wrapper = get_block_wrapper_attributes(
	array( 'class' => 'ep-plan' . ( $ep_video ? ' has-video' : '' ) )
);
?>
<figure <?php echo $ep_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?> data-ep-video-root>
	<?php
	echo get_the_post_thumbnail(
		$ep_id,
		'large',
		array(
			'class'         => 'ep-plan__still',
			'decoding'      => 'async',
			'fetchpriority' => 'high',
		)
	);

	echo $ep_video; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in Media::video().
	?>

	<?php if ( $ep_series || $ep_dims ) : ?>
		<figcaption class="ep-plan__caption">
			<?php if ( $ep_series ) : ?>
				<span class="ep-plan__mark"><?php echo esc_html( $ep_series ); ?></span>
			<?php endif; ?>

			<?php if ( $ep_dims ) : ?>
				<span class="ep-plan__dims"><?php echo esc_html( $ep_dims ); ?></span>
			<?php endif; ?>
		</figcaption>
	<?php endif; ?>
</figure>
