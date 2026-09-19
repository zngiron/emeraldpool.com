<?php
/**
 * Block style variations for core blocks, held as data.
 *
 * Preferred over utility classes: an editor picks these from the Styles panel,
 * they are namespaced per block, and WordPress ships each one's CSS only on a
 * page that actually renders that block.
 *
 * Every rule here is written against the --z-* aliases in assets/css/tokens.css,
 * so a style behaves the same on a light ground and inside a .z-night section.
 *
 * @package Zngiron\Theme
 */

declare( strict_types = 1 );

namespace Zngiron\Theme\BlockStyles;

defined( 'ABSPATH' ) || exit;

/**
 * The definitions. Adding a style is adding one entry.
 *
 * @return array<int, array{block:string, name:string, label:string, style:string}>
 */
function definitions(): array {
    return array(
        array(
            'block' => 'core/heading',
            'name'  => 'eyebrow',
            'label' => __( 'Eyebrow', 'zngiron-base' ),
            'style' => '.wp-block-heading.is-style-eyebrow{font-family:var(--z-font-mono);font-size:var(--z-size-eyebrow);font-weight:500;letter-spacing:var(--wp--custom--eyebrow--spacing);text-transform:uppercase;line-height:1.3;display:flex;align-items:center;gap:.7rem;margin-block-end:var(--z-space-xs)}
.wp-block-heading.is-style-eyebrow:not(.has-text-color){color:var(--z-muted)}
.wp-block-heading.is-style-eyebrow::before{content:"";flex:0 0 .4rem;width:.4rem;height:.4rem;border-radius:50%;background:var(--z-accent)}',
        ),
        array(
            'block' => 'core/heading',
            'name'  => 'statement',
            'label' => __( 'Statement', 'zngiron-base' ),
            'style' => '.wp-block-heading.is-style-statement{font-size:var(--wp--preset--font-size--xx-large);font-weight:300;line-height:.96;letter-spacing:-.03em;font-variation-settings:"SOFT" 40,"WONK" 1,"opsz" 96;max-width:20ch;text-wrap:balance}',
        ),
        array(
            'block' => 'core/quote',
            'name'  => 'statement',
            'label' => __( 'Statement', 'zngiron-base' ),
            'style' => '.wp-block-quote.is-style-statement{border:0;padding:0}
.wp-block-quote.is-style-statement p{font-family:var(--z-font-display);font-size:var(--wp--preset--font-size--x-large);font-weight:300;line-height:1.08;letter-spacing:-.03em;max-width:22ch;text-wrap:balance}
.wp-block-quote.is-style-statement cite{display:block;margin-block-start:var(--z-space-s);font-family:var(--z-font-mono);font-size:var(--z-size-eyebrow);font-style:normal;letter-spacing:var(--wp--custom--eyebrow--spacing);text-transform:uppercase;color:var(--z-muted)}',
        ),
        array(
            'block' => 'core/separator',
            'name'  => 'waterline',
            'label' => __( 'Waterline', 'zngiron-base' ),
            'style' => '.wp-block-separator.is-style-waterline{border:0;height:auto;background:none;border-block-start:1px solid var(--z-rule);opacity:1;max-width:none;position:relative;margin-block:var(--z-space-m)}
.wp-block-separator.is-style-waterline::after{content:"";position:absolute;inset-block-start:-.2rem;inset-inline-start:0;width:.4rem;height:.4rem;border-radius:50%;background:var(--z-accent)}',
        ),
        array(
            'block' => 'core/list',
            'name'  => 'ticks',
            'label' => __( 'Tick list', 'zngiron-base' ),
            'style' => '.wp-block-list.is-style-ticks{list-style:none;padding-inline-start:0}
.wp-block-list.is-style-ticks li{position:relative;padding-inline-start:1.4rem;margin-block-end:.55rem}
.wp-block-list.is-style-ticks li::before{content:"";position:absolute;inset-inline-start:0;inset-block-start:.62em;width:.35rem;height:.35rem;border-radius:50%;background:var(--z-accent)}',
        ),
        array(
            'block' => 'core/list',
            'name'  => 'index',
            'label' => __( 'Numbered index', 'zngiron-base' ),
            'style' => '.wp-block-list.is-style-index{list-style:none;padding-inline-start:0;counter-reset:z-index}
.wp-block-list.is-style-index li{counter-increment:z-index;display:grid;grid-template-columns:3rem 1fr;gap:1rem;padding-block:var(--z-space-s);border-block-start:1px solid var(--z-rule);margin:0}
.wp-block-list.is-style-index li::before{content:counter(z-index,decimal-leading-zero);font-family:var(--z-font-mono);font-size:var(--z-size-eyebrow);letter-spacing:.1em;color:var(--z-accent);padding-block-start:.35em}',
        ),
        array(
            'block' => 'core/button',
            'name'  => 'quiet',
            'label' => __( 'Quiet outline', 'zngiron-base' ),
            'style' => '.wp-block-button.is-style-quiet .wp-block-button__link{background:transparent;color:currentColor;box-shadow:inset 0 0 0 1px currentColor;transition:background var(--wp--custom--transition),color var(--wp--custom--transition)}
.wp-block-button.is-style-quiet .wp-block-button__link:hover,.wp-block-button.is-style-quiet .wp-block-button__link:focus{background:var(--z-accent);color:var(--z-on-accent);box-shadow:inset 0 0 0 1px var(--z-accent)}',
        ),
        array(
            'block' => 'core/group',
            'name'  => 'night',
            'label' => __( 'Night', 'zngiron-base' ),
            'style' => '.wp-block-group.is-style-night{background-color:var(--wp--preset--color--abyss);color:var(--z-on-dark)}',
        ),
    );
}

/**
 * Register everything definitions() returns.
 */
function register(): void {
    foreach ( definitions() as $style ) {
        register_block_style(
            $style['block'],
            array(
                'name'         => $style['name'],
                'label'        => $style['label'],
                'inline_style' => $style['style'],
            )
        );
    }
}
add_action( 'init', __NAMESPACE__ . '\\register' );
