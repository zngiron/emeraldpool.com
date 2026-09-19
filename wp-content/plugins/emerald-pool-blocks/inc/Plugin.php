<?php
/**
 * Plugin bootstrap.
 *
 * The only file that knows the full list of subsystems. Each subsystem is a class
 * with a single register() method and no constructor side effects, so they can be
 * unit tested or lifted into another client plugin one at a time.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Loads and registers every subsystem.
 */
final class Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var Plugin|null
	 */
	private static ?Plugin $instance = null;

	/**
	 * Subsystem class names, in load order.
	 *
	 * @var string[]
	 */
	private const SUBSYSTEMS = array(
		PostTypes::class,
		Meta::class,
		Locations::class,
		Cards::class,
		Media::class,
		Icons::class,
		BlockCategory::class,
		Blocks::class,
		Schema::class,
		Assets::class,
	);

	/**
	 * Get the shared instance.
	 */
	public static function instance(): Plugin {
		return self::$instance ??= new self();
	}

	/**
	 * Private: use instance().
	 */
	private function __construct() {}

	/**
	 * Require every subsystem file and call its register() method.
	 */
	public function boot(): void {
		foreach ( self::SUBSYSTEMS as $class ) {
			$short = substr( (string) strrchr( $class, '\\' ), 1 );
			require_once DIR . '/inc/' . $short . '.php';

			( new $class() )->register();
		}
	}
}
