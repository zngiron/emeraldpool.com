<?php
/**
 * Title: Project gallery
 * Slug: emerald-pool/projects-gallery
 * Categories: emerald-pool/section
 * Description: Four photographs of finished work with a short introduction.
 * Keywords: gallery, projects, photos, work
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

$ep_shots = array(
	array( 'lifestyle-couple.webp', 'A couple in a Bullfrog spa on a lit deck' ),
	array( 'services.jpg', 'A technician servicing a pool pump' ),
	array( 'about-team.jpg', 'The Emerald Pool team outside the Eugene store' ),
	array( 'feature-jetpak.jpg', 'A hand swapping a JetPak in a spa wall' ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","wideSize":"1280px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Work we have finished</h3>
<!-- /wp:heading -->

<!-- wp:gallery {"columns":4,"linkTo":"none","align":"wide","sizeSlug":"large"} -->
<figure class="wp-block-gallery has-nested-images columns-4 is-cropped alignwide">
<?php foreach ( $ep_shots as $ep_shot ) : ?>
<!-- wp:image {"sizeSlug":"large","className":"is-style-soft"} -->
<figure class="wp-block-image size-large is-style-soft"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $ep_shot[0] ) ); ?>" alt="<?php echo esc_attr( $ep_shot[1] ); ?>"/></figure>
<!-- /wp:image -->
<?php endforeach; ?>
</figure>
<!-- /wp:gallery --></div>
<!-- /wp:group -->
