<?php
/**
 * Pattern categories.
 *
 * The pattern files themselves live in /patterns and are auto-registered by
 * WordPress from their file headers — there is no manual list to maintain.
 *
 * @package EmeraldPool\Theme
 */

declare( strict_types = 1 );

namespace EmeraldPool\Theme\Patterns;

defined( 'ABSPATH' ) || exit;

/**
 * Categories a new client keeps as-is; only the labels mention nothing brand-specific.
 *
 * @return array<string, string>
 */
function categories(): array {
	return array(
		'emerald-pool/hero'     => __( 'Heroes', 'emerald-pool' ),
		'emerald-pool/section'  => __( 'Page sections', 'emerald-pool' ),
		'emerald-pool/product'  => __( 'Products', 'emerald-pool' ),
		'emerald-pool/social'   => __( 'Proof & testimonials', 'emerald-pool' ),
		'emerald-pool/cta'      => __( 'Calls to action', 'emerald-pool' ),
		'emerald-pool/contact'  => __( 'Contact & locations', 'emerald-pool' ),
		'emerald-pool/editorial'=> __( 'Blog & editorial', 'emerald-pool' ),
	);
}

/**
 * Register the categories used by the pattern headers.
 */
function register_categories(): void {
	foreach ( categories() as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}
}
add_action( 'init', __NAMESPACE__ . '\\register_categories', 9 );

/**
 * Drop core's bundled patterns and the remote pattern directory: they use a
 * different design language and dilute the inserter.
 */
function remove_core_patterns(): void {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\remove_core_patterns', 20 );

add_filter( 'should_load_remote_block_patterns', '__return_false' );
