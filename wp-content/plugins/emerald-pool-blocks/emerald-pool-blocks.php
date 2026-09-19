<?php
/**
 * Plugin Name:       Emerald Pool Blocks
 * Plugin URI:        https://emeraldpool.com
 * Description:       The content layer for the Emerald Pool block theme: a data-driven spa catalogue (custom post type, taxonomies, meta) and the custom Gutenberg blocks that present it.
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      8.0
 * Author:            Emerald Pool & Patio
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       emerald-pool-blocks
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

const VERSION  = '1.0.0';
const FILE     = __FILE__;
const DIR      = __DIR__;

require_once __DIR__ . '/inc/Plugin.php';

Plugin::instance()->boot();
