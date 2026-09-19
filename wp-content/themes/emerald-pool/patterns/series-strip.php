<?php
/**
 * Title: Series strip
 * Slug: emerald-pool/series-strip
 * Categories: emerald-pool/product
 * Description: Six series tiles, each linking to its collection.
 * Keywords: series, collection, tiles
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

$ep_series = array(
	array( 'a-series', 'A Series', 'Luxury', 'spa-a7d.jpg' ),
	array( 'm-series', 'M Series', 'Elite', 'spa-m8.jpg' ),
	array( 'x-series', 'X Series', 'Comfort', 'spa-x7.jpg' ),
	array( 'stil', 'STIL', 'Modern', 'spa-stil7.jpg' ),
	array( 'calm', 'Calm', 'Value', 'spa-calm7.jpg' ),
	array( 'swim-series', 'Swim Series', 'Performance', 'spa-s200.jpg' ),
);
?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","wideSize":"1280px"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Six families, one fit</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Start with the series</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<?php foreach ( array_slice( $ep_series, 0, 3 ) as $ep_item ) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $ep_item[3] ) ); ?>" alt="<?php echo esc_attr( $ep_item[1] ); ?> spa, seen from above"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size"><a href="/series/<?php echo esc_attr( $ep_item[0] ); ?>/"><?php echo esc_html( $ep_item[1] ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"text-muted","fontSize":"small"} -->
<p class="has-text-muted-color has-text-color has-small-font-size"><?php echo esc_html( $ep_item[2] ); ?> class</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<?php foreach ( array_slice( $ep_series, 3, 3 ) as $ep_item ) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-card"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $ep_item[3] ) ); ?>" alt="<?php echo esc_attr( $ep_item[1] ); ?> spa, seen from above"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size"><a href="/series/<?php echo esc_attr( $ep_item[0] ); ?>/"><?php echo esc_html( $ep_item[1] ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"text-muted","fontSize":"small"} -->
<p class="has-text-muted-color has-text-color has-small-font-size"><?php echo esc_html( $ep_item[2] ); ?> class</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
