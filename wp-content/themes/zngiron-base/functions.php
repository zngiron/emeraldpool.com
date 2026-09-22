<?php
/**
 * Zngiron Base bootstrap.
 *
 * Thin on purpose: it loads inc/ and nothing else. Each concern is one file so a
 * rebrand can replace one of them without reading the others.
 *
 * @package Zngiron\Theme
 */

declare( strict_types = 1 );

namespace Zngiron\Theme;

defined( 'ABSPATH' ) || exit;

const VERSION = '1.0.0';

foreach ( array( 'setup', 'assets', 'meta', 'patterns', 'block-styles' ) as $module ) {
    require_once __DIR__ . '/inc/' . $module . '.php';
}
