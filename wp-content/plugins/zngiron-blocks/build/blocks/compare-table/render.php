<?php
/**
 * Compare Table — server render.
 *
 * One row per meta field flagged `compare`, one column per chosen post. A field
 * nobody in the comparison has a value for is dropped, so the table never grows
 * a row of dashes.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_ids = array_slice( array_filter( array_map( 'intval', (array) ( $attributes['postIds'] ?? array() ) ) ), 0, 3 );

if ( count( $z_ids ) < 2 ) {
    return;
}

$z_fields = Meta::fields_for( 'compare', (string) get_post_type( $z_ids[0] ) );
$z_rows   = array();

foreach ( $z_fields as $z_key => $z_field ) {
    $z_values = array();
    $z_filled = false;

    foreach ( $z_ids as $z_id ) {
        $z_value    = Meta::display_value( $z_id, $z_key );
        $z_values[] = $z_value;
        $z_filled   = $z_filled || '' !== $z_value;
    }

    if ( $z_filled ) {
        $z_rows[ (string) $z_field['label'] ] = $z_values;
    }
}

if ( ! $z_rows ) {
    return;
}
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'z-compare' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
    <?php if ( ! empty( $attributes['heading'] ) ) : ?>
        <h2 class="z-compare__heading"><?php echo esc_html( (string) $attributes['heading'] ); ?></h2>
    <?php endif; ?>

    <table class="z-compare__table">
        <thead>
            <tr>
                <th scope="col"><span class="screen-reader-text"><?php esc_html_e( 'Specification', 'zngiron-blocks' ); ?></span></th>
                <?php foreach ( $z_ids as $z_id ) : ?>
                    <th scope="col">
                        <a href="<?php echo esc_url( (string) get_permalink( $z_id ) ); ?>"><?php echo esc_html( get_the_title( $z_id ) ); ?></a>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $z_rows as $z_label => $z_values ) : ?>
                <tr>
                    <th scope="row"><?php echo esc_html( (string) $z_label ); ?></th>
                    <?php foreach ( $z_values as $z_value ) : ?>
                        <td><?php echo esc_html( $z_value ?: '—' ); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
