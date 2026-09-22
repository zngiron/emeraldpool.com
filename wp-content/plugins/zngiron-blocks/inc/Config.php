<?php
/**
 * Brand configuration.
 *
 * Everything client-specific — post types, taxonomies, meta fields and store
 * locations — lives in config/brand.json at the repository root. It is read
 * once per request, cached in a static, and filterable so a child plugin or a
 * test can substitute values without touching the file.
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Reads and caches config/brand.json.
 */
final class Config {

    /**
     * Parsed configuration, or null before the first read.
     *
     * @var array<string, mixed>|null
     */
    private static ?array $config = null;

    /**
     * The whole configuration array.
     *
     * @return array<string, mixed>
     */
    public static function all(): array {
        if ( null === self::$config ) {
            $path = self::path();
            $raw  = $path ? (string) file_get_contents( $path ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file, not a remote request.
            $data = $raw ? json_decode( $raw, true ) : null;

            /**
             * Filter the whole brand configuration.
             *
             * @param array<string, mixed> $config Parsed brand.json.
             */
            self::$config = (array) apply_filters( 'zngiron_brand_config', is_array( $data ) ? $data : array() );
        }

        return self::$config;
    }

    /**
     * One top-level section.
     *
     * @param string $key     Section name.
     * @param mixed  $default Returned when the section is missing.
     * @return mixed
     */
    public static function get( string $key, mixed $default = array() ): mixed {
        return self::all()[ $key ] ?? $default;
    }

    /**
     * Brand name, falling back to the site title.
     */
    public static function brand_name(): string {
        $brand = (array) self::get( 'brand' );

        return (string) ( $brand['name'] ?? get_bloginfo( 'name' ) );
    }

    /**
     * Configured post types, keyed by slug.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function post_types(): array {
        return (array) self::get( 'postTypes' );
    }

    /**
     * The primary post type slug — the first one declared.
     */
    public static function primary_post_type(): string {
        return (string) ( array_key_first( self::post_types() ) ?? 'post' );
    }

    /**
     * Meta field definitions for a post type.
     *
     * @param string $post_type Post type slug. Defaults to the primary one.
     * @return array<int, array<string, mixed>>
     */
    public static function meta_fields( string $post_type = '' ): array {
        $post_type = $post_type ?: self::primary_post_type();

        return (array) ( self::post_types()[ $post_type ]['meta'] ?? array() );
    }

    /**
     * Store locations.
     *
     * @return array<int, array<string, string>>
     */
    public static function locations(): array {
        return (array) self::get( 'locations' );
    }

    /**
     * First readable brand.json.
     *
     * The repository root is mounted at ABSPATH in the local container; the
     * plugin-local copy is the fallback for a deployment that ships the plugin
     * on its own.
     */
    private static function path(): string {
        $candidates = array(
            /**
             * Filter the path to brand.json before the default locations are tried.
             *
             * @param string $path Absolute path, or an empty string.
             */
            (string) apply_filters( 'zngiron_brand_config_path', '' ),
            ABSPATH . 'config/brand.json',
            dirname( WP_CONTENT_DIR ) . '/config/brand.json',
            DIR . '/config/brand.json',
        );

        foreach ( $candidates as $path ) {
            if ( $path && is_readable( $path ) ) {
                return $path;
            }
        }

        return '';
    }
}
