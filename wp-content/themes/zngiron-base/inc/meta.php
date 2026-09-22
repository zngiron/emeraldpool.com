<?php
/**
 * Document metadata: description, Open Graph and Twitter cards.
 *
 * WordPress prints a title and a canonical link on its own and nothing else, so
 * a page shared into a chat window arrives as a bare URL. This fills that gap
 * without a plugin: one description, one image, and the handful of properties
 * every consumer actually reads.
 *
 * It stands down the moment a real SEO plugin is active — two sets of og: tags
 * are worse than none — and every value is filterable.
 *
 * @package Zngiron\Theme
 */

declare( strict_types = 1 );

namespace Zngiron\Theme\Meta;

defined( 'ABSPATH' ) || exit;

/**
 * An SEO plugin is already doing this.
 */
function delegated(): bool {
    return defined( 'WPSEO_VERSION' )
        || defined( 'RANK_MATH_VERSION' )
        || defined( 'AIOSEO_VERSION' )
        || defined( 'SEOPRESS_VERSION' )
        || class_exists( '\\Slim_SEO\\Plugin' );
}

/**
 * The description for the current view.
 *
 * A page's own excerpt wins; otherwise the first sentences of its content, with
 * blocks rendered and tags stripped. Archives fall back to the site tagline so
 * the tag is never empty and never a fragment of navigation.
 */
function description(): string {
    $text = get_bloginfo( 'description', 'display' );

    if ( is_singular() ) {
        $post = get_queried_object();

        if ( $post instanceof \WP_Post ) {
            $excerpt = trim( (string) $post->post_excerpt );
            $source  = '' !== $excerpt ? $excerpt : (string) $post->post_content;
            $plain   = trim( wp_strip_all_tags( strip_shortcodes( do_blocks( $source ) ), true ) );

            if ( '' !== $plain ) {
                $text = wp_trim_words( $plain, 32, '…' );
            }
        }
    }

    /**
     * Filter the meta description.
     *
     * @param string $text Description.
     */
    return (string) apply_filters( 'zngiron_base_meta_description', $text );
}

/**
 * The sharing image: the post's featured image, else the logo, else the site icon.
 *
 * @return array{url:string, width:int, height:int, alt:string}|null
 */
function image(): ?array {
    $id = 0;

    if ( is_singular() ) {
        $id = (int) get_post_thumbnail_id();
    }

    if ( ! $id ) {
        $id = (int) get_theme_mod( 'custom_logo' );
    }

    if ( ! $id ) {
        $id = (int) get_option( 'site_icon' );
    }

    /**
     * Filter the attachment used for og:image.
     *
     * @param int $id Attachment ID.
     */
    $id = (int) apply_filters( 'zngiron_base_meta_image_id', $id );

    if ( ! $id ) {
        return null;
    }

    $src = wp_get_attachment_image_src( $id, 'full' );

    if ( ! $src ) {
        return null;
    }

    return array(
        'url'    => (string) $src[0],
        'width'  => (int) $src[1],
        'height' => (int) $src[2],
        'alt'    => (string) get_post_meta( $id, '_wp_attachment_image_alt', true ),
    );
}

/**
 * The canonical URL for the current view.
 */
function url(): string {
    if ( is_singular() ) {
        return (string) get_permalink();
    }

    if ( is_post_type_archive() ) {
        return (string) get_post_type_archive_link( (string) get_query_var( 'post_type' ) );
    }

    if ( is_category() || is_tag() || is_tax() ) {
        $term = get_queried_object();

        if ( $term instanceof \WP_Term ) {
            $link = get_term_link( $term );

            if ( ! is_wp_error( $link ) ) {
                return (string) $link;
            }
        }
    }

    return (string) home_url( '/' );
}

/**
 * Print the tags.
 */
function print_meta(): void {
    if ( delegated() || is_404() || is_search() ) {
        return;
    }

    $title       = wp_get_document_title();
    $description = description();
    $image       = image();
    $type        = is_singular() && ! is_front_page() ? 'article' : 'website';

    $tags = array(
        array( 'name', 'description', $description ),
        array( 'property', 'og:type', $type ),
        array( 'property', 'og:site_name', get_bloginfo( 'name', 'display' ) ),
        array( 'property', 'og:title', $title ),
        array( 'property', 'og:description', $description ),
        array( 'property', 'og:url', url() ),
        array( 'property', 'og:locale', str_replace( '-', '_', (string) get_bloginfo( 'language' ) ) ),
        array( 'name', 'twitter:card', $image ? 'summary_large_image' : 'summary' ),
        array( 'name', 'twitter:title', $title ),
        array( 'name', 'twitter:description', $description ),
    );

    if ( $image ) {
        $tags[] = array( 'property', 'og:image', $image['url'] );
        $tags[] = array( 'property', 'og:image:width', (string) $image['width'] );
        $tags[] = array( 'property', 'og:image:height', (string) $image['height'] );
        $tags[] = array( 'name', 'twitter:image', $image['url'] );

        if ( '' !== $image['alt'] ) {
            $tags[] = array( 'property', 'og:image:alt', $image['alt'] );
            $tags[] = array( 'name', 'twitter:image:alt', $image['alt'] );
        }
    }

    if ( 'article' === $type ) {
        $tags[] = array( 'property', 'article:published_time', (string) get_the_date( 'c' ) );
        $tags[] = array( 'property', 'article:modified_time', (string) get_the_modified_date( 'c' ) );
    }

    echo "\n";

    foreach ( $tags as $tag ) {
        list( $attr, $key, $value ) = $tag;

        if ( '' === trim( (string) $value ) ) {
            continue;
        }

        printf(
            "<meta %s=\"%s\" content=\"%s\" />\n",
            esc_attr( $attr ),
            esc_attr( $key ),
            esc_attr( (string) $value )
        );
    }

    printf( "<meta name=\"theme-color\" content=\"%s\" />\n", esc_attr( '#04141b' ) );
}
add_action( 'wp_head', __NAMESPACE__ . '\\print_meta', 2 );
