<?php
/**
 * Title: Brand lockup
 * Slug: emerald-pool/brand-lockup
 * Categories: emerald-pool/section
 * Description: The logo, linked home. Used by the header; set the site logo in the editor to rebrand.
 * Inserter: no
 *
 * @package EmeraldPool\Theme
 */

/*
 * The mark is a core Site Logo block wherever the site has one set, so an editor
 * can swap the image and nudge its width without touching a file. Its height —
 * the thing that actually decides how tall the header is — is capped in
 * assets/css/theme.css rather than written into the markup, because the supplied
 * artwork is a wide lockup and only a height cap keeps it honest at any width.
 *
 * The bundled theme image is the fallback for a fresh install with no logo set,
 * so the header is never empty.
 */

?>
<!-- wp:group {"layout":{"type":"flex","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<?php if ( has_custom_logo() ) : ?>
	<!-- wp:site-logo {"width":84} /-->
<?php else : ?>
	<!-- wp:image {"sizeSlug":"full","linkDestination":"custom"} -->
	<figure class="wp-block-image size-full"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home"/></a></figure>
	<!-- /wp:image -->
<?php endif; ?>
</div>
<!-- /wp:group -->
