<?php
/**
 * Emerald Pool demo content.
 *
 * Run through `wp eval-file`. Everything here is idempotent: content is looked up by
 * slug and updated in place, so `make seed` can be run any number of times.
 *
 * Media IDs come from /tmp/ep-media.txt, written by seed.sh.
 *
 * @package EmeraldPool\Seed
 */

// ---------------------------------------------------------------- helpers.

/** @return array<string,int> */
function ep_media(): array {
	static $map = null;
	if ( null !== $map ) {
		return $map;
	}
	$map   = array();
	$lines = file( '/tmp/ep-media.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
	foreach ( (array) $lines as $line ) {
		list( $key, $id ) = array_pad( explode( '=', $line, 2 ), 2, '' );
		$map[ $key ]      = (int) $id;
	}
	return $map;
}

function ep_media_id( string $key ): int {
	$map = ep_media();
	if ( empty( $map[ $key ] ) ) {
		WP_CLI::warning( "No media imported for key: {$key}" );
		return 0;
	}
	return $map[ $key ];
}

function ep_media_url( string $key ): string {
	$id = ep_media_id( $key );
	return $id ? (string) wp_get_attachment_url( $id ) : '';
}

/** Replace {{MEDIA_URL:key}} tokens with real upload URLs. */
function ep_tokens( string $html ): string {
	return (string) preg_replace_callback(
		'/\{\{MEDIA_URL:([a-z0-9-]+)\}\}/',
		static fn( $m ) => ep_media_url( $m[1] ),
		$html
	);
}

function ep_file( string $relative ): string {
	$path = '/seed/content/' . $relative;
	if ( ! file_exists( $path ) ) {
		WP_CLI::error( "Missing content file: {$path}" );
	}
	return ep_tokens( (string) file_get_contents( $path ) );
}

/**
 * Create or update a post by slug. Returns the post ID.
 *
 * @param array<string,mixed> $args Post arguments; post_name and post_type required.
 */
function ep_upsert( array $args ): int {
	$existing = get_posts(
		array(
			'name'             => $args['post_name'],
			'post_type'        => $args['post_type'],
			'post_status'      => 'any',
			'posts_per_page'   => 1,
			'fields'           => 'ids',
			'suppress_filters' => false,
		)
	);

	$args['post_status'] = $args['post_status'] ?? 'publish';

	if ( $existing ) {
		$args['ID'] = (int) $existing[0];
		$id         = wp_update_post( $args, true );
		$verb       = 'updated';
	} else {
		$id   = wp_insert_post( $args, true );
		$verb = 'created';
	}

	if ( is_wp_error( $id ) ) {
		WP_CLI::error( $id->get_error_message() );
	}

	WP_CLI::log( sprintf( '    %-9s %-12s %s', $verb, $args['post_type'], $args['post_name'] ) );

	return (int) $id;
}

function ep_thumbnail( int $post_id, string $media_key ): void {
	$att = ep_media_id( $media_key );
	if ( $att ) {
		set_post_thumbnail( $post_id, $att );
	}
}

// ---------------------------------------------------------------- 1. spas.

WP_CLI::log( '==> Spas' );

$data = json_decode( (string) file_get_contents( '/seed/spas.json' ), true );
if ( empty( $data['spas'] ) ) {
	WP_CLI::error( 'Could not read /seed/spas.json' );
}

$spa_ids = array();

foreach ( $data['spas'] as $index => $spa ) {
	$content = ep_tokens(
		sprintf(
			'<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">%1$s</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"ep-spa-quickfacts","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group ep-spa-quickfacts"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Seats</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"spa_seats"}}}},"fontSize":"large"} -->
<p class="has-large-font-size">—</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Jets</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"spa_jets"}}}},"fontSize":"large"} -->
<p class="has-large-font-size">—</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Therapy pumps</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"spa_pumps"}}}},"fontSize":"large"} -->
<p class="has-large-font-size">—</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"className":"is-style-eyebrow","fontSize":"small"} -->
<h3 class="wp-block-heading is-style-eyebrow has-small-font-size">Water, gallons</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"spa_capacity_gallons"}}}},"fontSize":"large"} -->
<p class="has-large-font-size">—</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:emerald-pool/faq-accordion {"heading":"Before delivery day","emitSchema":false} -->
<div class="ep-faq__items"><!-- wp:details {"summary":"What will this one need electrically?"} -->
<details class="wp-block-details"><summary>What will this one need electrically?</summary><!-- wp:paragraph -->
<p>A dedicated 50 amp GFCI circuit within sight of the spa, run by a licensed electrician. We quote the spa; your electrician quotes the circuit. We are happy to recommend one in Eugene or Bend and to talk to them directly about the run.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"summary":"What does it sit on?"} -->
<details class="wp-block-details"><summary>What does it sit on?</summary><!-- wp:paragraph -->
<p>A level, load-rated surface: a four-inch reinforced pad, a deck built for the filled weight, or a spa pad system. Filled weight for this model is on the specification list above — read it before you decide the deck will cope.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"summary":"Can I sit in one before I buy?"} -->
<details class="wp-block-details"><summary>Can I sit in one before I buy?</summary><!-- wp:paragraph -->
<p>Yes, and you should. Both showrooms keep display spas filled and heated. Bring a swimsuit, book twenty minutes, and try this one against the model one series up.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:emerald-pool/faq-accordion -->',
			esc_html( $spa['overview'] )
		)
	);

	$id = ep_upsert(
		array(
			'post_type'    => 'spa',
			'post_name'    => $spa['slug'],
			'post_title'   => $spa['title'],
			'post_excerpt' => $spa['excerpt'],
			'post_content' => $content,
			'menu_order'   => $index + 1,
		)
	);

	$spa_ids[ $spa['slug'] ] = $id;

	foreach ( $spa['meta'] as $key => $value ) {
		update_post_meta( $id, $key, $value );
	}

	wp_set_object_terms( $id, array( $spa['spa_type'] ), 'spa_type', false );
	wp_set_object_terms( $id, array( $spa['type'] ), 'spa_series', false );

	$att = ep_media_id( 'spa-' . $spa['slug'] );
	if ( $att ) {
		set_post_thumbnail( $id, $att );
		wp_update_post(
			array(
				'ID'         => $att,
				'post_title' => $spa['title'],
			)
		);
		update_post_meta( $att, '_wp_attachment_image_alt', $spa['image_alt'] );
	}
}

// ---------------------------------------------------------------- 2. pages.

WP_CLI::log( '==> Pages' );

$pages = array(
	array(
		'slug'     => 'home',
		'title'    => 'Home',
		'file'     => 'home.html',
		'template' => '',
		'media'    => 'hero-backyard',
		'order'    => 1,
	),
	array(
		'slug'     => 'hot-tubs',
		'title'    => 'Hot Tubs',
		'file'     => 'hot-tubs.html',
		'template' => 'page-wide',
		'media'    => 'hero-hot-tubs',
		'order'    => 2,
	),
	array(
		'slug'     => 'swim-spas',
		'title'    => 'Swim Spas',
		'file'     => 'swim-spas.html',
		'template' => 'page-wide',
		'media'    => 'hero-swim-spa',
		'order'    => 3,
	),
	array(
		'slug'     => 'services',
		'title'    => 'Services',
		'file'     => 'services.html',
		'template' => 'page-wide',
		'media'    => 'services',
		'order'    => 4,
	),
	array(
		'slug'     => 'financing',
		'title'    => 'Financing',
		'file'     => 'financing.html',
		'template' => 'page-wide',
		'media'    => '',
		'order'    => 5,
	),
	array(
		'slug'     => 'about',
		'title'    => 'About',
		'file'     => 'about.html',
		'template' => 'page-wide',
		'media'    => 'about-team',
		'order'    => 6,
	),
	array(
		'slug'     => 'faq',
		'title'    => 'FAQ',
		'file'     => 'faq.html',
		'template' => 'page-wide',
		'media'    => '',
		'order'    => 7,
	),
	array(
		'slug'     => 'journal',
		'title'    => 'Journal',
		'file'     => 'blog.html',
		'template' => '',
		'media'    => '',
		'order'    => 8,
	),
	array(
		'slug'     => 'contact',
		'title'    => 'Contact',
		'file'     => 'contact.html',
		'template' => '',
		'media'    => '',
		'order'    => 9,
	),
);

// The posts page used to live at /blog/; the footer and the menu both point at
// /journal/. Rename the old page in place so the slug moves without orphaning it.
foreach ( get_posts(
	array(
		'name'           => 'blog',
		'post_type'      => 'page',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	)
) as $ep_old_blog ) {
	wp_update_post(
		array(
			'ID'        => (int) $ep_old_blog,
			'post_name' => 'journal',
		)
	);
	WP_CLI::log( '    renamed page blog -> journal' );
}

$page_ids = array();

foreach ( $pages as $page ) {
	$id = ep_upsert(
		array(
			'post_type'    => 'page',
			'post_name'    => $page['slug'],
			'post_title'   => $page['title'],
			'post_content' => ep_file( $page['file'] ),
			'menu_order'   => $page['order'],
		)
	);

	$page_ids[ $page['slug'] ] = $id;

	if ( $page['template'] ) {
		update_post_meta( $id, '_wp_page_template', $page['template'] );
	} else {
		delete_post_meta( $id, '_wp_page_template' );
	}

	if ( $page['media'] ) {
		ep_thumbnail( $id, $page['media'] );
	}
}

// ---------------------------------------------------------------- 3. posts.

WP_CLI::log( '==> Journal' );

$posts = array(
	array(
		'slug'    => 'how-to-enjoy-your-hot-tub-this-winter',
		'title'   => 'How to enjoy your hot tub this winter',
		'excerpt' => 'Eleven winters of service calls, boiled down to the six habits that keep a spa in use between November and March.',
		'media'   => 'blog-winter',
		'date'    => '-21 days',
		'cat'     => 'Seasonal',
	),
	array(
		'slug'    => 'when-to-buy-a-hot-tub',
		'title'   => 'When is the best time to buy a hot tub?',
		'excerpt' => 'Every season has an argument for it. Here is what actually changes the price, and what only changes the wait.',
		'media'   => 'hero-backyard',
		'date'    => '-45 days',
		'cat'     => 'Buying guides',
	),
	array(
		'slug'    => 'what-a-service-visit-actually-covers',
		'title'   => 'What a service visit actually covers',
		'excerpt' => 'Drain, clean, refill — and the six things our technicians check while the water is out.',
		'media'   => 'feature-jetpak',
		'date'    => '-70 days',
		'cat'     => 'Maintenance',
	),
);

foreach ( $posts as $post ) {
	$id = ep_upsert(
		array(
			'post_type'    => 'post',
			'post_name'    => $post['slug'],
			'post_title'   => $post['title'],
			'post_excerpt' => $post['excerpt'],
			'post_content' => ep_file( 'posts/' . $post['slug'] . '.html' ),
			'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( $post['date'] ) ),
		)
	);

	ep_thumbnail( $id, $post['media'] );

	$term = term_exists( $post['cat'], 'category' );
	if ( ! $term ) {
		$term = wp_insert_term( $post['cat'], 'category' );
	}
	if ( ! is_wp_error( $term ) ) {
		wp_set_post_categories( $id, array( (int) $term['term_id'] ) );
	}
}

// ---------------------------------------------------------------- 4. navigation.

WP_CLI::log( '==> Navigation' );

$nav_markup = <<<'HTML'
<!-- wp:navigation-submenu {"label":"Hot Tubs","url":"/hot-tubs/","kind":"post-type","type":"page"} -->
<!-- wp:navigation-link {"label":"All hot tubs","url":"/hot-tubs/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"A Series","url":"/series/a-series/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"M Series","url":"/series/m-series/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"X Series","url":"/series/x-series/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"STIL","url":"/series/stil/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Calm","url":"/series/calm/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Every model","url":"/spas/","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->

<!-- wp:navigation-link {"label":"Swim Spas","url":"/swim-spas/","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Services","url":"/services/","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"Financing","url":"/financing/","kind":"custom"} /-->

<!-- wp:navigation-submenu {"label":"About","url":"/about/","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Our story","url":"/about/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Journal","url":"/journal/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"FAQ","url":"/faq/","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->

<!-- wp:navigation-link {"label":"Contact","url":"/contact/","kind":"custom"} /-->
HTML;

// Remove any fallback navigation WordPress generated for itself.
foreach ( get_posts(
	array(
		'post_type'      => 'wp_navigation',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	)
) as $nav_id ) {
	if ( 'emerald-pool-primary' !== get_post_field( 'post_name', $nav_id ) ) {
		wp_delete_post( $nav_id, true );
	}
}

$nav_id = ep_upsert(
	array(
		'post_type'    => 'wp_navigation',
		'post_name'    => 'emerald-pool-primary',
		'post_title'   => 'Primary',
		'post_content' => $nav_markup,
	)
);

/*
 * Point the header template part at this menu. The part is read from the theme and
 * re-saved on every seed run, so the theme file stays the single source of the header.
 */
$header_file = get_theme_file_path( 'parts/header.html' );
if ( file_exists( $header_file ) ) {
	$header = (string) file_get_contents( $header_file );
	$header = str_replace( '<!-- wp:navigation {', sprintf( '<!-- wp:navigation {"ref":%d,', $nav_id ), $header );

	$part_id = ep_upsert(
		array(
			'post_type'    => 'wp_template_part',
			'post_name'    => 'header',
			'post_title'   => 'Header',
			'post_content' => $header,
		)
	);

	wp_set_object_terms( $part_id, array( get_stylesheet() ), 'wp_theme', false );
	wp_set_object_terms( $part_id, array( 'header' ), 'wp_template_part_area', false );
}

// ---------------------------------------------------------------- 5. options.

WP_CLI::log( '==> Options' );

update_option( 'blogname', 'Emerald Pool & Patio' );
update_option( 'blogdescription', 'Hot tubs, swim spas and pools in Eugene and Bend, Oregon' );
update_option( 'timezone_string', 'America/Los_Angeles' );
update_option( 'start_of_week', 1 );
update_option( 'date_format', 'j F Y' );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $page_ids['home'] );
update_option( 'page_for_posts', $page_ids['journal'] );
update_option( 'posts_per_page', 9 );
update_option( 'default_ping_status', 'closed' );
update_option( 'default_comment_status', 'closed' );

$logo = ep_media_id( 'logo' );
if ( $logo ) {
	update_option( 'site_logo', $logo );
	set_theme_mod( 'custom_logo', $logo );
	update_option( 'site_icon', $logo );
}

// ---------------------------------------------------------------- 6. tidy.

WP_CLI::log( '==> Tidying WordPress defaults' );

foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
	$found = get_posts(
		array(
			'name'           => $slug,
			'post_type'      => $type,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $found ) {
		wp_delete_post( (int) $found[0], true );
		WP_CLI::log( "    deleted default {$type}: {$slug}" );
	}
}

// The default "A WordPress Commenter" comment, and any other stragglers.
foreach ( get_comments( array( 'status' => 'all' ) ) as $comment ) {
	wp_delete_comment( (int) $comment->comment_ID, true );
}

// Drafted privacy policy page ships with core and is not part of the demo.
$privacy = (int) get_option( 'wp_page_for_privacy_policy' );
if ( $privacy && 'draft' === get_post_status( $privacy ) ) {
	wp_delete_post( $privacy, true );
	update_option( 'wp_page_for_privacy_policy', 0 );
}

WP_CLI::success(
	sprintf(
		'%d spas, %d pages, %d journal posts, %d menu items.',
		count( $spa_ids ),
		count( $page_ids ),
		count( $posts ),
		12
	)
);
