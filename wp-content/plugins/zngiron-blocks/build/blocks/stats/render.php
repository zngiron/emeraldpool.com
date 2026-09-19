<?php
/**
 * Stats — server render.
 *
 * The figures are printed at their real value, so the section is complete for
 * anyone who never runs the script. view.js only replays a number that is
 * already correct.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_items = array_values( array_filter( (array) ( $attributes['items'] ?? array() ) ) );

if ( ! $z_items ) {
    return;
}
?>
<div
    <?php echo get_block_wrapper_attributes( array( 'class' => 'z-stats' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>
    data-wp-interactive="zngiron/stats"
>
    <?php if ( ! empty( $attributes['heading'] ) ) : ?>
        <h2 class="z-stats__heading"><?php echo wp_kses_post( (string) $attributes['heading'] ); ?></h2>
    <?php endif; ?>

    <dl class="z-stats__list">
        <?php
        foreach ( $z_items as $z_item ) :
            $z_value = (float) ( $z_item['value'] ?? 0 );
            // A year is a label, not a quantity: never grouped, never counted.
            $z_plain = ! empty( $z_item['plain'] );
            ?>
            <div class="z-stats__row">
                <dt class="z-stats__figure">
                    <?php if ( ! empty( $z_item['prefix'] ) ) : ?>
                        <span class="z-stats__affix"><?php echo esc_html( (string) $z_item['prefix'] ); ?></span>
                    <?php endif; ?>

                    <span
                        class="z-stats__value"
                        <?php if ( ! $z_plain ) : ?>
                            data-wp-init="callbacks.count"
                            data-target="<?php echo esc_attr( (string) $z_value ); ?>"
                        <?php endif; ?>
                    ><?php echo esc_html( $z_plain ? (string) (int) $z_value : number_format_i18n( $z_value ) ); ?></span>

                    <?php if ( ! empty( $z_item['suffix'] ) ) : ?>
                        <span class="z-stats__affix"><?php echo esc_html( (string) $z_item['suffix'] ); ?></span>
                    <?php endif; ?>
                </dt>
                <dd class="z-stats__label"><?php echo esc_html( (string) ( $z_item['label'] ?? '' ) ); ?></dd>
            </div>
        <?php endforeach; ?>
    </dl>
</div>
