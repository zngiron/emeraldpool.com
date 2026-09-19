<?php
/**
 * Block style variations for core blocks.
 *
 * Preferred over bespoke utility classes: an editor can pick these from the
 * Styles panel, they are namespaced per block, and their CSS ships only when the
 * block is rendered (WordPress inlines `inline_style` with the block).
 *
 * The recurring device is no longer a border. Boxes were what made the first
 * build read as a widget grid, so the card and card-group styles are gone. What
 * replaces them is a hairline and a single ember dot: sections are marked by a
 * rule and a point of heat, and product imagery is framed by its own edges
 * rather than by a rounded container.
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
			'style' => '.is-style-eyebrow:not(.has-text-color){color:var(--wp--preset--color--text-muted)}
.is-style-eyebrow{font-family:var(--wp--preset--font-family--data);font-size:var(--wp--custom--eyebrow--size);font-weight:500;letter-spacing:var(--wp--custom--eyebrow--spacing);text-transform:uppercase;display:flex;align-items:center;gap:.7rem;line-height:1.3;margin-bottom:var(--wp--preset--spacing--20)}
.is-style-eyebrow::before{content:"";flex:0 0 .4rem;width:.4rem;height:.4rem;border-radius:50%;background:var(--wp--preset--color--ember)}',
		),
		array(
			'block' => 'core/heading',
			'name'  => 'statement',
			'label' => __( 'Statement', 'emerald-pool' ),
			'style' => '.wp-block-heading.is-style-statement{font-size:var(--wp--preset--font-size--display);font-weight:300;line-height:.9;letter-spacing:-.04em;font-variation-settings:"SOFT" 40,"WONK" 1,"opsz" 144;max-width:16ch;text-wrap:balance}',
		),
		array(
			'block' => 'core/separator',
			'name'  => 'waterline',
			'label' => __( 'Waterline', 'emerald-pool' ),
			'style' => '.wp-block-separator.is-style-waterline{border:0;height:auto;background:none;border-top:1px solid var(--wp--preset--color--border);opacity:1;max-width:none;position:relative;margin-block:var(--wp--preset--spacing--40)}
.wp-block-separator.is-style-waterline::after{content:"";position:absolute;top:-.2rem;left:0;width:.4rem;height:.4rem;border-radius:50%;background:var(--wp--preset--color--ember)}
.ep-night .wp-block-separator.is-style-waterline{border-top-color:rgba(233,226,212,.18)}',
		),
		array(
			'block' => 'core/button',
			'name'  => 'outline-quiet',
			'label' => __( 'Outline', 'emerald-pool' ),
			'style' => '.wp-block-button.is-style-outline-quiet .wp-block-button__link{background:transparent;color:var(--wp--preset--color--primary-dark);box-shadow:inset 0 0 0 1px var(--wp--preset--color--primary-dark);position:relative;overflow:hidden;z-index:0;transition:color var(--wp--custom--transition--base)}
.wp-block-button.is-style-outline-quiet .wp-block-button__link::before{content:"";position:absolute;inset:0;z-index:-1;background:var(--wp--preset--color--ember);transform:scaleY(0);transform-origin:bottom;transition:transform var(--wp--custom--transition--base)}
.wp-block-button.is-style-outline-quiet .wp-block-button__link:hover,.wp-block-button.is-style-outline-quiet .wp-block-button__link:focus{background:transparent;color:var(--wp--preset--color--abyss)}
.wp-block-button.is-style-outline-quiet .wp-block-button__link:hover::before,.wp-block-button.is-style-outline-quiet .wp-block-button__link:focus::before{transform:scaleY(1)}',
		),
		array(
			'block' => 'core/button',
			'name'  => 'link-arrow',
			'label' => __( 'Text link with arrow', 'emerald-pool' ),
			'style' => '.wp-block-button.is-style-link-arrow .wp-block-button__link{background:transparent;color:inherit;padding:.5rem 0;border-radius:0;box-shadow:none;border-bottom:1px solid currentcolor;letter-spacing:.12em}
.wp-block-button.is-style-link-arrow .wp-block-button__link::after{content:" \2192";transition:transform var(--wp--custom--transition--base);display:inline-block;margin-left:.4rem}
.wp-block-button.is-style-link-arrow .wp-block-button__link:hover,.wp-block-button.is-style-link-arrow .wp-block-button__link:focus{background:transparent;color:var(--wp--preset--color--ember)}
.wp-block-button.is-style-link-arrow .wp-block-button__link:hover::after{transform:translateX(.35rem)}',
		),
		array(
			'block' => 'core/image',
			'name'  => 'frame',
			'label' => __( 'Full frame', 'emerald-pool' ),
			'style' => '.wp-block-image.is-style-frame img{border-radius:0;width:100%;display:block;object-fit:cover}
.wp-block-image.is-style-frame figcaption{font-family:var(--wp--preset--font-family--data);font-size:var(--wp--preset--font-size--small);text-transform:uppercase;letter-spacing:.08em;margin-top:var(--wp--preset--spacing--20)}',
		),
		array(
			'block' => 'core/image',
			'name'  => 'plan',
			'label' => __( 'Plan view', 'emerald-pool' ),
			'style' => '.wp-block-image.is-style-plan{position:relative;background:var(--wp--preset--color--sand);padding:var(--wp--preset--spacing--40);margin:0;box-shadow:0 24px 50px -20px rgba(0,0,0,.55)}
.wp-block-image.is-style-plan::before,.wp-block-image.is-style-plan::after{content:"";position:absolute;background:rgba(4,20,27,.14);pointer-events:none}
.wp-block-image.is-style-plan::before{inset:var(--wp--preset--spacing--20) auto var(--wp--preset--spacing--20) 50%;width:1px}
.wp-block-image.is-style-plan::after{inset:50% var(--wp--preset--spacing--20) auto var(--wp--preset--spacing--20);height:1px}
.wp-block-image.is-style-plan img{border-radius:0;position:relative;z-index:1;width:100%;display:block;object-fit:contain;aspect-ratio:4/3;mix-blend-mode:multiply}',
		),
		array(
			'block' => 'core/list',
			'name'  => 'ticks',
			'label' => __( 'Tick list', 'emerald-pool' ),
			'style' => '.wp-block-list.is-style-ticks{list-style:none;padding-left:0}
.wp-block-list.is-style-ticks li{position:relative;padding-left:1.4rem;margin-bottom:.55rem}
.wp-block-list.is-style-ticks li::before{content:"";position:absolute;left:0;top:.62em;width:.35rem;height:.35rem;border-radius:50%;background:var(--wp--preset--color--ember)}',
		),
		array(
			'block' => 'core/list',
			'name'  => 'index',
			'label' => __( 'Numbered index', 'emerald-pool' ),
			'style' => '.wp-block-list.is-style-index{list-style:none;padding-left:0;counter-reset:ep-index}
.wp-block-list.is-style-index li{counter-increment:ep-index;display:grid;grid-template-columns:3.5rem 1fr;gap:1rem;padding-block:var(--wp--preset--spacing--20);border-top:1px solid var(--wp--preset--color--border);margin:0}
.wp-block-list.is-style-index li::before{content:counter(ep-index,decimal-leading-zero);font-family:var(--wp--preset--font-family--data);font-size:var(--wp--custom--eyebrow--size);letter-spacing:.1em;color:var(--wp--preset--color--ember);padding-top:.35em}
.ep-night .wp-block-list.is-style-index li{border-top-color:rgba(233,226,212,.18)}',
		),
		array(
			'block' => 'core/quote',
			'name'  => 'testimonial',
			'label' => __( 'Testimonial', 'emerald-pool' ),
			'style' => '.wp-block-quote.is-style-testimonial{border:0;padding:0}
.wp-block-quote.is-style-testimonial p{font-family:var(--wp--preset--font-family--display);font-size:var(--wp--preset--font-size--x-large);font-weight:300;line-height:1.08;letter-spacing:-.03em;font-variation-settings:"SOFT" 30,"WONK" 1,"opsz" 96;max-width:20ch;text-wrap:balance}
.wp-block-quote.is-style-testimonial cite{display:block;margin-top:var(--wp--preset--spacing--30);font-family:var(--wp--preset--font-family--data);font-size:var(--wp--custom--eyebrow--size);font-style:normal;font-weight:500;letter-spacing:var(--wp--custom--eyebrow--spacing);text-transform:uppercase;color:var(--wp--preset--color--ember)}',
		),
		array(
			'block' => 'core/group',
			'name'  => 'night',
			'label' => __( 'Night', 'emerald-pool' ),
			'style' => '.wp-block-group.is-style-night{background-color:var(--wp--preset--color--abyss);color:var(--wp--preset--color--sand);position:relative;isolation:isolate}
.wp-block-group.is-style-night::after{content:"";position:absolute;inset:0;z-index:0;pointer-events:none;background-image:var(--wp--custom--grain);opacity:.05;mix-blend-mode:overlay}
.wp-block-group.is-style-night>*{position:relative;z-index:1}',
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
