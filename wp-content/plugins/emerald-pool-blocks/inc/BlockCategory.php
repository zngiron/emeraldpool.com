<?php
/**
 * The inserter category these blocks live in.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Adds one category to the top of the block inserter.
 */
final class BlockCategory {

	/**
	 * Category slug used by every block.json in this plugin.
	 */
	public const SLUG = 'emerald-pool';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_filter( 'block_categories_all', array( $this, 'add_category' ), 10, 1 );
	}

	/**
	 * Prepend the category.
	 *
	 * @param array<int, array<string, mixed>> $categories Registered categories.
	 * @return array<int, array<string, mixed>>
	 */
	public function add_category( array $categories ): array {
		array_unshift(
			$categories,
			array(
				'slug'  => self::SLUG,
				'title' => __( 'Emerald Pool', 'emerald-pool-blocks' ),
				'icon'  => null,
			)
		);

		return $categories;
	}
}
