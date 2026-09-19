<?php
/**
 * Feature grid — server render.
 *
 * @package EmeraldPool\Blocks
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered features.
 * @var WP_Block $block      Block instance.
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

if ( '' === trim( (string) $content ) ) {
	return;
}

$ep_columns = max( 2, min( 4, (int) ( $attributes['columns'] ?? 3 ) ) );
$ep_icons   = 'plain' === ( $attributes['iconStyle'] ?? 'badge' ) ? 'plain' : 'badge';

printf(
	'<div %1$s>%2$s</div>',
	get_block_wrapper_attributes( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped.
		array( 'class' => sprintf( 'ep-features has-%d-columns is-icon-%s', $ep_columns, $ep_icons ) )
	),
	$content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks.
);
