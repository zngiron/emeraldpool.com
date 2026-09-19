<?php
/**
 * Specs Table — server render.
 *
 * Rows come from the meta fields flagged `specs` in config/brand.json, in the
 * order they are declared there. A field with no value is skipped rather than
 * printed empty.
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

$z_post_id = (int) ( $attributes['postId'] ?? 0 );
$z_post_id = $z_post_id ?: (int) ( $block->context['postId'] ?? 0 );
$z_post_id = $z_post_id ?: (int) get_the_ID();
$z_rows    = $z_post_id ? Meta::rows( $z_post_id, 'specs' ) : array();

if ( ! $z_rows ) {
    return;
}
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'z-specs' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
    <?php if ( ! empty( $attributes['heading'] ) ) : ?>
        <h2 class="z-specs__heading"><?php echo esc_html( (string) $attributes['heading'] ); ?></h2>
    <?php endif; ?>

    <dl class="z-specs__list">
        <?php foreach ( $z_rows as $z_label => $z_value ) : ?>
            <div class="z-specs__row">
                <dt class="z-specs__label"><?php echo esc_html( (string) $z_label ); ?></dt>
                <dd class="z-specs__value"><?php echo esc_html( (string) $z_value ); ?></dd>
            </div>
        <?php endforeach; ?>
    </dl>
</div>
