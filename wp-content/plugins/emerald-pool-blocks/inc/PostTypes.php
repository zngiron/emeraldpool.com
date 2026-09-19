<?php
/**
 * Custom post types and taxonomies, registered from a configuration array.
 *
 * To add a content type for another client you add one entry to post_types() or
 * taxonomies(). There is no second place to edit and no copy-pasted
 * register_post_type() call to keep in sync.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers the spa catalogue content model.
 */
final class PostTypes {

	/**
	 * Hook registration.
	 */
	public function register(): void {
		// Taxonomies first so the post type inherits them cleanly in REST.
		add_action( 'init', array( $this, 'register_taxonomies' ), 5 );
		add_action( 'init', array( $this, 'register_post_types' ), 6 );
	}

	/**
	 * Post type configuration.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function post_types(): array {
		/**
		 * Filter the post type configuration.
		 *
		 * @param array<string, array<string, mixed>> $config Post type arguments keyed by slug.
		 */
		return (array) apply_filters(
			'emerald_pool_post_types',
			array(
				'spa' => array(
					'labels'        => self::labels( __( 'Spa', 'emerald-pool-blocks' ), __( 'Spas', 'emerald-pool-blocks' ) ),
					'description'   => __( 'Hot tubs and swim spas in the catalogue.', 'emerald-pool-blocks' ),
					'public'        => true,
					'has_archive'   => true,
					'menu_icon'     => 'dashicons-buddicons-activity',
					'menu_position' => 20,
					'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
					'taxonomies'    => array( 'spa_type', 'spa_series', 'spa_feature' ),
					'rewrite'       => array( 'slug' => 'spas', 'with_front' => false ),
					'show_in_rest'  => true,
					'rest_base'     => 'spas',
					// A starting structure for editors. Not locked: they can restructure.
					'template'      => array(
						array( 'core/paragraph', array( 'placeholder' => 'Two short paragraphs on who this model suits.' ) ),
						array( 'emerald-pool/spa-specs', array() ),
						array( 'emerald-pool/faq-accordion', array() ),
					),
					'template_lock' => false,
				),
			)
		);
	}

	/**
	 * Taxonomy configuration.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function taxonomies(): array {
		/**
		 * Filter the taxonomy configuration.
		 *
		 * @param array<string, array<string, mixed>> $config Taxonomy arguments keyed by slug.
		 */
		return (array) apply_filters(
			'emerald_pool_taxonomies',
			array(
				'spa_type'    => array(
					'object_type'  => array( 'spa' ),
					'labels'       => self::labels( __( 'Spa type', 'emerald-pool-blocks' ), __( 'Spa types', 'emerald-pool-blocks' ) ),
					'hierarchical' => true,
					'public'       => true,
					'show_in_rest' => true,
					'rewrite'      => array( 'slug' => 'spa-type', 'with_front' => false ),
					// Seeded on first registration so the site is usable immediately.
					'default_terms' => array(
						'hot-tubs'  => __( 'Hot Tubs', 'emerald-pool-blocks' ),
						'swim-spas' => __( 'Swim Spas', 'emerald-pool-blocks' ),
					),
				),
				'spa_series'  => array(
					'object_type'  => array( 'spa' ),
					'labels'       => self::labels( __( 'Series', 'emerald-pool-blocks' ), __( 'Series', 'emerald-pool-blocks' ) ),
					'hierarchical' => true,
					'public'       => true,
					'show_in_rest' => true,
					'rewrite'      => array( 'slug' => 'series', 'with_front' => false ),
					'default_terms' => array(
						'a-series'    => __( 'A Series — Luxury', 'emerald-pool-blocks' ),
						'm-series'    => __( 'M Series — Elite', 'emerald-pool-blocks' ),
						'x-series'    => __( 'X Series — Comfort', 'emerald-pool-blocks' ),
						'stil'        => __( 'STIL — Modern', 'emerald-pool-blocks' ),
						'calm'        => __( 'Calm — Value', 'emerald-pool-blocks' ),
						'swim-series' => __( 'Swim Series — Performance', 'emerald-pool-blocks' ),
					),
				),
				'spa_feature' => array(
					'object_type'  => array( 'spa' ),
					'labels'       => self::labels( __( 'Feature', 'emerald-pool-blocks' ), __( 'Features', 'emerald-pool-blocks' ) ),
					'hierarchical' => false,
					'public'       => true,
					'show_in_rest' => true,
					'rewrite'      => array( 'slug' => 'spa-feature', 'with_front' => false ),
				),
			)
		);
	}

	/**
	 * Register configured post types.
	 */
	public function register_post_types(): void {
		foreach ( self::post_types() as $slug => $args ) {
			register_post_type( $slug, $args );
		}
	}

	/**
	 * Register configured taxonomies and insert their default terms once.
	 */
	public function register_taxonomies(): void {
		foreach ( self::taxonomies() as $slug => $args ) {
			$object_type = $args['object_type'];
			$defaults    = $args['default_terms'] ?? array();

			unset( $args['object_type'], $args['default_terms'] );

			register_taxonomy( $slug, $object_type, $args );

			$this->ensure_terms( $slug, $defaults );
		}
	}

	/**
	 * Create any missing default terms. Idempotent, so it is safe on every load.
	 *
	 * @param string                $taxonomy Taxonomy slug.
	 * @param array<string, string> $terms    Term slug => label.
	 */
	private function ensure_terms( string $taxonomy, array $terms ): void {
		if ( ! $terms || ! is_admin() && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
			return;
		}

		foreach ( $terms as $slug => $label ) {
			if ( ! term_exists( $slug, $taxonomy ) ) {
				wp_insert_term( $label, $taxonomy, array( 'slug' => $slug ) );
			}
		}
	}

	/**
	 * Build a standard labels array from a singular and plural name.
	 *
	 * @param string $singular Singular label.
	 * @param string $plural   Plural label.
	 * @return array<string, string>
	 */
	private static function labels( string $singular, string $plural ): array {
		return array(
			'name'               => $plural,
			'singular_name'      => $singular,
			'menu_name'          => $plural,
			'add_new_item'       => sprintf( /* translators: %s: singular label. */ __( 'Add %s', 'emerald-pool-blocks' ), $singular ),
			'edit_item'          => sprintf( /* translators: %s: singular label. */ __( 'Edit %s', 'emerald-pool-blocks' ), $singular ),
			'new_item'           => sprintf( /* translators: %s: singular label. */ __( 'New %s', 'emerald-pool-blocks' ), $singular ),
			'view_item'          => sprintf( /* translators: %s: singular label. */ __( 'View %s', 'emerald-pool-blocks' ), $singular ),
			'search_items'       => sprintf( /* translators: %s: plural label. */ __( 'Search %s', 'emerald-pool-blocks' ), $plural ),
			'not_found'          => sprintf( /* translators: %s: plural label. */ __( 'No %s found', 'emerald-pool-blocks' ), strtolower( $plural ) ),
			'all_items'          => $plural,
			'archives'           => $plural,
		);
	}
}
