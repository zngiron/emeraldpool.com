<?php
/**
 * Marquee — server render.
 *
 * The line is printed twice so the loop has something to scroll into. The copy
 * is hidden from assistive technology, which reads the first one only.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_text = trim( (string) ( $attributes['text'] ?? '' ) );

if ( '' === $z_text ) {
    return;
}

$z_speed = max( 10, min( 90, (int) ( $attributes['speed'] ?? 30 ) ) );
?>
<div
    <?php echo get_block_wrapper_attributes( array( 'class' => 'z-marquee' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
    style="--z-marquee-duration: <?php echo esc_attr( (string) $z_speed ); ?>s"
>
    <div class="z-marquee__track">
        <p class="z-marquee__text"><?php echo esc_html( $z_text ); ?></p>
        <p class="z-marquee__text" aria-hidden="true"><?php echo esc_html( $z_text ); ?></p>
    </div>
</div>
