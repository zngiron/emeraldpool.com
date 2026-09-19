<?php
/**
 * Block registration.
 *
 * One loop over the build manifest registers every block, so adding a block is
 * adding a folder under src/blocks and rebuilding. Also owns the inserter
 * category and the one stylesheet more than one block shares: the Frame.
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers the compiled blocks.
 */
final class Blocks {

    /**
     * Inserter category used by every block.json in this plugin.
     */
    public const CATEGORY = 'zngiron';

    /**
     * Handle for the shared Frame stylesheet, listed in each block.json `style`.
     */
    public const FRAME_STYLE = 'zngiron-frame';

    /**
     * Hook registration.
     */
    public function register(): void {
        add_filter( 'block_categories_all', array( $this, 'add_category' ) );
        add_action( 'init', array( $this, 'register_frame_style' ), 5 );
        add_action( 'init', array( $this, 'register_blocks' ), 10 );
    }

    /**
     * Put the plugin's category at the top of the inserter.
     *
     * @param array<int, array<string, mixed>> $categories Registered categories.
     * @return array<int, array<string, mixed>>
     */
    public function add_category( array $categories ): array {
        array_unshift(
            $categories,
            array(
                'slug'  => self::CATEGORY,
                'title' => Config::brand_name(),
                'icon'  => 'layout',
            )
        );

        return $categories;
    }

    /**
     * Register the compiled Frame stylesheet.
     *
     * Blocks opt in by naming the handle in block.json, which keeps WordPress's
     * on-demand loading: a page without a Frame never downloads it.
     */
    public function register_frame_style(): void {
        $path = DIR . '/build/style-index.css';

        if ( ! is_readable( $path ) ) {
            return;
        }

        wp_register_style(
            self::FRAME_STYLE,
            plugins_url( 'build/style-index.css', FILE ),
            array(),
            (string) filemtime( $path )
        );
    }

    /**
     * Register every compiled block from its metadata.
     */
    public function register_blocks(): void {
        $manifest = DIR . '/build/blocks-manifest.php';

        if ( is_readable( $manifest ) && function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
            wp_register_block_types_from_metadata_collection( DIR . '/build/blocks', $manifest );

            return;
        }

        foreach ( (array) glob( DIR . '/build/blocks/*/block.json' ) as $block_json ) {
            register_block_type( dirname( (string) $block_json ) );
        }
    }
}
