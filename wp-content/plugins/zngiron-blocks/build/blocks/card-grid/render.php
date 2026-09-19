<?php
/**
 * Card Grid — server render.
 *
 * @package Zngiron\Blocks
 *
 * @var array  $attributes Block attributes.
 * @var string $content    Rendered Card children.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

if ( '' === trim( (string) $content ) ) {
    return;
}

$z_columns = max( 2, min( 4, (int) ( $attributes['columns'] ?? 3 ) ) );
$z_wrapper = get_block_wrapper_attributes( array( 'class' => 'z-card-grid has-' . $z_columns . '-columns' ) );
?>
<div <?php echo $z_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
    <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks. ?>
</div>
