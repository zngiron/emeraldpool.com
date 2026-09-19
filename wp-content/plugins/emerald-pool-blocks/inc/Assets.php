<?php
/**
 * Shared asset handles.
 *
 * Per-block CSS is compiled by wp-scripts and loaded by WordPress on demand.
 * The only thing registered here is the handful of primitives more than one
 * block shares — the spec chip and the card frame — so they are not duplicated
 * in three compiled stylesheets.
 *
 * Blocks opt in by listing the handle in their block.json `style` array, which
 * keeps the on-demand loading behaviour.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers shared styles.
 */
final class Assets {

	/**
	 * Handle shared by several blocks.
	 */
	public const SHARED_STYLE = 'emerald-pool-shared';

	/**
	 * Editor script that hands the PHP icon set to the block picker.
	 */
	public const ICONS_SCRIPT = 'emerald-pool-icons';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'init', array( $this, 'register_shared_style' ), 5 );
		add_action( 'init', array( $this, 'register_icons_script' ), 5 );
	}

	/**
	 * Register the shared primitives stylesheet.
	 */
	public function register_shared_style(): void {
		$path = DIR . '/assets/shared.css';

		wp_register_style(
			self::SHARED_STYLE,
			plugins_url( 'assets/shared.css', FILE ),
			array(),
			(string) ( is_readable( $path ) ? filemtime( $path ) : VERSION )
		);
	}

	/**
	 * Publish the icon set to the editor.
	 *
	 * Blocks list this handle in their block.json `editorScript` array, so the
	 * picker and the server render draw the same eight icons from Icons::all().
	 */
	public function register_icons_script(): void {
		wp_register_script( self::ICONS_SCRIPT, '', array(), VERSION, true );
		wp_add_inline_script(
			self::ICONS_SCRIPT,
			'window.emeraldPoolIcons = ' . wp_json_encode( Icons::all() ) . ';',
			'before'
		);
	}
}
