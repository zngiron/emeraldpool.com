<?php
/**
 * Hover video.
 *
 * The live emeraldpool.com plays a short clip when the pointer rests on a model
 * image. This is that behaviour, rebuilt as an asset the catalogue owns: the
 * clip's URL is a spa meta field (`spa_video_url`), so it is editable, and the
 * markup and the script live here rather than being copied into the card and
 * the hero.
 *
 * Why a plain script module and not the Interactivity API: the Interactivity API
 * exists to keep rendered markup in step with state. Playing a video on hover
 * changes no markup and stores no state — it is a side effect on a media
 * element — and the API's runtime is roughly ten times the size of this file.
 * The two blocks that do hold state (spa-grid's filter, testimonial-slider) use
 * the Interactivity API, as the architecture requires.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers and renders the hover video.
 */
final class Media {

	/**
	 * Script module id.
	 */
	public const MODULE = 'emerald-pool-media';

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'init', array( $this, 'register_module' ), 5 );
	}

	/**
	 * Register the module. It is only enqueued by a render that emits a video.
	 */
	public function register_module(): void {
		if ( ! function_exists( 'wp_register_script_module' ) ) {
			return;
		}

		$path = DIR . '/assets/media.js';

		wp_register_script_module(
			self::MODULE,
			plugins_url( 'assets/media.js', FILE ),
			array(),
			(string) ( is_readable( $path ) ? filemtime( $path ) : VERSION )
		);
	}

	/**
	 * The video element for a spa, or an empty string when it has no clip.
	 *
	 * Nothing is downloaded until the visitor asks for it: `preload="none"` plus
	 * a `data-src` on the source means the browser has no media URL to fetch
	 * until the script hands it one. The poster is the spa's own featured image,
	 * already on the page, so the first frame costs no extra request either.
	 *
	 * The element is `aria-hidden` and not focusable: it is decoration over an
	 * image that already carries the alt text, and it is muted and loops, so
	 * there is nothing for a screen reader or a keyboard to operate.
	 *
	 * @param int    $post_id Spa post ID.
	 * @param string $poster  Poster image URL.
	 * @param string $class   Class for the video element.
	 */
	public static function video( int $post_id, string $poster = '', string $class = 'ep-video' ): string {
		$url = (string) get_post_meta( $post_id, 'spa_video_url', true );

		if ( '' === $url ) {
			return '';
		}

		if ( function_exists( 'wp_enqueue_script_module' ) ) {
			wp_enqueue_script_module( self::MODULE );
		}

		return sprintf(
			'<video class="%1$s" data-ep-video muted loop playsinline preload="none" tabindex="-1" aria-hidden="true"%2$s><source data-src="%3$s" type="%4$s"></video>',
			esc_attr( $class ),
			$poster ? ' poster="' . esc_url( $poster ) . '"' : '',
			esc_url( $url ),
			esc_attr( str_ends_with( strtolower( $url ), '.webm' ) ? 'video/webm' : 'video/mp4' )
		);
	}

	/**
	 * True when this spa has a clip. Lets a caller add the hover affordance class
	 * without rendering the element twice.
	 *
	 * @param int $post_id Spa post ID.
	 */
	public static function has_video( int $post_id ): bool {
		return '' !== (string) get_post_meta( $post_id, 'spa_video_url', true );
	}
}
