<?php
/**
 * Spa specification meta.
 *
 * One config array describes every field: its type, its editor label and how it
 * is formatted for display. The registration loop, the spa-specs block, the
 * comparison table and the Product schema all read that same array, so a new
 * spec field appears everywhere at once.
 *
 * Keys deliberately carry no underscore prefix: unprotected meta with
 * show_in_rest is what makes them available to core block bindings
 * (`core/post-meta`) in the editor.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers and reads spa meta.
 */
final class Meta {

	/**
	 * Post type the spec fields belong to.
	 */
	public const POST_TYPE = 'spa';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'init', array( $this, 'register_meta' ), 7 );
	}

	/**
	 * Field definitions.
	 *
	 * `group` drives the sections of the spec list.
	 * `suffix` is appended on display only; the stored value stays numeric.
	 *
	 * @return array<string, array{label:string, type:string, group:string, suffix?:string, primary?:bool}>
	 */
	public static function fields(): array {
		/**
		 * Filter the spec field definitions.
		 *
		 * @param array<string, array<string, mixed>> $fields Field definitions keyed by meta key.
		 */
		return (array) apply_filters(
			'emerald_pool_spa_fields',
			array(
				'spa_seats'             => array(
					'label'   => __( 'Seats', 'emerald-pool-blocks' ),
					'type'    => 'integer',
					'group'   => 'capacity',
					'primary' => true,
				),
				'spa_lounge_seats'      => array(
					'label' => __( 'Lounge seats', 'emerald-pool-blocks' ),
					'type'  => 'integer',
					'group' => 'capacity',
				),
				'spa_jets'              => array(
					'label'   => __( 'Jets', 'emerald-pool-blocks' ),
					'type'    => 'integer',
					'group'   => 'hydrotherapy',
					'primary' => true,
				),
				'spa_pumps'             => array(
					'label'   => __( 'Therapy pumps', 'emerald-pool-blocks' ),
					'type'    => 'integer',
					'group'   => 'hydrotherapy',
					'primary' => true,
				),
				'spa_capacity_gallons'  => array(
					'label'   => __( 'Water capacity', 'emerald-pool-blocks' ),
					'type'    => 'integer',
					'group'   => 'capacity',
					'suffix'  => __( 'gallons', 'emerald-pool-blocks' ),
					'primary' => true,
				),
				'spa_dimensions'        => array(
					'label' => __( 'Dimensions (W × L × H)', 'emerald-pool-blocks' ),
					'type'  => 'string',
					'group' => 'dimensions',
				),
				'spa_dimensions_metric' => array(
					'label' => __( 'Dimensions, metric', 'emerald-pool-blocks' ),
					'type'  => 'string',
					'group' => 'dimensions',
				),
				'spa_dry_weight'        => array(
					'label'  => __( 'Dry weight', 'emerald-pool-blocks' ),
					'type'   => 'integer',
					'group'  => 'dimensions',
					'suffix' => __( 'lbs', 'emerald-pool-blocks' ),
				),
				'spa_price_from'        => array(
					'label' => __( 'Price from', 'emerald-pool-blocks' ),
					'type'  => 'number',
					'group' => 'commercial',
				),
				'spa_brochure_url'      => array(
					'label' => __( 'Brochure URL', 'emerald-pool-blocks' ),
					'type'  => 'string',
					'group' => 'commercial',
				),
			)
		);
	}

	/**
	 * Human labels for the spec groups, in display order.
	 *
	 * @return array<string, string>
	 */
	public static function groups(): array {
		return array(
			'capacity'     => __( 'Capacity', 'emerald-pool-blocks' ),
			'hydrotherapy' => __( 'Hydrotherapy', 'emerald-pool-blocks' ),
			'dimensions'   => __( 'Size & weight', 'emerald-pool-blocks' ),
			'commercial'   => __( 'Buying', 'emerald-pool-blocks' ),
		);
	}

	/**
	 * Register every field for REST and block bindings.
	 */
	public function register_meta(): void {
		foreach ( self::fields() as $key => $field ) {
			register_post_meta(
				self::POST_TYPE,
				$key,
				array(
					'type'              => $field['type'],
					'description'       => $field['label'],
					'single'            => true,
					'show_in_rest'      => true,
					'default'           => 'string' === $field['type'] ? '' : 0,
					'sanitize_callback' => self::sanitizer( $field['type'], $key ),
					'auth_callback'     => static fn(): bool => current_user_can( 'edit_posts' ),
				)
			);
		}
	}

	/**
	 * Pick a sanitizer for a field type.
	 *
	 * @param string $type Field type.
	 * @param string $key  Meta key.
	 * @return callable
	 */
	private static function sanitizer( string $type, string $key ): callable {
		if ( str_ends_with( $key, '_url' ) ) {
			return 'esc_url_raw';
		}

		return match ( $type ) {
			'integer' => static fn( $value ): int => (int) $value,
			'number'  => static fn( $value ): float => (float) $value,
			default   => 'sanitize_text_field',
		};
	}

	/**
	 * Read one field, formatted for display.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $key     Meta key.
	 * @return string Empty string when the field has no value.
	 */
	public static function display_value( int $post_id, string $key ): string {
		$fields = self::fields();

		if ( ! isset( $fields[ $key ] ) ) {
			return '';
		}

		$value = get_post_meta( $post_id, $key, true );

		if ( '' === $value || null === $value || 0 === (int) $value && 'string' !== $fields[ $key ]['type'] ) {
			return '';
		}

		if ( 'spa_price_from' === $key ) {
			return sprintf( '$%s', number_format_i18n( (float) $value ) );
		}

		$formatted = is_numeric( $value ) ? number_format_i18n( (float) $value ) : (string) $value;
		$suffix    = $fields[ $key ]['suffix'] ?? '';

		return $suffix ? $formatted . ' ' . $suffix : $formatted;
	}

	/**
	 * The two or three numbers that belong on a card or chip row.
	 *
	 * @param int $post_id Post ID.
	 * @return array<string, string> Label => formatted value.
	 */
	public static function primary_specs( int $post_id ): array {
		$out = array();

		foreach ( self::fields() as $key => $field ) {
			if ( empty( $field['primary'] ) ) {
				continue;
			}

			$value = self::display_value( $post_id, $key );

			if ( '' !== $value ) {
				$out[ $field['label'] ] = $value;
			}
		}

		return $out;
	}

	/**
	 * Every field with a value, keyed by group.
	 *
	 * @param int $post_id Post ID.
	 * @return array<string, array<string, string>>
	 */
	public static function grouped_specs( int $post_id ): array {
		$out = array();

		foreach ( self::fields() as $key => $field ) {
			if ( 'spa_brochure_url' === $key ) {
				continue; // A link, not a spec row.
			}

			$value = self::display_value( $post_id, $key );

			if ( '' === $value ) {
				continue;
			}

			$out[ $field['group'] ][ $field['label'] ] = $value;
		}

		return $out;
	}
}
