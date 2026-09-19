<?php
/**
 * Emerald Pool theme bootstrap.
 *
 * Intentionally thin: this file only wires up `inc/`. Every concern lives in its
 * own file so another client site can swap one file without reading the rest.
 *
 * @package EmeraldPool\Theme
 */

declare( strict_types = 1 );

namespace EmeraldPool\Theme;

defined( 'ABSPATH' ) || exit;

const VERSION = '1.1.0';

/**
 * Files are loaded in dependency order: setup() defines brand_config(), which
 * assets/patterns may read.
 */
foreach (
	array(
		'setup',
		'assets',
		'patterns',
		'block-styles',
		'block-variations',
	) as $module
) {
	require_once __DIR__ . '/inc/' . $module . '.php';
}
