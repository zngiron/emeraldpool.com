<?php
/**
 * Bootstrap.
 *
 * Loads the subsystems and hands each one its register() call. Nothing else
 * happens at file scope, so the plugin is safe to require from a test harness.
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Wires the plugin together.
 */
final class Plugin {

    /**
     * Load every subsystem once.
     */
    public static function boot(): void {
        static $booted = false;

        if ( $booted ) {
            return;
        }

        $booted = true;

        foreach ( array( 'Config', 'Render', 'PostTypes', 'Meta', 'Blocks', 'Schema' ) as $class ) {
            require_once DIR . '/inc/' . $class . '.php';
        }

        ( new PostTypes() )->register();
        ( new Meta() )->register();
        ( new Blocks() )->register();
        ( new Schema() )->register();
    }
}
