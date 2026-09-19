<?php
/**
 * Title: Brand lockup
 * Slug: emerald-pool/brand-lockup
 * Categories: emerald-pool/section
 * Description: The logo, linked home. Used by the header; swap the image here to rebrand.
 * Inserter: no
 *
 * @package EmeraldPool\Theme
 */

?>
<!-- wp:group {"layout":{"type":"flex","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:image {"width":"162px","sizeSlug":"full","linkDestination":"custom"} -->
<figure class="wp-block-image size-full is-resized"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home" style="width:162px"/></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->
