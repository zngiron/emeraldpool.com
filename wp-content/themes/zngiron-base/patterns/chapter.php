<?php
/**
 * Title: Section — chapter
 * Slug: zngiron-base/chapter
 * Categories: zngiron-section
 * Description: A Frame beside a column of copy. The side switches; the two columns stay the same height.
 *
 * @package Zngiron\Theme
 */

$z_media = esc_url( get_theme_file_uri( 'assets/images/lifestyle-friends.jpg' ) );
?>
<!-- wp:group {"className":"z-section","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull z-section"><!-- wp:zngiron/media-text {"eyebrow":"Service","heading":"The people who sold it are the people who fix it.","text":"Twelve technicians and delivery crew, none of them subcontracted, most of them here longer than the spas they go back out to service. Parts and records going back to the nineteen-eighties sit forty feet from the counter.","mediaSide":"left","buttons":[{"text":"What we service","url":"/services/","style":"secondary"}],"frame":{"mediaUrl":"<?php echo $z_media; ?>","alt":"Friends talking in a hot tub on a covered patio","ratio":"4:5","fit":"cover","focalPoint":{"x":0.5,"y":0.45}},"align":"wide"} /--></div>
<!-- /wp:group -->
