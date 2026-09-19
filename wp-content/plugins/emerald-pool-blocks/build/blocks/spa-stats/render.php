<?php
/**
 * Stat column — server render.
 *
 * The figures are rendered at their real value in the HTML, so the section is
 * complete and correct before any script runs and for anyone who never gets
 * one. The count-up in view.js only re-animates a number that is already there.
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

$ep_items = array_values( array_filter( (array) ( $attributes['items'] ?? array() ) ) );

if ( ! $ep_items ) {
	return;
}

$ep_wrapper = get_block_wrapper_attributes( array( 'class' => 'ep-stats' ) );
?>
<div
	<?php echo $ep_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
	data-wp-interactive="emerald-pool/spa-stats"
>
	<div class="ep-stats__head">
		<?php if ( ! empty( $attributes['heading'] ) ) : ?>
			<h2 class="ep-stats__heading"><?php echo wp_kses_post( (string) $attributes['heading'] ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $attributes['standfirst'] ) ) : ?>
			<p class="ep-stats__standfirst"><?php echo wp_kses_post( (string) $attributes['standfirst'] ); ?></p>
		<?php endif; ?>
	</div>

	<dl class="ep-stats__list">
		<?php
		foreach ( $ep_items as $ep_item ) :
			$ep_value = (float) ( $ep_item['value'] ?? 0 );
			// A year is a label, not a quantity: it is never grouped and never counted.
			$ep_plain = 'plain' === ( $ep_item['format'] ?? '' );
			?>
			<div class="ep-stats__row">
				<dt class="ep-stats__figure">
					<?php if ( ! empty( $ep_item['prefix'] ) ) : ?>
						<span class="ep-stats__affix"><?php echo esc_html( (string) $ep_item['prefix'] ); ?></span>
					<?php endif; ?>

					<span
						class="ep-stats__value"
						<?php if ( ! $ep_plain ) : ?>
							data-wp-init="callbacks.count"
							data-target="<?php echo esc_attr( (string) $ep_value ); ?>"
						<?php endif; ?>
					><?php echo esc_html( $ep_plain ? (string) (int) $ep_value : number_format_i18n( $ep_value ) ); ?></span>

					<?php if ( ! empty( $ep_item['suffix'] ) ) : ?>
						<span class="ep-stats__affix"><?php echo esc_html( (string) $ep_item['suffix'] ); ?></span>
					<?php endif; ?>
				</dt>
				<dd class="ep-stats__label"><?php echo esc_html( (string) ( $ep_item['label'] ?? '' ) ); ?></dd>
			</div>
		<?php endforeach; ?>
	</dl>
</div>
