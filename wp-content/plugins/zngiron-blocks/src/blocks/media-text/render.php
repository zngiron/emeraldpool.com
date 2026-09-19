<?php
/**
 * Media Text — server render.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_side    = 'right' === ( $attributes['mediaSide'] ?? 'left' ) ? 'right' : 'left';
$z_wrapper = get_block_wrapper_attributes( array( 'class' => 'z-media-text is-media-' . $z_side ) );
?>
<div <?php echo $z_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
    <div class="z-media-text__media">
        <?php echo Render::frame( (array) ( $attributes['frame'] ?? array() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in frame(). ?>
    </div>

    <div class="z-media-text__copy">
        <?php if ( ! empty( $attributes['eyebrow'] ) ) : ?>
            <p class="z-eyebrow"><?php echo wp_kses_post( (string) $attributes['eyebrow'] ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $attributes['heading'] ) ) : ?>
            <h2 class="z-media-text__heading"><?php echo wp_kses_post( (string) $attributes['heading'] ); ?></h2>
        <?php endif; ?>

        <?php if ( ! empty( $attributes['text'] ) ) : ?>
            <p class="z-media-text__text"><?php echo wp_kses_post( (string) $attributes['text'] ); ?></p>
        <?php endif; ?>

        <?php echo Render::buttons( (array) ( $attributes['buttons'] ?? array() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in buttons(). ?>
    </div>
</div>
