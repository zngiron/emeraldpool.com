<?php
/**
 * Post Grid — server render.
 *
 * The query runs on the server and the cards are the same Render::card() the
 * Card block emits, so a grid of posts and a hand-built grid are the same
 * object. The filter chips only hide cards that are already on the page.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_post_type = (string) ( $attributes['postType'] ?? '' ) ?: Config::primary_post_type();
$z_columns   = max( 2, min( 4, (int) ( $attributes['columns'] ?? 3 ) ) );
$z_order_by  = in_array( $attributes['orderBy'] ?? '', array( 'menu_order', 'date', 'title' ), true ) ? (string) $attributes['orderBy'] : 'menu_order';
$z_tax_query = array();

if ( ! empty( $attributes['taxonomy'] ) && ! empty( $attributes['term'] ) ) {
    $z_tax_query[] = array(
        'taxonomy' => sanitize_key( (string) $attributes['taxonomy'] ),
        'field'    => 'slug',
        'terms'    => sanitize_title( (string) $attributes['term'] ),
    );
}

$z_query = new \WP_Query(
    array(
        'post_type'              => $z_post_type,
        'post_status'            => 'publish',
        'posts_per_page'         => max( 1, min( 24, (int) ( $attributes['count'] ?? 6 ) ) ),
        'orderby'                => $z_order_by,
        'order'                  => 'DESC' === ( $attributes['order'] ?? 'ASC' ) ? 'DESC' : 'ASC',
        'ignore_sticky_posts'    => true,
        'no_found_rows'          => true,
        'tax_query'              => $z_tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
        'update_post_term_cache' => true,
    )
);

$z_wrapper = get_block_wrapper_attributes( array( 'class' => 'z-post-grid has-' . $z_columns . '-columns' ) );

if ( ! $z_query->have_posts() ) {
    printf(
        '<div %1$s><p class="z-empty">%2$s</p></div>',
        wp_kses_data( $z_wrapper ),
        esc_html__( 'Nothing published here yet.', 'zngiron-blocks' )
    );

    return;
}

$z_filter_tax = (string) ( $attributes['filterTaxonomy'] ?? '' );
$z_cards      = array();
$z_labels     = array( '' => __( 'All', 'zngiron-blocks' ) );

foreach ( $z_query->posts as $z_post ) {
    $z_id    = (int) $z_post->ID;
    $z_terms = $z_filter_tax ? get_the_terms( $z_id, $z_filter_tax ) : array();
    $z_slug  = ( $z_terms && ! is_wp_error( $z_terms ) ) ? $z_terms[0]->slug : '';

    if ( $z_slug ) {
        $z_labels[ $z_slug ] = $z_terms[0]->name;
    }

    $z_cards[] = array(
        'term' => $z_slug,
        'html' => Render::card(
            array(
                'title' => get_the_title( $z_id ),
                'text'  => wp_strip_all_tags( (string) get_the_excerpt( $z_id ) ),
                'url'   => (string) get_permalink( $z_id ),
                'meta'  => Meta::rows( $z_id, 'compare' ),
                'frame' => array(
                    'mediaId' => (int) get_post_thumbnail_id( $z_id ),
                    'alt'     => get_the_title( $z_id ),
                    'ratio'   => '4:5',
                    'fit'     => 'cover',
                ),
            )
        ),
    );
}

$z_show_filters = ! empty( $attributes['showFilters'] ) && count( $z_labels ) > 2;
?>
<div
    <?php echo $z_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
    data-wp-interactive="zngiron/post-grid"
    <?php echo wp_interactivity_data_wp_context( array( 'activeTerm' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
>
    <?php if ( $z_show_filters ) : ?>
        <div class="z-post-grid__filters" role="group" aria-label="<?php esc_attr_e( 'Filter', 'zngiron-blocks' ); ?>">
            <?php foreach ( $z_labels as $z_slug => $z_label ) : ?>
                <button
                    type="button"
                    class="z-chip"
                    data-term="<?php echo esc_attr( (string) $z_slug ); ?>"
                    data-wp-on--click="actions.filter"
                    data-wp-bind--aria-pressed="state.isPressed"
                >
                    <?php echo esc_html( (string) $z_label ); ?>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="z-post-grid__items">
        <?php foreach ( $z_cards as $z_card ) : ?>
            <div
                class="z-post-grid__item"
                data-term="<?php echo esc_attr( (string) $z_card['term'] ); ?>"
                data-wp-bind--hidden="state.isHidden"
            >
                <?php echo $z_card['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in card(). ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
