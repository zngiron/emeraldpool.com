<?php
/**
 * Stylesheet and script loading.
 *
 * House rules: theme.json expresses everything it can; CSS covers only what it
 * cannot. Two stylesheets ship — tokens.css (preset aliases the blocks read) and
 * layout.css (section, header, footer, reveal) — and one deferred script.
 *
 * @package Zngiron\Theme
 */

declare( strict_types = 1 );

namespace Zngiron\Theme\Assets;

use const Zngiron\Theme\VERSION;

defined( 'ABSPATH' ) || exit;

/**
 * Both stylesheets, front end and editor canvas.
 *
 * @return string[]
 */
function stylesheets(): array {
    return array( 'tokens', 'layout' );
}

/**
 * Front-end styles.
 */
function enqueue_styles(): void {
    foreach ( stylesheets() as $name ) {
        wp_enqueue_style(
            'zngiron-' . $name,
            get_theme_file_uri( "assets/css/{$name}.css" ),
            array(),
            VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles' );

/**
 * The theme's only front-end script: header state and the reveal.
 *
 * Deferred, dependency-free and entirely an enhancement. With it blocked the
 * header is its solid default and every element is visible.
 */
function enqueue_script(): void {
    wp_enqueue_script(
        'zngiron-view',
        get_theme_file_uri( 'assets/js/view.js' ),
        array(),
        VERSION,
        array(
            'strategy'  => 'defer',
            'in_footer' => true,
        )
    );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_script' );

/**
 * The editor canvas gets the same rules as the front end.
 */
function editor_styles(): void {
    foreach ( stylesheets() as $name ) {
        add_editor_style( "assets/css/{$name}.css" );
    }
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\editor_styles' );

/**
 * Preload the three self-hosted variable fonts: the only blocking assets on the
 * critical path, all subset to latin.
 */
function preload_fonts(): void {
    foreach ( array( 'fraunces-latin-var', 'karla-latin-var', 'jetbrains-mono-latin-var' ) as $font ) {
        printf(
            '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
            esc_url( get_theme_file_uri( "assets/fonts/{$font}.woff2" ) )
        );
    }
}
add_action( 'wp_head', __NAMESPACE__ . '\\preload_fonts', 1 );
