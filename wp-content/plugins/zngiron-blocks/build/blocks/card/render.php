<?php
/**
 * Card — server render.
 *
 * The markup itself lives in Render::card(), because Post Grid emits the same
 * card from a post rather than from attributes.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_card = Render::card(
    array(
        'title'    => (string) ( $attributes['title'] ?? '' ),
        'text'     => (string) ( $attributes['text'] ?? '' ),
        'url'      => (string) ( $attributes['url'] ?? '' ),
        'linkText' => (string) ( $attributes['linkText'] ?? '' ),
        'frame'    => (array) ( $attributes['frame'] ?? array() ),
    )
);

if ( '' === trim( wp_strip_all_tags( $z_card ) ) && empty( $attributes['frame'] ) ) {
    return;
}

printf(
    '<div %1$s>%2$s</div>',
    wp_kses_data( get_block_wrapper_attributes( array( 'class' => 'z-card-wrap' ) ) ),
    $z_card // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in card().
);
