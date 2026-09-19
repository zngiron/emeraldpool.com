<?php
/**
 * Testimonial slider — server render.
 *
 * The inner quotes are saved as normal post content; only the frame, the
 * controls and the Interactivity directives are produced here.
 *
 * @package EmeraldPool\Blocks
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered quotes, already wrapped in .ep-slider__track.
 * @var WP_Block $block      Block instance.
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

if ( '' === trim( (string) $content ) ) {
	return;
}

$ep_label = (string) ( $attributes['label'] ?? __( 'What customers say', 'emerald-pool-blocks' ) );

$ep_wrapper = get_block_wrapper_attributes( array( 'class' => 'ep-slider' ) );

// The track needs the transform directive; it is added to the saved wrapper here.
$ep_track = new \WP_HTML_Tag_Processor( (string) $content );

if ( $ep_track->next_tag( array( 'class_name' => 'ep-slider__track' ) ) ) {
	$ep_track->set_attribute( 'data-wp-style--transform', 'state.trackTransform' );
}

$ep_content = $ep_track->get_updated_html();
?>
<div
	<?php echo $ep_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
	data-wp-interactive="emerald-pool/testimonial-slider"
	<?php echo wp_interactivity_data_wp_context( array( 'active' => 0, 'total' => 0 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
	data-wp-init="callbacks.init"
	data-wp-watch="callbacks.syncSlides"
	role="group"
	aria-roledescription="carousel"
	aria-label="<?php echo esc_attr( $ep_label ); ?>"
>
	<div class="ep-slider__viewport" data-wp-on--keydown="actions.keydown">
		<?php echo $ep_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks. ?>
	</div>

	<div class="ep-slider__controls">
		<button type="button" class="ep-slider__button" data-wp-on--click="actions.previous" data-wp-bind--disabled="state.isFirst">
			<span class="screen-reader-text"><?php esc_html_e( 'Previous quote', 'emerald-pool-blocks' ); ?></span>
			<span aria-hidden="true">&#8592;</span>
		</button>
		<p class="ep-slider__position" aria-live="polite" data-wp-text="state.position"></p>
		<button type="button" class="ep-slider__button" data-wp-on--click="actions.next" data-wp-bind--disabled="state.isLast">
			<span class="screen-reader-text"><?php esc_html_e( 'Next quote', 'emerald-pool-blocks' ); ?></span>
			<span aria-hidden="true">&#8594;</span>
		</button>
	</div>
</div>
