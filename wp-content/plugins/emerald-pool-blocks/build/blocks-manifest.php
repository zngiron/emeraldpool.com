<?php
// This file is generated. Do not modify it manually.
return array(
	'faq-accordion' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/faq-accordion',
		'title' => 'FAQ accordion',
		'category' => 'emerald-pool',
		'icon' => 'editor-help',
		'description' => 'A list of questions built from core Details blocks, so the open and close behaviour is the browser\'s own. Emits FAQPage structured data for the questions it contains.',
		'keywords' => array(
			'faq',
			'questions',
			'accordion',
			'details'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'emitSchema' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide'
			),
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'interactivity' => array(
				'clientNavigation' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'Common questions'
			),
			'innerBlocks' => array(
				array(
					'name' => 'core/details',
					'attributes' => array(
						'summary' => 'How much electrical work does a hot tub need?'
					),
					'innerBlocks' => array(
						array(
							'name' => 'core/paragraph',
							'attributes' => array(
								'content' => 'Most models need a dedicated 50 amp GFCI circuit. We can recommend an electrician in Eugene or Bend.'
							)
						)
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'feature-grid' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/feature-grid',
		'title' => 'Feature grid',
		'category' => 'emerald-pool',
		'icon' => 'screenoptions',
		'description' => 'A row of short value propositions, each with one line icon. Holds Feature blocks and nothing else.',
		'keywords' => array(
			'features',
			'benefits',
			'icons',
			'value'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'columns' => array(
				'type' => 'number',
				'default' => 3
			),
			'iconStyle' => array(
				'type' => 'string',
				'enum' => array(
					'plain',
					'badge'
				),
				'default' => 'badge'
			)
		),
		'providesContext' => array(
			'emerald-pool/iconStyle' => 'iconStyle'
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				),
				'blockGap' => true
			),
			'color' => array(
				'background' => true,
				'text' => true
			),
			'interactivity' => array(
				'clientNavigation' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'columns' => 3
			),
			'innerBlocks' => array(
				array(
					'name' => 'emerald-pool/icon-feature',
					'attributes' => array(
						'icon' => 'droplet',
						'title' => 'Water care that takes ten minutes a week'
					)
				),
				array(
					'name' => 'emerald-pool/icon-feature',
					'attributes' => array(
						'icon' => 'leaf',
						'title' => 'Insulated for Oregon winters'
					)
				),
				array(
					'name' => 'emerald-pool/icon-feature',
					'attributes' => array(
						'icon' => 'wrench',
						'title' => 'Our own service team, not a subcontractor'
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'icon-feature' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/icon-feature',
		'title' => 'Feature',
		'category' => 'emerald-pool',
		'icon' => 'yes-alt',
		'parent' => array(
			'emerald-pool/feature-grid'
		),
		'description' => 'One value proposition: an icon, a short title and a sentence.',
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'icon' => array(
				'type' => 'string',
				'default' => 'droplet'
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'text' => array(
				'type' => 'string',
				'default' => ''
			),
			'linkUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'linkText' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'usesContext' => array(
			'emerald-pool/iconStyle'
		),
		'supports' => array(
			'anchor' => true,
			'html' => false,
			'reusable' => false,
			'interactivity' => array(
				'clientNavigation' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'icon' => 'droplet',
				'title' => 'Water care in ten minutes a week',
				'text' => 'We set up your chemistry on delivery and test your water free, for as long as you own the spa.'
			)
		),
		'editorScript' => array(
			'file:./index.js',
			'emerald-pool-icons'
		),
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'spa-comparison' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/spa-comparison',
		'title' => 'Spa comparison',
		'category' => 'emerald-pool',
		'icon' => 'columns',
		'description' => 'Puts two or three spas side by side in one table so a shopper can see the difference without opening tabs.',
		'keywords' => array(
			'compare',
			'comparison',
			'table',
			'spa'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'postIds' => array(
				'type' => 'array',
				'default' => array(
					
				),
				'items' => array(
					'type' => 'number'
				)
			),
			'showImages' => array(
				'type' => 'boolean',
				'default' => true
			),
			'caption' => array(
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
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'interactivity' => array(
				'clientNavigation' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'postIds' => array(
					
				),
				'showImages' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => array(
			'file:./style-index.css',
			'emerald-pool-shared'
		),
		'render' => 'file:./render.php'
	),
	'spa-grid' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/spa-grid',
		'title' => 'Spa grid',
		'category' => 'emerald-pool',
		'icon' => 'grid-view',
		'description' => 'A server-rendered grid of spas from the catalogue, filtered by type and series. Optional chips let a visitor narrow the grid without a page reload.',
		'keywords' => array(
			'spa',
			'products',
			'hot tub',
			'grid',
			'catalogue'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'spaType' => array(
				'type' => 'string',
				'default' => ''
			),
			'series' => array(
				'type' => 'string',
				'default' => ''
			),
			'numberOfItems' => array(
				'type' => 'number',
				'default' => 6
			),
			'columns' => array(
				'type' => 'number',
				'default' => 3
			),
			'orderBy' => array(
				'type' => 'string',
				'enum' => array(
					'menu_order',
					'title',
					'date'
				),
				'default' => 'menu_order'
			),
			'showFilters' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showPrice' => array(
				'type' => 'boolean',
				'default' => true
			),
			'excludeCurrent' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'usesContext' => array(
			'postId'
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
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
				'numberOfItems' => 3,
				'columns' => 3,
				'showFilters' => false
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => array(
			'file:./style-index.css',
			'emerald-pool-shared'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'spa-hero' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/spa-hero',
		'title' => 'Hero',
		'category' => 'emerald-pool',
		'icon' => 'cover-image',
		'description' => 'A full-viewport opening statement: background image or muted video, scrim, eyebrow, heading, standfirst, buttons, and a utility row pinned to the bottom of the frame.',
		'keywords' => array(
			'hero',
			'banner',
			'header',
			'cover'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'eyebrow' => array(
				'type' => 'string',
				'default' => ''
			),
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'standfirst' => array(
				'type' => 'string',
				'default' => ''
			),
			'headingLevel' => array(
				'type' => 'number',
				'default' => 1
			),
			'mediaId' => array(
				'type' => 'number'
			),
			'mediaUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'mediaAlt' => array(
				'type' => 'string',
				'default' => ''
			),
			'focalPoint' => array(
				'type' => 'object',
				'default' => array(
					'x' => 0.5,
					'y' => 0.5
				)
			),
			'overlayOpacity' => array(
				'type' => 'number',
				'default' => 62
			),
			'minHeight' => array(
				'type' => 'number',
				'default' => 92
			),
			'contentAlign' => array(
				'type' => 'string',
				'enum' => array(
					'left',
					'center'
				),
				'default' => 'left'
			),
			'videoUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'metaHeading' => array(
				'type' => 'string',
				'default' => ''
			),
			'metaBody' => array(
				'type' => 'string',
				'default' => ''
			),
			'showScrollCue' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'interactivity' => array(
				'clientNavigation' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'eyebrow' => 'Eugene &amp; Bend, Oregon',
				'heading' => 'Warm water is a winter plan',
				'standfirst' => 'Three generations of getting Oregon backyards right.',
				'metaHeading' => 'Two showrooms',
				'metaBody' => 'Eugene · Mon–Sat 9–6
Bend · Mon–Fri 9–6',
				'overlayOpacity' => 62,
				'minHeight' => 40
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'spa-plan' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/spa-plan',
		'title' => 'Spa plan view',
		'category' => 'emerald-pool',
		'icon' => 'layout',
		'description' => 'The current spa\'s render on its paper field, with the dimension annotation and, where the model has one, the clip that plays on hover.',
		'keywords' => array(
			'spa',
			'image',
			'plan',
			'render',
			'hero'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'showDimensions' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showScale' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'usesContext' => array(
			'postId'
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
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
				'showDimensions' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => array(
			'file:./style-index.css',
			'emerald-pool-shared'
		),
		'render' => 'file:./render.php'
	),
	'spa-specs' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/spa-specs',
		'title' => 'Spa specifications',
		'category' => 'emerald-pool',
		'icon' => 'editor-table',
		'description' => 'Prints the specification meta of the spa being viewed as a grouped description list. Reads the fields registered by this plugin, so no spec is ever pasted into the editor by hand.',
		'keywords' => array(
			'specs',
			'specification',
			'table',
			'dimensions'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'showGroupHeadings' => array(
				'type' => 'boolean',
				'default' => true
			),
			'columns' => array(
				'type' => 'number',
				'default' => 2
			)
		),
		'usesContext' => array(
			'postId',
			'postType'
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide'
			),
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'interactivity' => array(
				'clientNavigation' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'heading' => 'Specifications'
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => array(
			'file:./style-index.css',
			'emerald-pool-shared'
		),
		'render' => 'file:./render.php'
	),
	'spa-stats' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/spa-stats',
		'title' => 'Stat column',
		'category' => 'emerald-pool',
		'icon' => 'chart-bar',
		'description' => 'Four figures about the business, held against a sticky heading as they scroll past. Each number counts up once, the first time it is seen.',
		'keywords' => array(
			'stats',
			'numbers',
			'figures',
			'about'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'standfirst' => array(
				'type' => 'string',
				'default' => ''
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				),
				'items' => array(
					'type' => 'object'
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
						'format' => 'plain'
					),
					array(
						'value' => 2,
						'label' => 'Showrooms, both with water in them'
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
		'editorStyle' => 'file:./index.css',
		'style' => array(
			'file:./style-index.css',
			'emerald-pool-shared'
		),
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'store-locator-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/store-locator-card',
		'title' => 'Store cards',
		'category' => 'emerald-pool',
		'icon' => 'store',
		'description' => 'The shops: address, opening hours, a tap-to-call number and a link to the map. Reads one configured list, so a change of hours is one edit for the whole site.',
		'keywords' => array(
			'store',
			'location',
			'address',
			'hours',
			'contact'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'location' => array(
				'type' => 'string',
				'default' => ''
			),
			'showHours' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showMapLink' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showNote' => array(
				'type' => 'boolean',
				'default' => true
			),
			'headingLevel' => array(
				'type' => 'number',
				'default' => 3
			),
			'layout' => array(
				'type' => 'string',
				'enum' => array(
					'cards',
					'inline'
				),
				'default' => 'cards'
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'color' => array(
				'background' => true,
				'text' => true
			),
			'interactivity' => array(
				'clientNavigation' => true
			)
		),
		'example' => array(
			'attributes' => array(
				'layout' => 'cards'
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => array(
			'file:./style-index.css',
			'emerald-pool-shared'
		),
		'render' => 'file:./render.php'
	),
	'testimonial-slider' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'emerald-pool/testimonial-slider',
		'title' => 'Testimonial slider',
		'category' => 'emerald-pool',
		'icon' => 'format-quote',
		'description' => 'Customer quotes, one at a time, moved by the reader. No autoplay: nothing moves unless someone asks it to.',
		'keywords' => array(
			'testimonial',
			'review',
			'quote',
			'carousel',
			'slider'
		),
		'textdomain' => 'emerald-pool-blocks',
		'attributes' => array(
			'label' => array(
				'type' => 'string',
				'default' => 'What customers say'
			)
		),
		'supports' => array(
			'anchor' => true,
			'align' => array(
				'wide',
				'full'
			),
			'html' => false,
			'spacing' => array(
				'padding' => true,
				'margin' => array(
					'top',
					'bottom'
				)
			),
			'color' => array(
				'background' => true,
				'text' => true
			),
			'interactivity' => true
		),
		'example' => array(
			'innerBlocks' => array(
				array(
					'name' => 'core/quote',
					'attributes' => array(
						'className' => 'is-style-testimonial',
						'value' => '<p>They delivered on a Tuesday and had us in the water by Friday.</p>',
						'citation' => 'Dana R., Eugene'
					)
				)
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	)
);
