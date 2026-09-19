<?php
/**
 * Content model.
 *
 * Post types and taxonomies are built from config/brand.json. Adding a type for
 * another client is an edit to that file; there is no register_post_type() call
 * here to keep in sync.
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers the configured post types and taxonomies.
 */
final class PostTypes {

    /**
     * Hook registration.
     */
    public function register(): void {
        add_action( 'init', array( $this, 'register_taxonomies' ), 5 );
        add_action( 'init', array( $this, 'register_post_types' ), 6 );
    }

    /**
     * Register every configured taxonomy and its default terms.
     */
    public function register_taxonomies(): void {
        foreach ( Config::post_types() as $post_type => $config ) {
            foreach ( (array) ( $config['taxonomies'] ?? array() ) as $slug => $tax ) {
                register_taxonomy(
                    $slug,
                    array( $post_type ),
                    array(
                        'labels'       => self::labels( (string) $tax['singular'], (string) $tax['plural'] ),
                        'hierarchical' => (bool) ( $tax['hierarchical'] ?? true ),
                        'public'       => true,
                        'show_in_rest' => true,
                        'rewrite'      => array(
                            'slug'       => (string) ( $tax['slug'] ?? $slug ),
                            'with_front' => false,
                        ),
                    )
                );

                $this->ensure_terms( $slug, (array) ( $tax['terms'] ?? array() ) );
            }
        }
    }

    /**
     * Register every configured post type.
     */
    public function register_post_types(): void {
        foreach ( Config::post_types() as $slug => $config ) {
            register_post_type(
                $slug,
                array(
                    'labels'        => self::labels( (string) $config['singular'], (string) $config['plural'] ),
                    'description'   => (string) ( $config['description'] ?? '' ),
                    'public'        => true,
                    'has_archive'   => true,
                    'menu_icon'     => (string) ( $config['menuIcon'] ?? 'dashicons-portfolio' ),
                    'menu_position' => 20,
                    'supports'      => (array) ( $config['supports'] ?? array( 'title', 'editor', 'thumbnail' ) ),
                    'taxonomies'    => array_keys( (array) ( $config['taxonomies'] ?? array() ) ),
                    'rewrite'       => array(
                        'slug'       => (string) ( $config['slug'] ?? $slug ),
                        'with_front' => false,
                    ),
                    'show_in_rest'  => true,
                    'rest_base'     => (string) ( $config['restBase'] ?? $config['slug'] ?? $slug ),
                )
            );
        }
    }

    /**
     * Create any missing default terms. Idempotent, and only in contexts where
     * a write is expected, so a front-end request never inserts rows.
     *
     * @param string                $taxonomy Taxonomy slug.
     * @param array<string, string> $terms    Term slug => label.
     */
    private function ensure_terms( string $taxonomy, array $terms ): void {
        $writable = is_admin() || ( defined( 'WP_CLI' ) && WP_CLI );

        if ( ! $terms || ! $writable ) {
            return;
        }

        foreach ( $terms as $slug => $label ) {
            if ( ! term_exists( (string) $slug, $taxonomy ) ) {
                wp_insert_term( (string) $label, $taxonomy, array( 'slug' => (string) $slug ) );
            }
        }
    }

    /**
     * A standard labels array from a singular and a plural name.
     *
     * @param string $singular Singular label.
     * @param string $plural   Plural label.
     * @return array<string, string>
     */
    private static function labels( string $singular, string $plural ): array {
        return array(
            'name'          => $plural,
            'singular_name' => $singular,
            'menu_name'     => $plural,
            'all_items'     => $plural,
            'archives'      => $plural,
            /* translators: %s: singular label. */
            'add_new_item'  => sprintf( __( 'Add %s', 'zngiron-blocks' ), $singular ),
            /* translators: %s: singular label. */
            'edit_item'     => sprintf( __( 'Edit %s', 'zngiron-blocks' ), $singular ),
            /* translators: %s: singular label. */
            'new_item'      => sprintf( __( 'New %s', 'zngiron-blocks' ), $singular ),
            /* translators: %s: singular label. */
            'view_item'     => sprintf( __( 'View %s', 'zngiron-blocks' ), $singular ),
            /* translators: %s: plural label. */
            'search_items'  => sprintf( __( 'Search %s', 'zngiron-blocks' ), $plural ),
            /* translators: %s: plural label. */
            'not_found'     => sprintf( __( 'No %s found', 'zngiron-blocks' ), strtolower( $plural ) ),
        );
    }
}
