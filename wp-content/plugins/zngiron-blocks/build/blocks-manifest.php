<?php
// This file is generated. Do not modify it manually.
return array(
	'card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/card',
		'title' => 'Card',
		'category' => 'zngiron',
		'icon' => 'index-card',
		'parent' => array(
			'zngiron/card-grid'
		),
		'description' => 'One card: Frame, title, text and an optional link. Lives inside a Card Grid.',
		'keywords' => array(
			'card',
			'feature'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'linkText' => array(
				'type' => 'string',
				'default' => ''
			),
			'frame' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'title' => 'Delivery',
				'text' => 'Craned in, levelled and filled, by the crew that does it every day.',
				'linkText' => 'How it works',
				'url' => '#'
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css',
			'zngiron-frame'
		),
		'render' => 'file:./render.php'
	),
	'card-grid' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/card-grid',
		'title' => 'Card Grid',
		'category' => 'zngiron',
		'icon' => 'grid-view',
		'description' => 'Two to four equal-height Cards on a CSS grid. The container of the Card block.',
		'keywords' => array(
			'grid',
			'cards',
			'features'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'columns' => array(
				'type' => 'number',
				'default' => 3
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'columns' => 3
			),
			'innerBlocks' => array(
				array(
					'name' => 'zngiron/card',
					'attributes' => array(
						'title' => 'Delivery',
						'text' => 'Craned in, levelled and filled.'
					)
				),
				array(
					'name' => 'zngiron/card',
					'attributes' => array(
						'title' => 'Service',
						'text' => 'Our own technicians, our own parts.'
					)
				),
				array(
					'name' => 'zngiron/card',
					'attributes' => array(
						'title' => 'Water care',
						'text' => 'Chemistry sorted on a schedule.'
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css',
			'zngiron-frame'
		),
		'render' => 'file:./render.php'
	),
	'compare-table' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/compare-table',
		'title' => 'Compare Table',
		'category' => 'zngiron',
		'icon' => 'columns',
		'description' => 'Two or three posts side by side over the meta fields flagged for comparison in config/brand.json.',
		'keywords' => array(
			'compare',
			'table',
			'specs'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'postIds' => array(
				'type' => 'array',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'Side by side'
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'faq' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/faq',
		'title' => 'FAQ',
		'category' => 'zngiron',
		'icon' => 'editor-help',
		'description' => 'Questions and answers as native disclosure elements, with FAQPage structured data emitted alongside.',
		'keywords' => array(
			'faq',
			'questions',
			'accordion'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'Questions we get asked',
				'items' => array(
					array(
						'question' => 'How long does delivery take?',
						'answer' => 'Two to four weeks for a stocked model.'
					),
					array(
						'question' => 'Do you service what you sell?',
						'answer' => 'Yes — our own technicians, our own parts.'
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'hero' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/hero',
		'title' => 'Hero',
		'category' => 'zngiron',
		'icon' => 'cover-image',
		'description' => 'A full-bleed opening section: a Frame behind a fixed copy column, with a scrim so the words stay legible on any photograph.',
		'keywords' => array(
			'hero',
			'banner',
			'cover'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => ''
			),
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'meta' => array(
				'type' => 'string',
				'default' => ''
			),
			'height' => array(
				'type' => 'string',
				'default' => 'tall'
			),
			'buttons' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'frame' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => false
			),
			'spacing' => array(
				'padding' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'eyebrow' => 'Since 1955',
				'heading' => 'Warm water, two showrooms, one long habit of doing it properly.',
				'text' => 'Hot tubs and swim spas chosen with you, delivered by the people who service them.',
				'height' => 'tall',
				'buttons' => array(
					array(
						'text' => 'See the range',
						'url' => '#',
						'style' => 'primary'
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => array(
			'file:./style-index.css',
			'zngiron-frame'
		),
		'render' => 'file:./render.php'
	),
	'locations' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/locations',
		'title' => 'Locations',
		'category' => 'zngiron',
		'icon' => 'location',
		'description' => 'Address cards built from the locations in config/brand.json, each with a phone link and directions.',
		'keywords' => array(
			'locations',
			'stores',
			'address',
			'contact'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'slugs' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'showHours' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'Two showrooms'
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'marquee' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/marquee',
		'title' => 'Marquee',
		'category' => 'zngiron',
		'icon' => 'controls-repeat',
		'description' => 'A line of words looping sideways in CSS. Pauses on hover and stands still under reduced motion.',
		'keywords' => array(
			'marquee',
			'ticker',
			'loop'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'speed' => array(
				'type' => 'number',
				'default' => 30
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'text' => 'Delivery · Service · Water care · Parts · Trade-in',
				'speed' => 30
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'media-text' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/media-text',
		'title' => 'Media Text',
		'category' => 'zngiron',
		'icon' => 'align-pull-left',
		'description' => 'A Frame beside a column of copy. The ratio and the side both switch; the two columns stay equal height.',
		'keywords' => array(
			'media',
			'text',
			'split'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => ''
			),
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'mediaSide' => array(
				'type' => 'string',
				'default' => 'left'
			),
			'buttons' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'frame' => array(
				'type' => 'object',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'eyebrow' => 'Service',
				'heading' => 'The people who sold it are the people who fix it.',
				'text' => 'Our own technicians cover the whole valley, and they carry the parts for what we sell.',
				'mediaSide' => 'left'
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css',
			'zngiron-frame'
		),
		'render' => 'file:./render.php'
	),
	'post-grid' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/post-grid',
		'title' => 'Post Grid',
		'category' => 'zngiron',
		'icon' => 'screenoptions',
		'description' => 'A query over any post type, rendered as Cards, with optional filter chips that narrow the grid in the browser.',
		'keywords' => array(
			'query',
			'posts',
			'loop',
			'grid'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'postType' => array(
				'type' => 'string',
				'default' => ''
			),
			'taxonomy' => array(
				'type' => 'string',
				'default' => ''
			),
			'term' => array(
				'type' => 'string',
				'default' => ''
			),
			'count' => array(
				'type' => 'number',
				'default' => 6
			),
			'columns' => array(
				'type' => 'number',
				'default' => 3
			),
			'orderBy' => array(
				'type' => 'string',
				'default' => 'menu_order'
			),
			'order' => array(
				'type' => 'string',
				'default' => 'ASC'
			),
			'showFilters' => array(
				'type' => 'boolean',
				'default' => false
			),
			'filterTaxonomy' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'interactivity' => true
		),
		'example' => array(
			'attributes' => array(
				'count' => 3,
				'columns' => 3
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css',
			'zngiron-frame'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'specs-table' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/specs-table',
		'title' => 'Specs Table',
		'category' => 'zngiron',
		'icon' => 'editor-table',
		'description' => 'Key and value rows built from the meta fields declared in config/brand.json for the post being viewed.',
		'keywords' => array(
			'specs',
			'specifications',
			'table',
			'meta'
		),
		'textdomain' => 'zngiron-blocks',
		'usesContext' => array(
			'postId',
			'postType'
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'postId' => array(
				'type' => 'number',
				'default' => 0
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'Specifications'
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'stats' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/stats',
		'title' => 'Stats',
		'category' => 'zngiron',
		'icon' => 'chart-bar',
		'description' => 'A row of figures with labels. Each number counts up once, the first time it is seen.',
		'keywords' => array(
			'stats',
			'numbers',
			'figures'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'interactivity' => true
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'Seventy years of the same job',
				'items' => array(
					array(
						'value' => 1955,
						'label' => 'Trading since',
						'plain' => true
					),
					array(
						'value' => 2,
						'label' => 'Showrooms'
					),
					array(
						'value' => 11000,
						'label' => 'Spas delivered',
						'prefix' => 'over '
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'testimonials' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'zngiron/testimonials',
		'title' => 'Testimonials',
		'category' => 'zngiron',
		'icon' => 'format-quote',
		'description' => 'Quotes shown one at a time, moved by previous and next. No autoplay: a quote only moves when a person moves it.',
		'keywords' => array(
			'testimonials',
			'quotes',
			'reviews'
		),
		'textdomain' => 'zngiron-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true
			),
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'interactivity' => true
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'What people say',
				'items' => array(
					array(
						'quote' => 'They levelled the pad, craned it over the fence and had it warm by the evening.',
						'name' => 'Dana R.',
						'role' => 'Eugene'
					),
					array(
						'quote' => 'Seven years in and the same technician still turns up.',
						'name' => 'Marcus T.',
						'role' => 'Bend'
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	)
);
