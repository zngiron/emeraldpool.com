<?php
/**
 * Hero — server render.
 *
 * The frame is asymmetric on purpose: the argument sits bottom-left at display
 * scale, the practical information a visitor came for — which shop, what hours —
 * sits bottom-right in the data face, and the two are separated by the width of
 * the page rather than stacked down its middle.
 *
 * @package EmeraldPool\Blocks
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner buttons.
 * @var WP_Block $block      Block instance.
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

$ep_align = 'center' === ( $attributes['contentAlign'] ?? 'left' ) ? 'center' : 'left';
$ep_focal = $attributes['focalPoint'] ?? array( 'x' => 0.5, 'y' => 0.5 );
$ep_video = (string) ( $attributes['videoUrl'] ?? '' );

$ep_style = sprintf(
	'--ep-hero-min-height:%1$dsvh;--ep-hero-overlay:%2$s;--ep-hero-focal:%3$s%% %4$s%%',
	max( 20, min( 100, (int) ( $attributes['minHeight'] ?? 92 ) ) ),
	(string) round( max( 0, min( 90, (int) ( $attributes['overlayOpacity'] ?? 62 ) ) ) / 100, 2 ),
	(string) round( (float) ( $ep_focal['x'] ?? 0.5 ) * 100 ),
	(string) round( (float) ( $ep_focal['y'] ?? 0.5 ) * 100 )
);

$ep_wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'ep-hero is-align-' . $ep_align,
		'style' => $ep_style,
	)
);

$ep_meta_lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) ( $attributes['metaBody'] ?? '' ) ) ?: array() ) );
?>
<div <?php echo $ep_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
	<?php if ( ! empty( $attributes['mediaUrl'] ) ) : ?>
		<img
			class="ep-hero__media"
			src="<?php echo esc_url( (string) $attributes['mediaUrl'] ); ?>"
			alt="<?php echo esc_attr( (string) ( $attributes['mediaAlt'] ?? '' ) ); ?>"
			fetchpriority="high"
			decoding="async"
		>
	<?php endif; ?>

	<?php
	/*
	 * A background clip is decoration over an image that already carries the alt
	 * text, so it is aria-hidden and unfocusable. It is muted, looped and
	 * play-on-load rather than play-on-hover — a hero is not something a visitor
	 * points at — and assets/media.js declines to start it at all under
	 * prefers-reduced-motion, leaving the still image in place.
	 */
	if ( '' !== $ep_video ) :
		if ( function_exists( 'wp_enqueue_script_module' ) ) {
			wp_enqueue_script_module( Media::MODULE );
		}
		?>
		<video
			class="ep-hero__video"
			data-ep-video
			muted
			loop
			playsinline
			preload="none"
			tabindex="-1"
			aria-hidden="true"
			<?php echo ! empty( $attributes['mediaUrl'] ) ? 'poster="' . esc_url( (string) $attributes['mediaUrl'] ) . '"' : ''; ?>
		><source data-src="<?php echo esc_url( $ep_video ); ?>" type="<?php echo esc_attr( str_ends_with( strtolower( $ep_video ), '.webm' ) ? 'video/webm' : 'video/mp4' ); ?>"></video>
	<?php endif; ?>

	<div class="ep-hero__scrim" aria-hidden="true"></div>

	<div class="ep-hero__inner">
		<div class="ep-hero__lede">
			<?php if ( ! empty( $attributes['eyebrow'] ) ) : ?>
				<p class="ep-hero__eyebrow"><?php echo wp_kses_post( (string) $attributes['eyebrow'] ); ?></p>
			<?php endif; ?>

			<?php
			$ep_level = max( 1, min( 3, (int) ( $attributes['headingLevel'] ?? 1 ) ) );
			printf(
				'<h%1$d class="ep-hero__heading">%2$s</h%1$d>',
				$ep_level, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- integer.
				wp_kses_post( (string) ( $attributes['heading'] ?? '' ) )
			);
			?>

			<?php if ( ! empty( $attributes['standfirst'] ) ) : ?>
				<p class="ep-hero__standfirst"><?php echo wp_kses_post( (string) $attributes['standfirst'] ); ?></p>
			<?php endif; ?>

			<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks. ?>
		</div>

		<?php if ( $ep_meta_lines || ! empty( $attributes['metaHeading'] ) ) : ?>
			<div class="ep-hero__meta">
				<?php if ( ! empty( $attributes['metaHeading'] ) ) : ?>
					<p class="ep-hero__meta-heading"><?php echo esc_html( (string) $attributes['metaHeading'] ); ?></p>
				<?php endif; ?>

				<?php foreach ( $ep_meta_lines as $ep_line ) : ?>
					<p class="ep-hero__meta-line"><?php echo esc_html( $ep_line ); ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $attributes['showScrollCue'] ) ) : ?>
		<span class="ep-hero__cue" aria-hidden="true"></span>
	<?php endif; ?>
</div>
