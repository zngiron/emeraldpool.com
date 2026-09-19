<?php
/**
 * The icon set — the single source of truth.
 *
 * Eight line drawings on a 24 unit grid at one stroke weight, so a feature row
 * always looks like one family. The editor picker reads the same data through
 * the `emerald-pool-icons` script registered in Assets, which is why there is no
 * second copy of these paths in JavaScript.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Supplies and renders icons.
 */
final class Icons {

	/**
	 * Data source, not a hooked subsystem.
	 */
	public function register(): void {}

	/**
	 * All icons, keyed by name.
	 *
	 * @return array<string, array{label:string, path:string}>
	 */
	public static function all(): array {
		/**
		 * Filter the icon set.
		 *
		 * @param array<string, array{label:string, path:string}> $icons Icons keyed by name.
		 */
		return (array) apply_filters(
			'emerald_pool_icons',
			array(
				'droplet'     => array(
					'label' => __( 'Water care', 'emerald-pool-blocks' ),
					'path'  => 'M12 3.2c3.2 3.6 5.4 6.4 5.4 9.1a5.4 5.4 0 1 1-10.8 0c0-2.7 2.2-5.5 5.4-9.1Z',
				),
				'waves'       => array(
					'label' => __( 'Swim current', 'emerald-pool-blocks' ),
					'path'  => 'M2.5 9.5c2-1.6 3.4-1.6 5.3 0s3.4 1.6 5.4 0 3.4-1.6 5.3 0M2.5 15c2-1.6 3.4-1.6 5.3 0s3.4 1.6 5.4 0 3.4-1.6 5.3 0',
				),
				'seat'        => array(
					'label' => __( 'Seating', 'emerald-pool-blocks' ),
					'path'  => 'M4 11V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4M3 11h18v4a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-4ZM7 18v2M17 18v2',
				),
				'thermometer' => array(
					'label' => __( 'Year round', 'emerald-pool-blocks' ),
					'path'  => 'M10 14.8V5a2 2 0 1 1 4 0v9.8a4 4 0 1 1-4 0ZM12 12v4',
				),
				'leaf'        => array(
					'label' => __( 'Energy', 'emerald-pool-blocks' ),
					'path'  => 'M5 19c0-7 4.5-11 14-11 0 8-4 12-10 12a4 4 0 0 1-4-1Zm0 0 6.5-6.5',
				),
				'wrench'      => array(
					'label' => __( 'Service', 'emerald-pool-blocks' ),
					'path'  => 'M15.2 4.4a5 5 0 0 0-6.1 6.3L4 15.8 6.2 18l5.1-5.1a5 5 0 0 0 6.3-6.1l-2.7 2.7-2.3-.6-.6-2.3 2.7-2.7Z',
				),
				'truck'       => array(
					'label' => __( 'Delivery', 'emerald-pool-blocks' ),
					'path'  => 'M2.5 6.5h10v9h-10v-9Zm10 3.5h4l3 3v2.5h-7V10ZM7 15.5a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z',
				),
				'shield'      => array(
					'label' => __( 'Warranty', 'emerald-pool-blocks' ),
					'path'  => 'M12 3.5 19 6v5.3c0 4.2-2.8 7.3-7 9.2-4.2-1.9-7-5-7-9.2V6l7-2.5ZM9 12l2 2 4-4',
				),
			)
		);
	}

	/**
	 * One icon as inline SVG, decorative by default.
	 *
	 * @param string $name Icon name.
	 */
	public static function svg( string $name ): string {
		$icons = self::all();

		if ( ! isset( $icons[ $name ] ) ) {
			return '';
		}

		return sprintf(
			'<svg class="ep-feature__icon" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="%s"/></svg>',
			esc_attr( $icons[ $name ]['path'] )
		);
	}
}
