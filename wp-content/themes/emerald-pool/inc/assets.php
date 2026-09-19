<?php
/**
 * Stylesheet loading.
 *
 * Rules of the house:
 *  - theme.json expresses everything it can express; CSS only covers what it cannot.
 *  - Per-block CSS goes through wp_enqueue_block_style(), so a page that has no
 *    Navigation block downloads no navigation CSS.
 *  - No JavaScript is enqueued by the theme at all. Interactivity lives in blocks.
 *
 * @package EmeraldPool\Theme
 */

declare( strict_types = 1 );

namespace EmeraldPool\Theme\Assets;

use const EmeraldPool\Theme\VERSION;

defined( 'ABSPATH' ) || exit;

/**
 * Core blocks that have a matching file in assets/css/blocks/.
 *
 * Add a file, add a line here. Nothing else.
 *
 * @return string[]
 */
function block_stylesheets(): array {
	return array(
		'core/navigation',
		'core/details',
		'core/group',
		'core/image',
		'core/table',
		'core/post-template',
		'core/search',
	);
}

/**
 * Front-end global stylesheet (small on purpose).
 */
function enqueue_front_end(): void {
	wp_enqueue_style(
		'emerald-pool',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		VERSION
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_front_end' );

/**
 * Attach per-block stylesheets. Loaded on demand by WordPress.
 */
function enqueue_block_stylesheets(): void {
	foreach ( block_stylesheets() as $block ) {
		$handle = 'emerald-pool-' . str_replace( '/', '-', $block );
		$file   = 'assets/css/blocks/' . substr( $block, strpos( $block, '/' ) + 1 ) . '.css';

		wp_enqueue_block_style(
			$block,
			array(
				'handle' => $handle,
				'src'    => get_theme_file_uri( $file ),
				'path'   => get_theme_file_path( $file ),
				'ver'    => VERSION,
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\\enqueue_block_stylesheets' );

/**
 * Editor gets the same rules so the canvas matches the front end.
 */
function editor_styles(): void {
	add_editor_style( 'assets/css/theme.css' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\editor_styles' );

/**
 * Preload the two self-hosted variable fonts. They are the only blocking assets
 * on the critical path, and both are subset to latin.
 */
function preload_fonts(): void {
	foreach ( array( 'fraunces-latin-var.woff2', 'karla-latin-var.woff2' ) as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( 'assets/fonts/' . $font ) )
		);
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\\preload_fonts', 1 );
