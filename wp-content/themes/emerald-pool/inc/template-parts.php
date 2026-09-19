<?php
/**
 * Template part areas.
 *
 * WordPress ships header / footer / uncategorized. We add a "band" area so the
 * reusable closing CTA is grouped sensibly in the Site Editor instead of sitting
 * in the generic bucket.
 *
 * @package EmeraldPool\Theme
 */

declare( strict_types = 1 );

namespace EmeraldPool\Theme\TemplateParts;

defined( 'ABSPATH' ) || exit;

/**
 * Register the extra area.
 *
 * @param array<int, array<string, mixed>> $areas Registered areas.
 * @return array<int, array<string, mixed>>
 */
function register_area( array $areas ): array {
	$areas[] = array(
		'area'        => 'band',
		'label'       => __( 'Bands', 'emerald-pool' ),
		'description' => __( 'Reusable full-width bands, such as the closing quote CTA.', 'emerald-pool' ),
		'icon'        => 'layout',
		'area_tag'    => 'section',
	);

	return $areas;
}
add_filter( 'default_wp_template_part_areas', __NAMESPACE__ . '\\register_area' );
