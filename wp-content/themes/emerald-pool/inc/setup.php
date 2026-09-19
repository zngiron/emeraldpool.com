<?php
/**
 * Theme supports and the single brand configuration array.
 *
 * REBRANDING: this file plus theme.json is where a new client's identity lives.
 * Nothing else in the theme hard-codes a name, phone number or URL.
 *
 * @package EmeraldPool\Theme
 */

declare( strict_types = 1 );

namespace EmeraldPool\Theme\Setup;

defined( 'ABSPATH' ) || exit;

/**
 * Brand-level values that are not design tokens (those live in theme.json).
 *
 * @return array<string, mixed>
 */
function brand_config(): array {
	/**
	 * Filter the brand configuration.
	 *
	 * @param array<string, mixed> $config Brand configuration.
	 */
	return (array) apply_filters(
		'emerald_pool_brand_config',
		array(
			'name'          => 'Emerald Pool & Patio',
			'short_name'    => 'Emerald Pool',
			'founded'       => 1955,
			'tagline'       => 'Backyard water, done properly. Eugene & Bend, Oregon.',
			'primary_phone' => '(541) 688-1090',
			'logo'          => 'images/logo.png',
			'favicon'       => 'images/favicon.ico',
		)
	);
}

/**
 * Read one brand value.
 *
 * @param string $key     Config key.
 * @param mixed  $default Fallback.
 * @return mixed
 */
function brand( string $key, $default = '' ) {
	$config = brand_config();

	return $config[ $key ] ?? $default;
}

/**
 * Register theme supports. Block themes get most of this for free; the rest is
 * explicit so the list is readable.
 */
function after_setup_theme(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-logo', array( 'height' => 70, 'width' => 260, 'flex-width' => true ) );
	add_theme_support( 'automatic-feed-links' );

	add_image_size( 'emerald-card', 720, 540, true );

	load_theme_textdomain( 'emerald-pool', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\after_setup_theme' );

/**
 * Trim head output the design does not use.
 */
function tidy_head(): void {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
add_action( 'init', __NAMESPACE__ . '\\tidy_head' );

/**
 * Emit the favicon when the site has no custom site icon set.
 */
function fallback_site_icon(): void {
	if ( has_site_icon() ) {
		return;
	}

	printf(
		'<link rel="icon" href="%s" sizes="any">' . "\n",
		esc_url( get_theme_file_uri( 'assets/' . brand( 'favicon' ) ) )
	);
}
add_action( 'wp_head', __NAMESPACE__ . '\\fallback_site_icon' );
