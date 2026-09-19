<?php
/**
 * Shared front-end markup.
 *
 * WHY A SEVENTH FILE: the Frame is the sizing contract and the Card is the one
 * repeated unit of content. Frame markup is emitted by Hero, Media Text, Card,
 * Post Grid and Testimonials; Card markup by both Card Grid children and Post
 * Grid. Markup duplicated across five render.php files drifts, and when it
 * drifts the sizing contract stops holding. One function per shape, several
 * callers.
 *
 * @package Zngiron\Blocks
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Renders the shared primitives.
 */
final class Render {

    /**
     * Ratios the Frame accepts. Anything else falls back to 16:9.
     *
     * @var array<int, string>
     */
    public const RATIOS = array( '21:9', '16:9', '3:2', '4:5', '1:1' );

    /**
     * A Frame: a fixed-ratio box holding an image or a video.
     *
     * The media never sets the height of a layout — the ratio does — so every
     * brand's photography drops in without per-image tuning.
     *
     * @param array<string, mixed> $args mediaId, mediaUrl, mediaType, alt, ratio,
     *                                   fit, focalPoint, poster, className, eager.
     */
    public static function frame( array $args = array() ): string {
        $args = wp_parse_args(
            $args,
            array(
                'mediaId'    => 0,
                'mediaUrl'   => '',
                'mediaType'  => 'image',
                'alt'        => '',
                'ratio'      => '16:9',
                'fit'        => 'cover',
                'focalPoint' => array(
                    'x' => 0.5,
                    'y' => 0.5,
                ),
                'poster'     => '',
                'className'  => '',
                'eager'      => false,
                'size'       => 'large',
            )
        );

        $url = (string) $args['mediaUrl'];

        if ( ! $url && $args['mediaId'] ) {
            $url = (string) wp_get_attachment_image_url( (int) $args['mediaId'], (string) $args['size'] );
        }

        if ( ! $url ) {
            return '';
        }

        $ratio = in_array( (string) $args['ratio'], self::RATIOS, true ) ? (string) $args['ratio'] : '16:9';
        $fit   = 'contain' === $args['fit'] ? 'contain' : 'cover';
        $focal = (array) $args['focalPoint'];
        $style = sprintf(
            '--z-ratio:%s; --z-focal-x:%s%%; --z-focal-y:%s%%',
            str_replace( ':', '/', $ratio ),
            round( (float) ( $focal['x'] ?? 0.5 ) * 100, 2 ),
            round( (float) ( $focal['y'] ?? 0.5 ) * 100, 2 )
        );

        $classes = trim( 'z-frame is-fit-' . $fit . ' ' . (string) $args['className'] );

        if ( 'video' === $args['mediaType'] ) {
            $media = sprintf(
                '<video class="z-frame__media" src="%1$s" poster="%2$s" autoplay muted loop playsinline preload="metadata"></video>',
                esc_url( $url ),
                esc_url( (string) $args['poster'] )
            );
        } elseif ( $args['mediaId'] ) {
            $media = wp_get_attachment_image(
                (int) $args['mediaId'],
                (string) $args['size'],
                false,
                array(
                    'class'    => 'z-frame__media',
                    'loading'  => $args['eager'] ? 'eager' : 'lazy',
                    'decoding' => 'async',
                    'alt'      => (string) $args['alt'],
                )
            );
        } else {
            $media = sprintf(
                '<img class="z-frame__media" src="%1$s" alt="%2$s" loading="%3$s" decoding="async" />',
                esc_url( $url ),
                esc_attr( (string) $args['alt'] ),
                $args['eager'] ? 'eager' : 'lazy'
            );
        }

        return sprintf(
            '<figure class="%1$s" style="%2$s">%3$s</figure>',
            esc_attr( $classes ),
            esc_attr( $style ),
            $media // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped parts above.
        );
    }

    /**
     * A Card: Frame, title, text, link. The Card block passes its own
     * attributes; Post Grid passes a post.
     *
     * @param array<string, mixed> $args title, text, url, linkText, frame (Frame args),
     *                                   meta (label => value), headingLevel.
     */
    public static function card( array $args = array() ): string {
        $args = wp_parse_args(
            $args,
            array(
                'title'        => '',
                'text'         => '',
                'url'          => '',
                'linkText'     => '',
                'frame'        => array(),
                'meta'         => array(),
                'headingLevel' => 3,
            )
        );

        $tag   = 'h' . max( 2, min( 6, (int) $args['headingLevel'] ) );
        $frame = $args['frame'] ? self::frame( (array) $args['frame'] ) : '';
        $title = (string) $args['title'];
        $url   = (string) $args['url'];

        ob_start();
        ?>
        <article class="z-card">
            <?php if ( $frame ) : ?>
                <div class="z-card__media">
                    <?php echo $frame; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in frame(). ?>
                </div>
            <?php endif; ?>

            <div class="z-card__body">
                <?php if ( $title ) : ?>
                    <<?php echo esc_attr( $tag ); ?> class="z-card__title">
                        <?php if ( $url ) : ?>
                            <a class="z-card__link" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a>
                        <?php else : ?>
                            <?php echo esc_html( $title ); ?>
                        <?php endif; ?>
                    </<?php echo esc_attr( $tag ); ?>>
                <?php endif; ?>

                <?php if ( $args['text'] ) : ?>
                    <p class="z-card__text"><?php echo wp_kses_post( (string) $args['text'] ); ?></p>
                <?php endif; ?>

                <?php if ( $args['meta'] ) : ?>
                    <ul class="z-card__meta">
                        <?php foreach ( (array) $args['meta'] as $label => $value ) : ?>
                            <li class="z-card__meta-item">
                                <span class="z-card__meta-value"><?php echo esc_html( (string) $value ); ?></span>
                                <span class="z-card__meta-label"><?php echo esc_html( (string) $label ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $url && $args['linkText'] ) : ?>
                    <p class="z-card__cta"><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( (string) $args['linkText'] ); ?></a></p>
                <?php endif; ?>
            </div>
        </article>
        <?php
        return (string) ob_get_clean();
    }

    /**
     * A row of buttons from the shared Buttons attribute shape.
     *
     * @param array<int, array<string, string>> $buttons Each: text, url, style.
     */
    public static function buttons( array $buttons ): string {
        $items = '';

        foreach ( $buttons as $button ) {
            $text = (string) ( $button['text'] ?? '' );
            $url  = (string) ( $button['url'] ?? '' );

            if ( ! $text ) {
                continue;
            }

            $items .= sprintf(
                '<a class="z-button is-style-%1$s" href="%2$s">%3$s</a>',
                esc_attr( 'secondary' === ( $button['style'] ?? '' ) ? 'secondary' : 'primary' ),
                esc_url( $url ?: '#' ),
                esc_html( $text )
            );
        }

        return $items ? '<div class="z-buttons">' . $items . '</div>' : '';
    }

    /**
     * Digits only, for a tel: href.
     *
     * @param string $phone Display phone number.
     */
    public static function tel( string $phone ): string {
        return '+1' . preg_replace( '/\D+/', '', $phone );
    }
}
