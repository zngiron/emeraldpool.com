<?php
/**
 * Structured data.
 *
 * WHY THIS LIVES IN THE PLUGIN, NOT THE THEME: schema describes the data, and
 * the data model (post type, taxonomies, spec meta) is owned by this plugin. If
 * the client later changes theme, the Product and LocalBusiness markup must
 * survive; if the client drops this plugin, the markup must go with it.
 *
 * FAQPage schema is the one exception and is emitted by the faq-accordion block
 * itself, because it describes that block's own inner content rather than the
 * post.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

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
	 * Product + Offer for a single spa.
	 */
	public function print_product(): void {
		if ( ! is_singular( Meta::POST_TYPE ) ) {
			return;
		}

		$post_id = get_queried_object_id();
		$price   = (float) get_post_meta( $post_id, 'spa_price_from', true );

		$product = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Product',
			'name'        => get_the_title( $post_id ),
			'description' => wp_strip_all_tags( (string) get_the_excerpt( $post_id ) ),
			'url'         => (string) get_permalink( $post_id ),
			'category'    => $this->term_names( $post_id, 'spa_type' ),
			'brand'       => array(
				'@type' => 'Brand',
				'name'  => $this->term_names( $post_id, 'spa_series' ) ?: 'Bullfrog Spas',
			),
		);

		$image = get_the_post_thumbnail_url( $post_id, 'full' );

		if ( $image ) {
			$product['image'] = $image;
		}

		$properties = array();

		foreach ( Meta::grouped_specs( $post_id ) as $rows ) {
			foreach ( $rows as $label => $value ) {
				$properties[] = array(
					'@type' => 'PropertyValue',
					'name'  => $label,
					'value' => $value,
				);
			}
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
					'name'  => get_bloginfo( 'name' ),
				),
			);
		}

		$this->print_json_ld( $product );
	}

	/**
	 * One LocalBusiness node per store, on the front page only.
	 */
	public function print_local_business(): void {
		if ( ! is_front_page() ) {
			return;
		}

		foreach ( Locations::all() as $location ) {
			$this->print_json_ld(
				array(
					'@context' => 'https://schema.org',
					'@type'    => 'HomeAndConstructionBusiness',
					'name'     => $location['legal'] . ' — ' . $location['name'],
					'address'  => array(
						'@type'           => 'PostalAddress',
						'streetAddress'   => $location['street'],
						'addressLocality' => $location['city'],
						'addressRegion'   => $location['region'],
						'postalCode'      => $location['postcode'],
						'addressCountry'  => 'US',
					),
					'telephone' => Locations::tel( $location['phone'] ),
					'url'       => home_url( '/' ),
					'hasMap'    => $location['map'],
				)
			);
		}
	}

	/**
	 * Comma-joined term names for a taxonomy.
	 *
	 * @param int    $post_id  Post ID.
	 * @param string $taxonomy Taxonomy slug.
	 */
	private function term_names( int $post_id, string $taxonomy ): string {
		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! $terms || is_wp_error( $terms ) ) {
			return '';
		}

		return implode( ', ', wp_list_pluck( $terms, 'name' ) );
	}

	/**
	 * Print one JSON-LD script tag.
	 *
	 * @param array<string, mixed> $data Structured data.
	 */
	private function print_json_ld( array $data ): void {
		echo '<script type="application/ld+json">'
			. wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			. '</script>' . "\n";
	}
}
