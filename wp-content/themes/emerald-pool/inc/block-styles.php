<?php
/**
 * Block style variations for core blocks.
 *
 * Preferred over bespoke utility classes: an editor can pick these from the
 * Styles panel, they are namespaced per block, and their CSS ships only when the
 * block is rendered (WordPress inlines `inline_style` with the block).
 *
 * The recurring device is the "waterline": a 2px primary rule with a 1px accent
 * rule offset beneath it. It marks section starts and dividers, and it is the one
 * ornament the design allows itself.
 *
 * @package EmeraldPool\Theme
 */

declare( strict_types = 1 );

namespace EmeraldPool\Theme\BlockStyles;

defined( 'ABSPATH' ) || exit;

/**
 * Definitions, kept as data so the registration loop stays trivial.
 *
 * @return array<int, array{block:string, name:string, label:string, style:string, default?:bool}>
 */
function definitions(): array {
	return array(
		array(
			'block' => 'core/heading',
			'name'  => 'eyebrow',
			'label' => __( 'Eyebrow', 'emerald-pool' ),
			'style' => '.is-style-eyebrow:not(.has-text-color){color:var(--wp--preset--color--primary)}
.is-style-eyebrow{font-family:var(--wp--preset--font-family--body);font-size:var(--wp--custom--eyebrow--size);font-weight:700;letter-spacing:var(--wp--custom--eyebrow--spacing);text-transform:uppercase;display:flex;align-items:center;gap:.75rem;line-height:1.3}
.is-style-eyebrow::before{content:"";flex:0 0 2.25rem;height:3px;border-top:2px solid currentColor;border-bottom:1px solid var(--wp--preset--color--accent);padding-top:2px}',
		),
		array(
			'block' => 'core/separator',
			'name'  => 'waterline',
			'label' => __( 'Waterline', 'emerald-pool' ),
			'style' => '.wp-block-separator.is-style-waterline{border:0;height:3px;background:none;border-top:2px solid var(--wp--preset--color--primary);border-bottom:1px solid var(--wp--preset--color--accent);padding-top:3px;opacity:1;max-width:5rem}
.wp-block-separator.is-style-waterline.alignwide,.wp-block-separator.is-style-waterline.alignfull{max-width:none}',
		),
		array(
			'block' => 'core/button',
			'name'  => 'outline-quiet',
			'label' => __( 'Outline', 'emerald-pool' ),
			'style' => '.wp-block-button.is-style-outline-quiet .wp-block-button__link{background:transparent;color:var(--wp--preset--color--primary-dark);box-shadow:inset 0 0 0 1px var(--wp--preset--color--primary);transition:background var(--wp--custom--transition--base),color var(--wp--custom--transition--base)}
.wp-block-button.is-style-outline-quiet .wp-block-button__link:hover,.wp-block-button.is-style-outline-quiet .wp-block-button__link:focus{background:var(--wp--preset--color--primary);color:var(--wp--preset--color--base)}',
		),
		array(
			'block' => 'core/button',
			'name'  => 'link-arrow',
			'label' => __( 'Text link with arrow', 'emerald-pool' ),
			'style' => '.wp-block-button.is-style-link-arrow .wp-block-button__link{background:transparent;color:var(--wp--preset--color--primary);padding:.35rem 0;border-radius:0;box-shadow:none;border-bottom:1px solid var(--wp--preset--color--border)}
.wp-block-button.is-style-link-arrow .wp-block-button__link::after{content:" \2192";transition:transform var(--wp--custom--transition--base);display:inline-block}
.wp-block-button.is-style-link-arrow .wp-block-button__link:hover{color:var(--wp--preset--color--primary-dark);border-bottom-color:var(--wp--preset--color--primary)}
.wp-block-button.is-style-link-arrow .wp-block-button__link:hover::after{transform:translateX(.25rem)}',
		),
		array(
			'block' => 'core/group',
			'name'  => 'card',
			'label' => __( 'Card', 'emerald-pool' ),
			'style' => '.wp-block-group.is-style-card{background:var(--wp--preset--color--base);border:1px solid var(--wp--preset--color--border);border-radius:var(--wp--custom--radius--md);padding:var(--wp--preset--spacing--30);box-shadow:var(--wp--custom--shadow--soft)}',
		),
		array(
			'block' => 'core/group',
			'name'  => 'rule-top',
			'label' => __( 'Waterline top', 'emerald-pool' ),
			'style' => '.wp-block-group.is-style-rule-top{border-top:2px solid var(--wp--preset--color--primary);padding-top:var(--wp--preset--spacing--20);position:relative}
.wp-block-group.is-style-rule-top::before{content:"";position:absolute;inset:3px auto auto 0;width:100%;height:1px;background:var(--wp--preset--color--accent)}',
		),
		array(
			'block' => 'core/columns',
			'name'  => 'card-group',
			'label' => __( 'Card group', 'emerald-pool' ),
			'style' => '.wp-block-columns.is-style-card-group > .wp-block-column{background:var(--wp--preset--color--base);border:1px solid var(--wp--preset--color--border);border-radius:var(--wp--custom--radius--md);padding:var(--wp--preset--spacing--30);box-shadow:var(--wp--custom--shadow--soft)}',
		),
		array(
			'block' => 'core/image',
			'name'  => 'soft',
			'label' => __( 'Soft corners', 'emerald-pool' ),
			'style' => '.wp-block-image.is-style-soft img{border-radius:var(--wp--custom--radius--lg);box-shadow:var(--wp--custom--shadow--lift)}',
		),
		array(
			'block' => 'core/list',
			'name'  => 'ticks',
			'label' => __( 'Tick list', 'emerald-pool' ),
			'style' => '.wp-block-list.is-style-ticks{list-style:none;padding-left:0}
.wp-block-list.is-style-ticks li{position:relative;padding-left:1.9rem;margin-bottom:.6rem}
.wp-block-list.is-style-ticks li::before{content:"";position:absolute;left:0;top:.45em;width:.85rem;height:.45rem;border-left:2px solid var(--wp--preset--color--accent);border-bottom:2px solid var(--wp--preset--color--accent);transform:rotate(-45deg)}',
		),
		array(
			'block' => 'core/quote',
			'name'  => 'testimonial',
			'label' => __( 'Testimonial', 'emerald-pool' ),
			'style' => '.wp-block-quote.is-style-testimonial{border:0;padding:0}
.wp-block-quote.is-style-testimonial p{font-family:var(--wp--preset--font-family--display);font-size:var(--wp--preset--font-size--large);line-height:1.34}
.wp-block-quote.is-style-testimonial cite{display:block;margin-top:var(--wp--preset--spacing--20);font-family:var(--wp--preset--font-family--body);font-size:var(--wp--preset--font-size--small);font-style:normal;font-weight:700;letter-spacing:var(--wp--custom--eyebrow--spacing);text-transform:uppercase;color:var(--wp--preset--color--text-muted)}',
		),
	);
}

/**
 * Register everything in definitions().
 */
function register(): void {
	foreach ( definitions() as $style ) {
		register_block_style(
			$style['block'],
			array(
				'name'         => $style['name'],
				'label'        => $style['label'],
				'inline_style' => $style['style'],
				'is_default'   => $style['default'] ?? false,
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\\register' );
