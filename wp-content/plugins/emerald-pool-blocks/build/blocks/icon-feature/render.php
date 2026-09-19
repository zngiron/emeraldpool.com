<?php
/**
 * Feature — server render.
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

$ep_title = trim( (string) ( $attributes['title'] ?? '' ) );

if ( '' === $ep_title ) {
	return;
}
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'ep-feature' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
	<?php echo Icons::svg( (string) ( $attributes['icon'] ?? 'droplet' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in Icons::svg(). ?>

	<h3 class="ep-feature__title"><?php echo wp_kses_post( $ep_title ); ?></h3>

	<?php if ( ! empty( $attributes['text'] ) ) : ?>
		<p class="ep-feature__text"><?php echo wp_kses_post( (string) $attributes['text'] ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $attributes['linkUrl'] ) && ! empty( $attributes['linkText'] ) ) : ?>
		<a class="ep-feature__link" href="<?php echo esc_url( (string) $attributes['linkUrl'] ); ?>">
			<?php echo esc_html( (string) $attributes['linkText'] ); ?>
		</a>
	<?php endif; ?>
</div>
