<?php
/**
 * Locations — server render.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_wanted    = array_filter( (array) ( $attributes['slugs'] ?? array() ) );
$z_locations = Config::locations();

if ( $z_wanted ) {
    $z_locations = array_values(
        array_filter(
            $z_locations,
            static fn( array $location ): bool => in_array( $location['slug'] ?? '', $z_wanted, true )
        )
    );
}

if ( ! $z_locations ) {
    return;
}

$z_hours = ! empty( $attributes['showHours'] );
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'z-locations' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
    <?php if ( ! empty( $attributes['heading'] ) ) : ?>
        <h2 class="z-locations__heading"><?php echo wp_kses_post( (string) $attributes['heading'] ); ?></h2>
    <?php endif; ?>

    <div class="z-locations__list">
        <?php foreach ( $z_locations as $z_location ) : ?>
            <article class="z-location">
                <h3 class="z-location__name"><?php echo esc_html( (string) ( $z_location['name'] ?? '' ) ); ?></h3>

                <?php if ( ! empty( $z_location['legal'] ) ) : ?>
                    <p class="z-location__legal"><?php echo esc_html( (string) $z_location['legal'] ); ?></p>
                <?php endif; ?>

                <address class="z-location__address">
                    <?php echo esc_html( (string) ( $z_location['street'] ?? '' ) ); ?><br />
                    <?php
                    echo esc_html(
                        trim( sprintf( '%s, %s %s', $z_location['city'] ?? '', $z_location['region'] ?? '', $z_location['postcode'] ?? '' ) )
                    );
                    ?>
                </address>

                <?php if ( $z_hours && ! empty( $z_location['hours'] ) ) : ?>
                    <p class="z-location__hours"><?php echo esc_html( (string) $z_location['hours'] ); ?></p>
                <?php endif; ?>

                <p class="z-location__links">
                    <?php if ( ! empty( $z_location['phone'] ) ) : ?>
                        <a href="tel:<?php echo esc_attr( Render::tel( (string) $z_location['phone'] ) ); ?>">
                            <?php echo esc_html( (string) $z_location['phone'] ); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $z_location['map'] ) ) : ?>
                        <a href="<?php echo esc_url( (string) $z_location['map'] ); ?>" rel="noopener">
                            <?php esc_html_e( 'Directions', 'zngiron-blocks' ); ?>
                        </a>
                    <?php endif; ?>
                </p>
            </article>
        <?php endforeach; ?>
    </div>
</div>
