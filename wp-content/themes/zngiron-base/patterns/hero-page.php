<?php
/**
 * Title: Opening — page hero
 * Slug: zngiron-base/hero-page
 * Categories: zngiron-opening
 * Block Types: core/post-content
 * Description: The shorter Hero an inside page opens on: half the viewport, one heading, one standfirst.
 *
 * @package Zngiron\Theme
 */

$z_media = esc_url( get_theme_file_uri( 'assets/images/hero-hot-tubs.jpg' ) );
?>
<!-- wp:zngiron/hero {"eyebrow":"Hot tubs","heading":"Six to nine seats, built for an Oregon winter","text":"Every model on this page is insulated for a wet, cold winter, filled and heated on our floor, and serviced by the people who delivered it.","height":"short","buttons":[{"text":"Book a wet test","url":"/contact/","style":"primary"}],"frame":{"mediaUrl":"<?php echo $z_media; ?>","alt":"A woman leaning on the edge of a steaming hot tub in a back yard","ratio":"21:9","fit":"cover","focalPoint":{"x":0.58,"y":0.6}},"align":"full"} /-->
