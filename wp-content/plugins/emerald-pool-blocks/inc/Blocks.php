<?php
/**
 * Block registration.
 *
 * Every block in build/blocks/ is registered by one loop over its block.json.
 * Adding a block means adding a folder under src/blocks and rebuilding — there
 * is no list in PHP to keep in step.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers the compiled blocks.
 */
final class Blocks {

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'init', array( $this, 'register_blocks' ), 10 );
	}

	/**
	 * Register every compiled block from its metadata.
	 */
	public function register_blocks(): void {
		$manifest = DIR . '/build/blocks-manifest.php';

		// WordPress 6.8+ can register a whole folder from one generated manifest.
		if ( is_readable( $manifest ) && function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
			wp_register_block_types_from_metadata_collection( DIR . '/build/blocks', $manifest );

			return;
		}

		foreach ( (array) glob( DIR . '/build/blocks/*/block.json' ) as $block_json ) {
			register_block_type( dirname( (string) $block_json ) );
		}
	}
}
