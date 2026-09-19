<?php
/**
 * Store locations.
 *
 * Retail sites need the same two or three addresses in the footer, on the
 * contact page and inside a block. Holding them in one filterable array means a
 * change of opening hours is one edit, not six.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Supplies the location data used by the store-locator-card block and schema.
 */
final class Locations {

	/**
	 * Nothing to hook: this class is a data source.
	 */
	public function register(): void {}

	/**
	 * All configured locations, keyed by slug.
	 *
	 * @return array<string, array<string, string>>
	 */
	public static function all(): array {
		/**
		 * Filter the store locations.
		 *
		 * @param array<string, array<string, string>> $locations Locations keyed by slug.
		 */
		return (array) apply_filters(
			'emerald_pool_locations',
			array(
				'eugene' => array(
					'name'     => __( 'Eugene', 'emerald-pool-blocks' ),
					'legal'    => 'Emerald Pool & Patio',
					'street'   => '1885 Hwy 99 N',
					'city'     => 'Eugene',
					'region'   => 'OR',
					'postcode' => '97402',
					'phone'    => '(541) 688-1090',
					'hours'    => 'Mon–Sat 9:00am–6:00pm · Sun closed',
					'map'      => 'https://maps.app.goo.gl/kj2KmG3PrCtY6ni47',
					'note'     => __( 'Pools, hot tubs and patio, since 1955.', 'emerald-pool-blocks' ),
				),
				'bend'   => array(
					'name'     => __( 'Bend', 'emerald-pool-blocks' ),
					'legal'    => 'Emerald Hearth, Spa & Patio',
					'street'   => '62929 N. Hwy 97',
					'city'     => 'Bend',
					'region'   => 'OR',
					'postcode' => '97701',
					'phone'    => '(541) 383-3011',
					'hours'    => 'Mon–Fri 9:00am–6:00pm · Sat 9:00am–5:00pm · Sun closed',
					'map'      => 'https://maps.app.goo.gl/kk8S9oBD5GkKZmy6A',
					'note'     => __( 'Hearth, spa and patio for central Oregon.', 'emerald-pool-blocks' ),
				),
			)
		);
	}

	/**
	 * One location by slug.
	 *
	 * @param string $slug Location slug.
	 * @return array<string, string>
	 */
	public static function get( string $slug ): array {
		return self::all()[ $slug ] ?? array();
	}

	/**
	 * Slug => name, for the block's select control.
	 *
	 * @return array<string, string>
	 */
	public static function options(): array {
		return array_map( static fn( array $l ): string => $l['name'], self::all() );
	}

	/**
	 * Digits only, for a tel: href.
	 *
	 * @param string $phone Display phone number.
	 */
	public static function tel( string $phone ): string {
		return '+1' . preg_replace( '/\D+/', '', $phone );
	}
}
