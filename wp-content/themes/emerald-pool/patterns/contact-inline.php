<?php
/**
 * Title: Contact — form and stores
 * Slug: emerald-pool/contact-inline
 * Categories: emerald-pool/contact
 * Description: One inline form beside the shop details. No modal, no overlay, no second form anywhere else on the site.
 * Keywords: contact, form, quote, enquiry
 * Viewport Width: 1400
 *
 * @package EmeraldPool\Theme
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","wideSize":"1280px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Tell us about your backyard</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"text-muted"} -->
<p class="has-text-muted-color has-text-color">A real person reads this. We answer within one business day, and we will say so if what you want is not something we can do well.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<form class="ep-form" method="post" action="#">
	<p class="ep-form__field">
		<label for="ep-name">Your name</label>
		<input id="ep-name" name="ep-name" type="text" autocomplete="name" required>
	</p>
	<p class="ep-form__field">
		<label for="ep-email">Email</label>
		<input id="ep-email" name="ep-email" type="email" autocomplete="email" required>
	</p>
	<p class="ep-form__field">
		<label for="ep-phone">Phone <span class="ep-form__optional">optional</span></label>
		<input id="ep-phone" name="ep-phone" type="tel" autocomplete="tel">
	</p>
	<p class="ep-form__field">
		<label for="ep-store">Nearest store</label>
		<select id="ep-store" name="ep-store">
			<option value="eugene">Eugene</option>
			<option value="bend">Bend</option>
		</select>
	</p>
	<p class="ep-form__field">
		<label for="ep-message">What are you planning?</label>
		<textarea id="ep-message" name="ep-message" rows="5" required></textarea>
	</p>
	<p class="ep-form__actions">
		<button type="submit" class="wp-element-button">Send it</button>
		<span class="ep-form__note">We reply within one business day.</span>
	</p>
</form>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-small-font-size">Or just come in</h2>
<!-- /wp:heading -->

<!-- wp:emerald-pool/store-locator-card {"layout":"cards","headingLevel":3} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
