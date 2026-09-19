<?php
/**
 * Editor-only block variations.
 *
 * Variations are a JS-side API, so this file does nothing but enqueue the script.
 * Keeping it separate means the variation list is one small readable JS file.
 *
 * @package EmeraldPool\Theme
 */

declare( strict_types = 1 );

namespace EmeraldPool\Theme\BlockVariations;

use const EmeraldPool\Theme\VERSION;

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the variation registrations in the editor only.
 */
function enqueue(): void {
	wp_enqueue_script(
		'emerald-pool-block-variations',
		get_theme_file_uri( 'assets/js/block-variations.js' ),
		array( 'wp-blocks', 'wp-dom-ready', 'wp-i18n' ),
		VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue' );
