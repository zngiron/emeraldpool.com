<?php
/**
 * Testimonials — server render.
 *
 * Every quote is in the HTML; the track only moves which one is shown. Quotes
 * that are off screen are made inert by view.js so keyboard focus never lands
 * on something nobody can read.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_items = array_values(
    array_filter(
        (array) ( $attributes['items'] ?? array() ),
        static fn( $item ): bool => ! empty( $item['quote'] )
    )
);

if ( ! $z_items ) {
    return;
}
?>
<div
    <?php echo get_block_wrapper_attributes( array( 'class' => 'z-testimonials' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
    data-wp-interactive="zngiron/testimonials"
    <?php echo wp_interactivity_data_wp_context( array( 'active' => 0, 'total' => count( $z_items ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
    data-wp-watch="callbacks.syncSlides"
>
    <?php if ( ! empty( $attributes['heading'] ) ) : ?>
        <h2 class="z-testimonials__heading"><?php echo wp_kses_post( (string) $attributes['heading'] ); ?></h2>
    <?php endif; ?>

    <div class="z-testimonials__viewport">
        <div class="z-testimonials__track" data-wp-style--transform="state.trackTransform">
            <?php foreach ( $z_items as $z_item ) : ?>
                <figure class="z-testimonial">
                    <blockquote class="z-testimonial__quote"><?php echo wp_kses_post( (string) $z_item['quote'] ); ?></blockquote>
                    <figcaption class="z-testimonial__by">
                        <?php echo esc_html( trim( (string) ( $z_item['name'] ?? '' ) . ( ! empty( $z_item['role'] ) ? ' — ' . $z_item['role'] : '' ) ) ); ?>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if ( count( $z_items ) > 1 ) : ?>
        <div class="z-testimonials__controls">
            <button
                type="button"
                class="z-testimonials__button"
                data-wp-on--click="actions.previous"
                data-wp-bind--disabled="state.isFirst"
            ><?php esc_html_e( 'Previous', 'zngiron-blocks' ); ?></button>

            <p class="z-testimonials__position" aria-live="polite" data-wp-text="state.position"></p>

            <button
                type="button"
                class="z-testimonials__button"
                data-wp-on--click="actions.next"
                data-wp-bind--disabled="state.isLast"
            ><?php esc_html_e( 'Next', 'zngiron-blocks' ); ?></button>
        </div>
    <?php endif; ?>
</div>
