<?php
/**
 * Pattern registration.
 *
 * WordPress auto-registers everything in patterns/ from its file headers, so this
 * file only owns the categories those headers point at. One category per role
 * keeps the inserter readable once a second brand adds its own patterns.
 *
 * @package Zngiron\Theme
 */

declare( strict_types = 1 );

namespace Zngiron\Theme\Patterns;

defined( 'ABSPATH' ) || exit;

/**
 * Inserter categories used by the pattern headers.
 *
 * @return array<string, string>
 */
function categories(): array {
    return array(
        'zngiron-opening' => __( 'Zngiron: openings', 'zngiron-base' ),
        'zngiron-section' => __( 'Zngiron: sections', 'zngiron-base' ),
        'zngiron-closing' => __( 'Zngiron: closings', 'zngiron-base' ),
    );
}

/**
 * Register them.
 */
function register(): void {
    foreach ( categories() as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', __NAMESPACE__ . '\\register', 9 );
