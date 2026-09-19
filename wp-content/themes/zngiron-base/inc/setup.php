<?php
/**
 * Theme supports and head tidying.
 *
 * REBRANDING: nothing here names a client. Brand data lives in config/brand.json
 * (read by the zngiron-blocks plugin); design tokens live in theme.json.
 *
 * @package Zngiron\Theme
 */

declare( strict_types = 1 );

namespace Zngiron\Theme\Setup;

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports. A block theme gets most of this for free; the rest is
 * written out so the list is readable.
 */
function after_setup_theme(): void {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'custom-logo', array( 'height' => 96, 'width' => 320, 'flex-width' => true, 'flex-height' => true ) );
    add_theme_support( 'automatic-feed-links' );

    load_theme_textdomain( 'zngiron-base', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\after_setup_theme' );

/**
 * Remove head output the design does not use.
 *
 * The emoji polyfill is the expensive one: twemoji, its loader and the blob it
 * builds are roughly 17 KB of JavaScript on every request, to draw glyphs every
 * supported browser already draws. Nothing here uses them.
 */
function tidy_head(): void {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', __NAMESPACE__ . '\\tidy_head' );

/**
 * A favicon for sites that have not set a site icon yet.
 */
function fallback_site_icon(): void {
    if ( has_site_icon() ) {
        return;
    }

    printf(
        '<link rel="icon" href="%s" sizes="any">' . "\n",
        esc_url( get_theme_file_uri( 'assets/images/favicon.ico' ) )
    );
}
add_action( 'wp_head', __NAMESPACE__ . '\\fallback_site_icon' );
