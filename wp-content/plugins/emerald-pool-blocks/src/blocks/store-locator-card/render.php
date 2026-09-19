<?php
/**
 * Store cards — server render.
 *
 * @package EmeraldPool\Blocks
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner content (unused).
 * @var WP_Block $block      Block instance.
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

$ep_slug      = (string) ( $attributes['location'] ?? '' );
$ep_locations = $ep_slug ? array_filter( array( $ep_slug => Locations::get( $ep_slug ) ) ) : Locations::all();

if ( ! $ep_locations ) {
	return;
}

$ep_layout = 'inline' === ( $attributes['layout'] ?? 'cards' ) ? 'inline' : 'cards';
$ep_tag    = 'h' . max( 2, min( 4, (int) ( $attributes['headingLevel'] ?? 3 ) ) );
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'ep-stores is-layout-' . $ep_layout ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
	<?php foreach ( $ep_locations as $ep_location ) : ?>
		<div class="ep-store">
			<<?php echo esc_attr( $ep_tag ); ?> class="ep-store__name">
				<?php echo esc_html( $ep_location['name'] ); ?>
				<span class="ep-store__legal"><?php echo esc_html( $ep_location['legal'] ); ?></span>
			</<?php echo esc_attr( $ep_tag ); ?>>

			<?php if ( ! empty( $attributes['showNote'] ) && ! empty( $ep_location['note'] ) ) : ?>
				<p class="ep-store__note"><?php echo esc_html( $ep_location['note'] ); ?></p>
			<?php endif; ?>

			<address class="ep-store__address">
				<?php echo esc_html( $ep_location['street'] ); ?><br>
				<?php echo esc_html( $ep_location['city'] . ', ' . $ep_location['region'] . ' ' . $ep_location['postcode'] ); ?>
			</address>

			<?php if ( ! empty( $attributes['showHours'] ) ) : ?>
				<p class="ep-store__hours">
					<span class="ep-store__label"><?php esc_html_e( 'Open', 'emerald-pool-blocks' ); ?></span>
					<?php echo esc_html( $ep_location['hours'] ); ?>
				</p>
			<?php endif; ?>

			<p class="ep-store__actions">
				<a class="ep-store__phone" href="tel:<?php echo esc_attr( Locations::tel( $ep_location['phone'] ) ); ?>">
					<?php echo esc_html( $ep_location['phone'] ); ?>
				</a>
				<?php if ( ! empty( $attributes['showMapLink'] ) && ! empty( $ep_location['map'] ) ) : ?>
					<a class="ep-store__map" href="<?php echo esc_url( $ep_location['map'] ); ?>" rel="noopener">
						<?php
						printf(
							/* translators: %s: store name. */
							esc_html__( 'Directions to %s', 'emerald-pool-blocks' ),
							esc_html( $ep_location['name'] )
						);
						?>
					</a>
				<?php endif; ?>
			</p>
		</div>
	<?php endforeach; ?>
</div>
