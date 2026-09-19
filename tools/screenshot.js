/*
 * Emerald Pool — viewport screenshots, at 1:1, with an audit at every stop.
 *
 * Full-page screenshots are deliberately not taken. Scaled down to fit a page
 * into one image they hid every defect that mattered: a pinned header whose
 * navigation had gone invisible, content stuck half faded, a hero an inch short
 * of the viewport, a button with its label clipped. A viewport shot is what a
 * visitor actually sees, so that is what this takes.
 *
 * usage:
 *   node tools/screenshot.js <outdir> [--widths=390,1440] [--pages=home,hot-tubs]
 *                                     [--offsets=0,1000] [--base=http://localhost:8080]
 *
 * The audit at each stop is the half that does not need a human: it fails the
 * run on a sideways scrollbar, on any animated element left part-faded in the
 * viewport, on header text that does not clear 4.5:1 against the header's own
 * ground, and on any element wider than the viewport.
 */
const path = require( 'path' );
const fs = require( 'fs' );

const PLAYWRIGHT = process.env.EP_PLAYWRIGHT ||
	'/Users/zngiron/Projects/mesafinakitchen.com/node_modules/playwright';
const EXEC = process.env.EP_CHROME ||
	'/Users/zngiron/Library/Caches/ms-playwright/chromium_headless_shell-1234/chrome-headless-shell-mac-arm64/chrome-headless-shell';

const { chromium } = require( PLAYWRIGHT );

/*
 * Six widths, because the defects are not the same at each: 390 is the phone,
 * 768 and 1024 are where the navigation has to decide whether it fits, 1440 is
 * `wideSize` exactly, and 1920/2560 are where a fixed-width layout starts to
 * float in the middle of a grey field and a hero image starts to pixelate.
 */
const WIDTHS = {
	390: 844,
	768: 1024,
	1024: 768,
	1440: 900,
	1920: 1080,
	2560: 1440,
};

const PAGES = {
	home: '/',
	'hot-tubs': '/hot-tubs/',
	spas: '/spas/',
	'spa-single': '/spas/bullfrog-a7d/',
	'swim-spas': '/swim-spas/',
	about: '/about/',
	services: '/services/',
	financing: '/financing/',
	faq: '/faq/',
	journal: '/journal/',
	contact: '/contact/',
};

const OFFSETS = [ 0, 1000, 2600, 5000 ];

/* --- The audit, run in the page ------------------------------------------ */

const audit = () => {
	const srgb = ( c ) => ( c <= 0.03928 ? c / 12.92 : Math.pow( ( c + 0.055 ) / 1.055, 2.4 ) );
	const lum = ( [ r, g, b ] ) => 0.2126 * srgb( r / 255 ) + 0.7152 * srgb( g / 255 ) + 0.0722 * srgb( b / 255 );
	const parse = ( s ) => {
		const m = /rgba?\(([^)]+)\)/.exec( s || '' );
		if ( ! m ) return null;
		const p = m[ 1 ].split( /[\s,\/]+/ ).filter( Boolean ).map( Number );
		return [ p[ 0 ], p[ 1 ], p[ 2 ], p.length > 3 ? p[ 3 ] : 1 ];
	};
	const over = ( fg, bg ) => {
		const a = fg[ 3 ];
		return [ 0, 1, 2 ].map( ( i ) => fg[ i ] * a + bg[ i ] * ( 1 - a ) );
	};
	/* The painted ground under an element: the first opaque background up the tree. */
	const ground = ( el ) => {
		let stack = [];
		for ( let n = el; n; n = n.parentElement ) {
			const c = parse( getComputedStyle( n ).backgroundColor );
			if ( ! c || c[ 3 ] === 0 ) continue;
			stack.push( c );
			if ( c[ 3 ] === 1 ) break;
		}
		let base = [ 255, 255, 255 ];
		for ( let i = stack.length - 1; i >= 0; i-- ) base = over( stack[ i ], base );
		return base;
	};
	const ratio = ( a, b ) => {
		const l1 = lum( a ), l2 = lum( b );
		return ( Math.max( l1, l2 ) + 0.05 ) / ( Math.min( l1, l2 ) + 0.05 );
	};
	const onScreen = ( el ) => {
		const b = el.getBoundingClientRect();
		return b.bottom > 0 && b.top < innerHeight && b.width > 0 && b.height > 0;
	};

	/* 1. Anything animated and on screen must be fully opaque at rest. */
	const faded = [];
	document.querySelectorAll(
		'.ep-reveal, .ep-card, .ep-numeral, .ep-chapter__body, .ep-band__inner, .is-style-eyebrow, .ep-hero__lede'
	).forEach( ( el ) => {
		if ( ! onScreen( el ) ) return;
		const s = getComputedStyle( el );
		if ( s.opacity !== '1' || ( s.filter !== 'none' && s.filter !== '' ) || s.visibility === 'hidden' ) {
			faded.push( `${ el.className }`.slice( 0, 44 ) + ` opacity=${ s.opacity }` );
		}
	} );

	/* 2. The header's own text, against the header's own ground. */
	const header = document.querySelector( '.ep-site-header' );
	const contrast = [];
	if ( header ) {
		header.querySelectorAll( 'a, button, .wp-block-site-title, p' ).forEach( ( el ) => {
			if ( ! el.textContent.trim() || ! onScreen( el ) ) return;
			if ( el.closest( '.wp-block-navigation__responsive-container' ) &&
				! el.closest( '.is-menu-open' ) &&
				getComputedStyle( el ).visibility === 'hidden' ) return;
			const b = el.getBoundingClientRect();
			if ( b.width < 2 || b.height < 2 ) return;
			const fg = parse( getComputedStyle( el ).color );
			if ( ! fg ) return;
			const r = ratio( over( fg, ground( el ) ), ground( el ) );
			if ( r < 4.5 ) {
				contrast.push( `${ el.textContent.trim().slice( 0, 22 ) } ${ r.toFixed( 2 ) }:1` );
			}
		} );
	}

	/* 3. Nothing sticks out sideways. */
	const wide = [];
	if ( document.documentElement.scrollWidth > document.documentElement.clientWidth ) {
		document.querySelectorAll( 'body *' ).forEach( ( el ) => {
			const b = el.getBoundingClientRect();
			if ( b.right > document.documentElement.clientWidth + 1 && b.width > 0 &&
				getComputedStyle( el ).position !== 'fixed' ) {
				wide.push( `${ el.tagName }.${ `${ el.className }`.slice( 0, 30 ) } right=${ Math.round( b.right ) }` );
			}
		} );
	}

	/* 4. A label that does not fit the box drawn for it. */
	const clipped = [];
	document.querySelectorAll( '.wp-block-button__link, .wp-element-button, .ep-header-phone a' ).forEach( ( el ) => {
		if ( ! onScreen( el ) ) return;
		if ( el.scrollWidth > el.clientWidth + 1 ) {
			clipped.push( `${ el.textContent.trim().slice( 0, 24 ) } ${ el.scrollWidth }>${ el.clientWidth }` );
		}
	} );

	/* 5. The navigation row: one line beside the mark, or the overlay button. */
	const nav = document.querySelector( '.ep-site-header .wp-block-navigation__container' );
	let navRows = null;
	if ( nav && nav.offsetParent !== null ) {
		const tops = new Set();
		nav.querySelectorAll( ':scope > li' ).forEach( ( li ) => tops.add( Math.round( li.getBoundingClientRect().top ) ) );
		navRows = tops.size;
	}
	const toggle = document.querySelector( '.wp-block-navigation__responsive-container-open' );

	/* 6. The hero fills the first screen. */
	const hero = document.querySelector( '.ep-hero, main > .ep-band:first-child' );

	return {
		faded,
		contrast,
		wide: wide.slice( 0, 6 ),
		clipped,
		navRows,
		navOverlay: !! ( toggle && toggle.offsetParent !== null ),
		heroH: hero ? Math.round( hero.getBoundingClientRect().height ) : null,
		pinned: header ? header.classList.contains( 'is-pinned' ) : null,
		scroll: `${ document.documentElement.scrollWidth }/${ document.documentElement.clientWidth }`,
		docH: document.documentElement.scrollHeight,
	};
};

/* --- The run -------------------------------------------------------------- */

const arg = ( name, fallback ) => {
	const hit = process.argv.find( ( a ) => a.startsWith( `--${ name }=` ) );
	return hit ? hit.split( '=' ).slice( 1 ).join( '=' ) : fallback;
};

( async () => {
	const out = process.argv[ 2 ] && ! process.argv[ 2 ].startsWith( '--' )
		? process.argv[ 2 ]
		: 'docs/screenshots';
	const base = arg( 'base', 'http://localhost:8080' );
	const widths = arg( 'widths', Object.keys( WIDTHS ).join( ',' ) ).split( ',' ).map( Number );
	const pages = arg( 'pages', Object.keys( PAGES ).join( ',' ) ).split( ',' );
	const offsets = arg( 'offsets', OFFSETS.join( ',' ) ).split( ',' ).map( Number );

	fs.mkdirSync( out, { recursive: true } );

	const browser = await chromium.launch( { executablePath: EXEC } );
	const problems = [];
	const consoleErrors = [];

	for ( const w of widths ) {
		const ctx = await browser.newContext( {
			viewport: { width: w, height: WIDTHS[ w ] || 900 },
			deviceScaleFactor: 1,
		} );
		const page = await ctx.newPage();
		page.on( 'console', ( m ) => {
			if ( m.type() === 'error' ) consoleErrors.push( `${ w } ${ m.text() }`.slice( 0, 160 ) );
		} );
		page.on( 'pageerror', ( e ) => consoleErrors.push( `${ w } ${ e.message }`.slice( 0, 160 ) ) );

		for ( const slug of pages ) {
			const url = PAGES[ slug ];
			if ( ! url ) continue;
			const res = await page.goto( base + url, { waitUntil: 'networkidle' } );

			for ( const y of offsets ) {
				const docH = await page.evaluate( () => document.documentElement.scrollHeight );
				if ( y && y > docH - ( WIDTHS[ w ] || 900 ) ) continue;
				if ( y ) {
					/* Wheel as well as scrollTo: a reveal that resolves under only one
					   of the two is broken for a real visitor. */
					await page.evaluate( ( v ) => window.scrollTo( 0, v ), y );
					await page.waitForTimeout( 200 );
					await page.mouse.wheel( 0, 40 );
				} else {
					await page.evaluate( () => window.scrollTo( 0, 0 ) );
				}
				/* Longer than --transition--reveal, so what is measured is at rest. */
				await page.waitForTimeout( 1000 );

				const name = `${ slug }-${ w }${ y ? `-s${ y }` : '-top' }`;
				await page.screenshot( { path: path.join( out, `${ name }.png` ) } );
				const a = await page.evaluate( audit );

				const bad = [];
				if ( a.faded.length ) bad.push( `FADED ${ JSON.stringify( a.faded ) }` );
				if ( a.contrast.length ) bad.push( `CONTRAST ${ JSON.stringify( a.contrast ) }` );
				if ( a.wide.length ) bad.push( `OVERFLOW ${ JSON.stringify( a.wide ) }` );
				if ( a.clipped.length ) bad.push( `CLIPPED ${ JSON.stringify( a.clipped ) }` );
				if ( a.navRows && a.navRows > 1 ) bad.push( `NAV ROWS ${ a.navRows }` );
				if ( bad.length ) problems.push( `${ name }: ${ bad.join( ' | ' ) }` );

				console.log(
					name.padEnd( 26 ),
					res.status(),
					`pin=${ a.pinned }`,
					`nav=${ a.navOverlay ? 'overlay' : `${ a.navRows } row(s)` }`,
					`hero=${ a.heroH }`,
					`w=${ a.scroll }`,
					bad.length ? bad.join( ' | ' ) : 'ok'
				);
			}
		}

		/* The mobile navigation, opened. */
		if ( w <= 1024 ) {
			await page.goto( base + '/', { waitUntil: 'networkidle' } );
			const open = page.locator( '.wp-block-navigation__responsive-container-open' ).first();
			if ( await open.count() && await open.isVisible() ) {
				await open.click();
				await page.waitForTimeout( 500 );
				await page.screenshot( { path: path.join( out, `home-${ w }-nav-open.png` ) } );
				console.log( `home-${ w }-nav-open`.padEnd( 26 ), 'captured' );
			}
		}

		await ctx.close();
	}

	await browser.close();

	if ( consoleErrors.length ) {
		console.log( `\nconsole errors (${ consoleErrors.length }):` );
		[ ...new Set( consoleErrors ) ].forEach( ( e ) => console.log( '  ' + e ) );
	}
	if ( problems.length ) {
		console.log( `\n${ problems.length } problem stop(s):` );
		problems.forEach( ( p ) => console.log( '  ' + p ) );
		process.exitCode = 1;
	} else {
		console.log( '\nclean: no faded content, no low-contrast header text, no overflow, no clipped labels, one nav row' );
	}
} )();
