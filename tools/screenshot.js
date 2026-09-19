/*
 * Viewport screenshots at 1:1, with an audit at every stop.
 *
 * Full-page screenshots are deliberately not taken. Scaled down to fit a whole
 * page into one image they hid every defect that mattered: a pinned header
 * whose navigation had gone invisible, content stuck half-faded, a hero an inch
 * short of the viewport, a button with its label clipped. A viewport shot is
 * what a visitor actually sees, so that is what this takes.
 *
 * usage:
 *   node tools/screenshot.js <outdir> [--widths=390,1440] [--pages=home,contact]
 *                                     [--offsets=0,1000] [--base=http://localhost:8080]
 *
 * Exit code 1 if any assertion fails or any console error was logged.
 */
const path = require( 'path' );
const fs = require( 'fs' );

const PLAYWRIGHT =
  process.env.Z_PLAYWRIGHT || '/Users/zngiron/Projects/mesafinakitchen.com/node_modules/playwright';
const EXEC =
  process.env.Z_CHROME ||
  '/Users/zngiron/Library/Caches/ms-playwright/chromium_headless_shell-1234/chrome-headless-shell-mac-arm64/chrome-headless-shell';

const { chromium } = require( PLAYWRIGHT );

/*
 * Six widths, because the defects are not the same at each: 390 is the phone;
 * 768 and 1024 are where the navigation has to decide whether the full row
 * fits; 1440 is wideSize plus gutters and the width at which fluid type reaches
 * its maximum; 1920 and 2560 are where a layout starts to float in the middle
 * of an empty field and a hero photograph starts to show its pixels.
 */
const WIDTHS = {
  390: 844,
  768: 1024,
  1024: 768,
  1440: 900,
  1920: 1080,
  2560: 1440,
};

/* Widths at which the whole navigation row is expected on one line. */
const DESKTOP = 1080;

const PAGES = {
  home: '/',
  'hot-tubs': '/hot-tubs/',
  'swim-spas': '/swim-spas/',
  spas: '/spas/',
  'spa-single': '/spas/bullfrog-a7d/',
  'spa-series': '/series/a-series/',
  services: '/services/',
  financing: '/financing/',
  about: '/about/',
  faq: '/faq/',
  journal: '/journal/',
  post: '/how-to-enjoy-your-hot-tub-this-winter/',
  contact: '/contact/',
  privacy: '/privacy/',
  accessibility: '/accessibility/',
};

const OFFSETS = [ 0, 1000, 2600, 5000 ];

/* --- The audit, run inside the page -------------------------------------- */

const audit = () => {
  const srgb = ( c ) => ( c <= 0.03928 ? c / 12.92 : Math.pow( ( c + 0.055 ) / 1.055, 2.4 ) );
  const lum = ( [ r, g, b ] ) => 0.2126 * srgb( r / 255 ) + 0.7152 * srgb( g / 255 ) + 0.0722 * srgb( b / 255 );
  const parse = ( s ) => {
    const m = /rgba?\(([^)]+)\)/.exec( s || '' );
    if ( ! m ) return null;
    const p = m[ 1 ].split( /[\s,/]+/ ).filter( Boolean ).map( Number );
    return [ p[ 0 ], p[ 1 ], p[ 2 ], p.length > 3 ? p[ 3 ] : 1 ];
  };
  const over = ( fg, bg ) => {
    const a = fg[ 3 ];
    return [ 0, 1, 2 ].map( ( i ) => fg[ i ] * a + bg[ i ] * ( 1 - a ) );
  };
  /* The painted ground under an element: the first opaque background up the tree. */
  const ground = ( el ) => {
    const stack = [];
    let base = [ 255, 255, 255 ];
    for ( let n = el; n; n = n.parentElement ) {
      /* A transparent header paints a scrim gradient over the hero, and that
         scrim — not the photograph and not the page — is what its own text
         lands on. Only reached if nothing nearer has painted an opaque ground. */
      if ( n.classList && n.classList.contains( 'is-over-hero' ) ) {
        base = [ 4, 20, 27 ];
        break;
      }
      const c = parse( getComputedStyle( n ).backgroundColor );
      if ( ! c || c[ 3 ] === 0 ) continue;
      stack.push( c );
      if ( c[ 3 ] === 1 ) break;
    }
    for ( let i = stack.length - 1; i >= 0; i-- ) base = over( stack[ i ], base );
    return base;
  };
  const ratio = ( a, b ) => {
    const l1 = lum( a );
    const l2 = lum( b );
    return ( Math.max( l1, l2 ) + 0.05 ) / ( Math.min( l1, l2 ) + 0.05 );
  };
  const onScreen = ( el ) => {
    const b = el.getBoundingClientRect();
    return b.bottom > 0 && b.top < innerHeight && b.width > 0 && b.height > 0;
  };
  const name = ( el ) => `${ el.tagName.toLowerCase() }.${ `${ el.className }` }`.trim().slice( 0, 48 );

  /*
   * 1. Nothing on screen is part-faded once it has come to rest.
   *
   * Three kinds of element are allowed to be transparent and are skipped: a
   * disabled control (the carousel's arrows at the ends), anything a browser
   * has already hidden from the accessibility tree, and the closed off-canvas
   * navigation, which is present in the DOM at every width.
   */
  const faded = [];
  document.querySelectorAll( 'body *' ).forEach( ( el ) => {
    if ( ! onScreen( el ) ) return;
    if ( el.hasAttribute( 'disabled' ) || el.closest( '[disabled]' ) ) return;
    if ( el.getAttribute( 'aria-hidden' ) === 'true' || el.closest( '[aria-hidden="true"]' ) ) return;
    const closed = el.closest( '.wp-block-navigation__responsive-container' );
    if ( closed && ! closed.classList.contains( 'is-menu-open' ) ) return;
    const s = getComputedStyle( el );
    if ( s.opacity !== '1' && s.visibility !== 'hidden' ) {
      faded.push( `${ name( el ) } opacity=${ s.opacity }` );
    }
  } );

  /* 2. The header's own text, against the header's own ground. */
  const header = document.querySelector( '.z-header' );
  const contrast = [];
  if ( header ) {
    header.querySelectorAll( 'a, button, p' ).forEach( ( el ) => {
      if ( ! el.textContent.trim() || ! onScreen( el ) ) return;
      const closed = el.closest( '.wp-block-navigation__responsive-container' );
      if ( closed && ! closed.classList.contains( 'is-menu-open' ) ) return;
      const b = el.getBoundingClientRect();
      if ( b.width < 2 || b.height < 2 ) return;
      const fg = parse( getComputedStyle( el ).color );
      if ( ! fg ) return;
      const bg = ground( el );
      const r = ratio( over( fg, bg ), bg );
      if ( r < 4.5 ) contrast.push( `${ el.textContent.trim().slice( 0, 22 ) } ${ r.toFixed( 2 ) }:1` );
    } );
  }

  /* 3. Nothing sticks out sideways. */
  const doc = document.documentElement;
  const wide = [];
  if ( doc.scrollWidth > doc.clientWidth ) {
    document.querySelectorAll( 'body *' ).forEach( ( el ) => {
      const b = el.getBoundingClientRect();
      if ( b.width > 0 && b.right > doc.clientWidth + 1 && getComputedStyle( el ).position !== 'fixed' ) {
        wide.push( `${ name( el ) } right=${ Math.round( b.right ) }` );
      }
    } );
  }

  /* 4. A label that does not fit the box drawn for it. */
  const clipped = [];
  document.querySelectorAll( '.wp-element-button, .z-button, .z-chip, .z-header__phone a' ).forEach( ( el ) => {
    if ( ! onScreen( el ) ) return;
    if ( el.scrollWidth > el.clientWidth + 1 ) {
      clipped.push( `${ el.textContent.trim().slice( 0, 24 ) } ${ el.scrollWidth }>${ el.clientWidth }` );
    }
  } );

  /* 5. The navigation: one row beside the mark, or the off-canvas button. */
  const nav = document.querySelector( '.z-header .wp-block-navigation__container' );
  let navRows = null;
  if ( nav && nav.offsetParent !== null ) {
    const tops = new Set();
    nav.querySelectorAll( ':scope > li' ).forEach( ( li ) => tops.add( Math.round( li.getBoundingClientRect().top ) ) );
    navRows = tops.size;
  }
  const toggle = document.querySelector( '.z-header .wp-block-navigation__responsive-container-open' );

  /* 6. A full-height hero is exactly the first screen. */
  const hero = document.querySelector( '.z-hero.is-height-full' );

  return {
    faded: faded.slice( 0, 6 ),
    contrast,
    wide: wide.slice( 0, 6 ),
    clipped,
    navRows,
    navOverlay: !! ( toggle && toggle.offsetParent !== null ),
    heroFull: hero ? Math.round( hero.getBoundingClientRect().height ) : null,
    overHero: header ? header.classList.contains( 'is-over-hero' ) : null,
    scrollWidth: doc.scrollWidth,
    clientWidth: doc.clientWidth,
    viewport: innerHeight,
  };
};

/* --- The run -------------------------------------------------------------- */

const arg = ( key, fallback ) => {
  const hit = process.argv.find( ( a ) => a.startsWith( `--${ key }=` ) );
  return hit ? hit.split( '=' ).slice( 1 ).join( '=' ) : fallback;
};

( async () => {
  const out =
    process.argv[ 2 ] && ! process.argv[ 2 ].startsWith( '--' ) ? process.argv[ 2 ] : 'docs/shots';
  const base = arg( 'base', 'http://localhost:8080' );
  const widths = arg( 'widths', Object.keys( WIDTHS ).join( ',' ) ).split( ',' ).map( Number );
  const pages = arg( 'pages', Object.keys( PAGES ).join( ',' ) ).split( ',' );
  const offsets = arg( 'offsets', OFFSETS.join( ',' ) ).split( ',' ).map( Number );

  fs.mkdirSync( out, { recursive: true } );

  const browser = await chromium.launch( { executablePath: EXEC } );
  const problems = [];
  const consoleErrors = [];
  let stops = 0;

  for ( const w of widths ) {
    const height = WIDTHS[ w ] || 900;
    const ctx = await browser.newContext( { viewport: { width: w, height }, deviceScaleFactor: 1 } );
    const page = await ctx.newPage();
    page.on( 'console', ( m ) => {
      if ( m.type() === 'error' ) consoleErrors.push( `${ w } ${ m.text() }`.slice( 0, 180 ) );
    } );
    page.on( 'pageerror', ( e ) => consoleErrors.push( `${ w } ${ e.message }`.slice( 0, 180 ) ) );

    for ( const slug of pages ) {
      const url = PAGES[ slug ];
      if ( ! url ) continue;
      const res = await page.goto( base + url, { waitUntil: 'networkidle' } );

      for ( const y of offsets ) {
        const docH = await page.evaluate( () => document.documentElement.scrollHeight );
        if ( y && y > docH - height ) continue;

        if ( y ) {
          /* Wheel as well as scrollTo: a reveal that resolves under only one of
             the two is broken for a real visitor. */
          await page.evaluate( ( v ) => window.scrollTo( 0, v ), y );
          await page.waitForTimeout( 200 );
          await page.mouse.wheel( 0, 40 );
        } else {
          await page.evaluate( () => window.scrollTo( 0, 0 ) );
        }
        /* Longer than --wp--custom--reveal, so what is measured is at rest. */
        await page.waitForTimeout( 1000 );

        const label = `${ slug }-${ w }${ y ? `-s${ y }` : '-top' }`;
        await page.screenshot( { path: path.join( out, `${ label }.png` ) } );
        const a = await page.evaluate( audit );
        stops++;

        const bad = [];
        if ( res.status() >= 400 ) bad.push( `HTTP ${ res.status() }` );
        if ( a.scrollWidth > a.clientWidth ) bad.push( `OVERFLOW ${ a.scrollWidth }/${ a.clientWidth }` );
        if ( a.wide.length ) bad.push( `WIDE ${ JSON.stringify( a.wide ) }` );
        if ( a.faded.length ) bad.push( `FADED ${ JSON.stringify( a.faded ) }` );
        if ( a.contrast.length ) bad.push( `CONTRAST ${ JSON.stringify( a.contrast ) }` );
        if ( a.clipped.length ) bad.push( `CLIPPED ${ JSON.stringify( a.clipped ) }` );
        if ( w >= DESKTOP && a.navOverlay ) bad.push( 'NAV off-canvas at a desktop width' );
        if ( w >= DESKTOP && a.navRows && a.navRows > 1 ) bad.push( `NAV ${ a.navRows } rows` );
        if ( a.heroFull !== null && Math.abs( a.heroFull - a.viewport ) > 2 ) {
          bad.push( `HERO ${ a.heroFull } != viewport ${ a.viewport }` );
        }
        if ( bad.length ) problems.push( `${ label }: ${ bad.join( ' | ' ) }` );

        console.log(
          label.padEnd( 26 ),
          res.status(),
          `nav=${ a.navOverlay ? 'off-canvas' : `${ a.navRows } row(s)` }`,
          `over-hero=${ a.overHero }`,
          `hero=${ a.heroFull ?? '-' }/${ a.viewport }`,
          `w=${ a.scrollWidth }/${ a.clientWidth }`,
          bad.length ? bad.join( ' | ' ) : 'ok'
        );
      }
    }

    /* The off-canvas navigation, opened. */
    if ( w < DESKTOP ) {
      await page.goto( base + '/', { waitUntil: 'networkidle' } );
      const open = page.locator( '.z-header .wp-block-navigation__responsive-container-open' ).first();
      if ( ( await open.count() ) && ( await open.isVisible() ) ) {
        await open.click();
        await page.waitForTimeout( 500 );
        await page.screenshot( { path: path.join( out, `home-${ w }-nav-open.png` ) } );
        const a = await page.evaluate( audit );
        if ( a.contrast.length ) problems.push( `home-${ w }-nav-open: CONTRAST ${ JSON.stringify( a.contrast ) }` );
        console.log( `home-${ w }-nav-open`.padEnd( 26 ), 'captured', a.contrast.length ? 'CONTRAST' : 'ok' );
      } else {
        problems.push( `home-${ w }: no off-canvas toggle below ${ DESKTOP }px` );
      }
    }

    await ctx.close();
  }

  await browser.close();

  if ( consoleErrors.length ) {
    console.log( `\nconsole errors (${ [ ...new Set( consoleErrors ) ].length } unique):` );
    [ ...new Set( consoleErrors ) ].forEach( ( e ) => console.log( '  ' + e ) );
  }
  if ( problems.length || consoleErrors.length ) {
    console.log( `\n${ problems.length } problem stop(s) of ${ stops }:` );
    problems.forEach( ( p ) => console.log( '  ' + p ) );
    process.exitCode = 1;
  } else {
    console.log(
      `\nclean across ${ stops } stops: no overflow, nothing part-faded, header text AA, ` +
        'one navigation row at desktop widths, hero exactly one viewport, no console errors'
    );
  }
} )();
