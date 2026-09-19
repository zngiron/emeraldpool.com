<?php
/**
 * The spa card.
 *
 * The grid block and the comparison block both need the same card, and a card
 * that drifts between two renderers is how design systems rot. One function,
 * two callers.
 *
 * Design note: the card has no border, no radius and no panel. Bullfrog ships
 * its models as top-down renders — effectively plan drawings — so the card
 * treats them that way: the shell floats on the night ground over a faint
 * centre cross, with its dimensions annotated in the data face, and the name
 * and price sit underneath the image rather than inside a box with it. On hover
 * the shell lifts and, where the model has a clip, the still becomes video.
 *
 * @package EmeraldPool\Blocks
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Renders spa cards.
 */
final class Cards {

	/**
	 * Data source, not a hooked subsystem.
	 */
	public function register(): void {}

	/**
	 * One spa card.
	 *
	 * @param int                  $post_id Spa post ID.
	 * @param array<string, mixed> $args    show_price (bool), show_chips (bool), heading_level (int).
	 */
	public static function card( int $post_id, array $args = array() ): string {
		$args = wp_parse_args(
			$args,
			array(
				'show_price'    => true,
				'show_chips'    => true,
				'heading_level' => 3,
			)
		);

		$series = self::first_term_name( $post_id, 'spa_series' );
		$price  = $args['show_price'] ? Meta::display_value( $post_id, 'spa_price_from' ) : '';
		$dims   = Meta::display_value( $post_id, 'spa_dimensions' );
		$tag    = 'h' . max( 2, min( 6, (int) $args['heading_level'] ) );
		$poster = (string) get_the_post_thumbnail_url( $post_id, 'emerald-card' );
		$video  = Media::video( $post_id, $poster, 'ep-card__video' );

		ob_start();
		?>
		<article class="ep-card<?php echo $video ? ' has-video' : ''; ?>" data-ep-video-root>
			<div class="ep-card__media">
				<?php
				if ( has_post_thumbnail( $post_id ) ) {
					echo get_the_post_thumbnail(
						$post_id,
						'emerald-card',
						array(
							'loading'  => 'lazy',
							'decoding' => 'async',
							'class'    => 'ep-card__still',
						)
					);
				}

				echo $video; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in Media::video().
				?>

				<?php if ( $dims ) : ?>
					<p class="ep-card__dims"><?php echo esc_html( $dims ); ?></p>
				<?php endif; ?>
			</div>

			<div class="ep-card__body">
				<<?php echo esc_attr( $tag ); ?> class="ep-card__title">
					<a href="<?php echo esc_url( (string) get_permalink( $post_id ) ); ?>">
						<?php echo esc_html( get_the_title( $post_id ) ); ?>
					</a>
				</<?php echo esc_attr( $tag ); ?>>

				<p class="ep-card__meta">
					<?php if ( $series ) : ?>
						<span class="ep-card__series"><?php echo esc_html( $series ); ?></span>
					<?php endif; ?>

					<?php if ( $price ) : ?>
						<span class="ep-card__price">
							<?php
							printf(
								/* translators: %s: formatted price. */
								esc_html__( 'From %s', 'emerald-pool-blocks' ),
								'<strong>' . esc_html( $price ) . '</strong>'
							);
							?>
						</span>
					<?php endif; ?>
				</p>

				<?php if ( $args['show_chips'] ) : ?>
					<?php echo self::chips( Meta::primary_specs( $post_id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in chips(). ?>
				<?php endif; ?>
			</div>
		</article>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * A row of spec figures. No longer pills: a chip that looks like a tag reads
	 * as a control a visitor can press. These are numbers, so they are set as
	 * numbers — value in the data face, label beneath it, separated by rules.
	 *
	 * @param array<string, string> $specs Label => value.
	 */
	public static function chips( array $specs ): string {
		if ( ! $specs ) {
			return '';
		}

		$items = '';

		foreach ( $specs as $label => $value ) {
			$items .= sprintf(
				'<li class="ep-chip"><span class="ep-chip__value">%1$s</span><span class="ep-chip__label">%2$s</span></li>',
				esc_html( $value ),
				esc_html( strtolower( $label ) )
			);
		}

		return '<ul class="ep-chips">' . $items . '</ul>';
	}

	/**
	 * Name of the first term in a taxonomy.
	 *
	 * @param int    $post_id  Post ID.
	 * @param string $taxonomy Taxonomy slug.
	 */
	public static function first_term_name( int $post_id, string $taxonomy ): string {
		$terms = get_the_terms( $post_id, $taxonomy );

		return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
	}

	/**
	 * Slug of the first term in a taxonomy.
	 *
	 * @param int    $post_id  Post ID.
	 * @param string $taxonomy Taxonomy slug.
	 */
	public static function first_term_slug( int $post_id, string $taxonomy ): string {
		$terms = get_the_terms( $post_id, $taxonomy );

		return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : '';
	}

	/**
	 * Shown when a query returns nothing, so the page never renders a silent gap.
	 *
	 * @param string $message Message to show.
	 */
	public static function empty_state( string $message ): string {
		return '<p class="ep-empty">' . esc_html( $message ) . '</p>';
	}
}
