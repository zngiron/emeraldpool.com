<?php
/**
 * Hero — server render.
 *
 * @package Zngiron\Blocks
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner content (unused).
 * @var WP_Block $block      Block instance.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_height = in_array( $attributes['height'] ?? '', array( 'full', 'tall', 'short' ), true ) ? $attributes['height'] : 'tall';
$z_frame  = (array) ( $attributes['frame'] ?? array() );

// The hero image is above the fold on every page that has one.
$z_frame['eager'] = true;
$z_frame['size']  = 'full';

// Faces sit right of centre by default so they stay clear of the copy column.
if ( empty( $z_frame['focalPoint'] ) ) {
    $z_frame['focalPoint'] = array(
        'x' => 0.65,
        'y' => 0.5,
    );
}

$z_wrapper = get_block_wrapper_attributes( array( 'class' => 'z-hero is-height-' . $z_height ) );
?>
<section <?php echo $z_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
    <div class="z-hero__frame">
        <?php echo Render::frame( $z_frame ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in frame(). ?>
    </div>

    <div class="z-hero__scrim" aria-hidden="true"></div>

    <div class="z-hero__copy">
        <?php if ( ! empty( $attributes['eyebrow'] ) ) : ?>
            <p class="z-eyebrow"><?php echo wp_kses_post( (string) $attributes['eyebrow'] ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $attributes['heading'] ) ) : ?>
            <h1 class="z-hero__heading"><?php echo wp_kses_post( (string) $attributes['heading'] ); ?></h1>
        <?php endif; ?>

        <?php if ( ! empty( $attributes['text'] ) ) : ?>
            <p class="z-hero__text"><?php echo wp_kses_post( (string) $attributes['text'] ); ?></p>
        <?php endif; ?>

        <?php echo Render::buttons( (array) ( $attributes['buttons'] ?? array() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in buttons(). ?>

        <?php if ( ! empty( $attributes['meta'] ) ) : ?>
            <p class="z-hero__meta"><?php echo wp_kses_post( (string) $attributes['meta'] ); ?></p>
        <?php endif; ?>
    </div>
</section>
