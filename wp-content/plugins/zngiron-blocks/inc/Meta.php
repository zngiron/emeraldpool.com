<?php
/**
 * Post meta.
 *
 * Every field is declared once in config/brand.json. This class registers them
 * for REST (so core block bindings can reach them) and formats them for
 * display. Specs Table, Compare Table and the Product schema all read the same
 * definitions, so a new field appears in all three at once.
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers and reads configured meta.
 */
final class Meta {

    /**
     * Hook registration.
     */
    public function register(): void {
        add_action( 'init', array( $this, 'register_meta' ), 7 );
    }

    /**
     * Register every configured field for REST and block bindings.
     */
    public function register_meta(): void {
        foreach ( Config::post_types() as $post_type => $config ) {
            foreach ( (array) ( $config['meta'] ?? array() ) as $field ) {
                $key  = (string) $field['key'];
                $type = (string) ( $field['type'] ?? 'string' );

                register_post_meta(
                    $post_type,
                    $key,
                    array(
                        'type'              => $type,
                        'description'       => (string) $field['label'],
                        'single'            => true,
                        'show_in_rest'      => true,
                        'default'           => 'string' === $type ? '' : 0,
                        'sanitize_callback' => self::sanitizer( $type, $key ),
                        'auth_callback'     => static fn(): bool => current_user_can( 'edit_posts' ),
                    )
                );
            }
        }
    }

    /**
     * Field definitions for a post type, keyed by meta key.
     *
     * @param string $post_type Post type slug.
     * @return array<string, array<string, mixed>>
     */
    public static function fields( string $post_type = '' ): array {
        $out = array();

        foreach ( Config::meta_fields( $post_type ) as $field ) {
            $out[ (string) $field['key'] ] = $field;
        }

        return $out;
    }

    /**
     * Fields flagged for one of the tables.
     *
     * @param string $flag      Either `specs` or `compare`.
     * @param string $post_type Post type slug.
     * @return array<string, array<string, mixed>>
     */
    public static function fields_for( string $flag, string $post_type = '' ): array {
        return array_filter(
            self::fields( $post_type ),
            static fn( array $field ): bool => ! empty( $field[ $flag ] )
        );
    }

    /**
     * One field, formatted for display.
     *
     * @param int    $post_id Post ID.
     * @param string $key     Meta key.
     * @return string Empty when the field has no usable value.
     */
    public static function display_value( int $post_id, string $key ): string {
        $field = self::fields( (string) get_post_type( $post_id ) )[ $key ] ?? null;

        if ( ! $field ) {
            return '';
        }

        $value = get_post_meta( $post_id, $key, true );
        $type  = (string) ( $field['type'] ?? 'string' );

        if ( '' === $value || null === $value ) {
            return '';
        }

        if ( 'string' !== $type && 0.0 === (float) $value ) {
            return '';
        }

        $unit = (string) ( $field['unit'] ?? '' );

        if ( 'USD' === $unit ) {
            return '$' . number_format_i18n( (float) $value );
        }

        $formatted = is_numeric( $value ) ? number_format_i18n( (float) $value ) : (string) $value;

        return $unit ? $formatted . ' ' . $unit : $formatted;
    }

    /**
     * Label => formatted value for every field carrying a flag.
     *
     * @param int    $post_id Post ID.
     * @param string $flag    Either `specs` or `compare`.
     * @return array<string, string>
     */
    public static function rows( int $post_id, string $flag = 'specs' ): array {
        $out = array();

        foreach ( self::fields_for( $flag, (string) get_post_type( $post_id ) ) as $key => $field ) {
            $value = self::display_value( $post_id, $key );

            if ( '' !== $value ) {
                $out[ (string) $field['label'] ] = $value;
            }
        }

        return $out;
    }

    /**
     * Pick a sanitiser for a field type.
     *
     * @param string $type Field type.
     * @param string $key  Meta key.
     * @return callable
     */
    private static function sanitizer( string $type, string $key ): callable {
        if ( str_ends_with( $key, '_url' ) ) {
            return 'esc_url_raw';
        }

        return match ( $type ) {
            'integer' => static fn( $value ): int => (int) $value,
            'number'  => static fn( $value ): float => (float) $value,
            default   => 'sanitize_text_field',
        };
    }
}
