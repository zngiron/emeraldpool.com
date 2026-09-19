<?php
/**
 * Hero — server render.
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

$ep_align  = 'center' === ( $attributes['contentAlign'] ?? 'left' ) ? 'center' : 'left';
$ep_focal  = $attributes['focalPoint'] ?? array( 'x' => 0.5, 'y' => 0.5 );
$ep_style  = sprintf(
	'--ep-hero-min-height:%1$dvh;--ep-hero-overlay:%2$s;--ep-hero-focal:%3$s%% %4$s%%',
	max( 20, min( 100, (int) ( $attributes['minHeight'] ?? 66 ) ) ),
	(string) round( max( 0, min( 90, (int) ( $attributes['overlayOpacity'] ?? 55 ) ) ) / 100, 2 ),
	(string) round( (float) ( $ep_focal['x'] ?? 0.5 ) * 100 ),
	(string) round( (float) ( $ep_focal['y'] ?? 0.5 ) * 100 )
);

$ep_wrapper = get_block_wrapper_attributes(
	array(
		'class' => 'ep-hero is-align-' . $ep_align,
		'style' => $ep_style,
	)
);
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

	<div class="ep-hero__scrim" aria-hidden="true"></div>

	<div class="ep-hero__inner">
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
</div>
