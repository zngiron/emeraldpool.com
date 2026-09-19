<?php
/**
 * Structured data.
 *
 * Schema describes the data, and the data model is owned by this plugin, so the
 * markup travels with the plugin rather than the theme. Product comes from the
 * configured meta fields; LocalBusiness from the configured locations. FAQPage
 * is the exception and is emitted by the FAQ block, because it describes that
 * block's own content rather than the post.
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Emits JSON-LD in the document head.
 */
final class Schema {

    /**
     * Hook registration.
     */
    public function register(): void {
        add_action( 'wp_head', array( $this, 'print_product' ), 20 );
        add_action( 'wp_head', array( $this, 'print_local_business' ), 21 );
    }

    /**
     * Product for a single post of a configured type.
     */
    public function print_product(): void {
        $post_types = array_keys( Config::post_types() );

        if ( ! $post_types || ! is_singular( $post_types ) ) {
            return;
        }

        $post_id = get_queried_object_id();
        $product = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => get_the_title( $post_id ),
            'description' => wp_strip_all_tags( (string) get_the_excerpt( $post_id ) ),
            'url'         => (string) get_permalink( $post_id ),
            'brand'       => array(
                '@type' => 'Brand',
                'name'  => Config::brand_name(),
            ),
        );

        $image = get_the_post_thumbnail_url( $post_id, 'full' );

        if ( $image ) {
            $product['image'] = $image;
        }

        $properties = array();
        $price      = 0.0;

        foreach ( Meta::fields_for( 'specs', (string) get_post_type( $post_id ) ) as $key => $field ) {
            $value = Meta::display_value( $post_id, $key );

            if ( '' === $value ) {
                continue;
            }

            if ( 'USD' === ( $field['unit'] ?? '' ) ) {
                $price = (float) get_post_meta( $post_id, $key, true );

                continue;
            }

            $properties[] = array(
                '@type' => 'PropertyValue',
                'name'  => (string) $field['label'],
                'value' => $value,
            );
        }

        if ( $properties ) {
            $product['additionalProperty'] = $properties;
        }

        if ( $price > 0 ) {
            $product['offers'] = array(
                '@type'         => 'Offer',
                'priceCurrency' => 'USD',
                'price'         => $price,
                'availability'  => 'https://schema.org/InStock',
                'url'           => (string) get_permalink( $post_id ),
                'seller'        => array(
                    '@type' => 'Organization',
                    'name'  => Config::brand_name(),
                ),
            );
        }

        $this->print_json_ld( $product );
    }

    /**
     * One LocalBusiness node per configured location, on the front page.
     */
    public function print_local_business(): void {
        if ( ! is_front_page() ) {
            return;
        }

        foreach ( Config::locations() as $location ) {
            $this->print_json_ld(
                array(
                    '@context'  => 'https://schema.org',
                    '@type'     => 'LocalBusiness',
                    'name'      => trim( ( $location['legal'] ?? Config::brand_name() ) . ' — ' . ( $location['name'] ?? '' ), ' —' ),
                    'address'   => array(
                        '@type'           => 'PostalAddress',
                        'streetAddress'   => (string) ( $location['street'] ?? '' ),
                        'addressLocality' => (string) ( $location['city'] ?? '' ),
                        'addressRegion'   => (string) ( $location['region'] ?? '' ),
                        'postalCode'      => (string) ( $location['postcode'] ?? '' ),
                        'addressCountry'  => (string) ( $location['country'] ?? 'US' ),
                    ),
                    'telephone' => Render::tel( (string) ( $location['phone'] ?? '' ) ),
                    'url'       => home_url( '/' ),
                    'hasMap'    => (string) ( $location['map'] ?? '' ),
                )
            );
        }
    }

    /**
     * Print one JSON-LD script tag.
     *
     * @param array<string, mixed> $data Schema.org node.
     */
    private function print_json_ld( array $data ): void {
        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON-encoded.
        );
    }
}
