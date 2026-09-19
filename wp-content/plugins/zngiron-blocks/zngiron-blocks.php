<?php
/**
 * Plugin Name:       Zngiron Blocks
 * Description:       A reusable block system: brand data from config/brand.json, a configured content model, and twelve server-rendered blocks under the zngiron namespace.
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      8.1
 * Author:            zngiron
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       zngiron-blocks
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

const VERSION = '1.0.0';
const FILE    = __FILE__;
const DIR     = __DIR__;

require_once __DIR__ . '/inc/Plugin.php';

Plugin::boot();
