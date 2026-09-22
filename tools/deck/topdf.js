/* Render deck.html to a 16:9 PDF, one slide per page. */
const path = require( 'path' );
const PLAYWRIGHT =
  process.env.Z_PLAYWRIGHT || '/Users/zngiron/Projects/mesafinakitchen.com/node_modules/playwright';
const { chromium } = require( PLAYWRIGHT );

/* The installed browser build is newer than the playwright package expects, so
   point at it explicitly — the same workaround tools/screenshot.js uses. */
const EXEC =
  process.env.Z_CHROME ||
  '/Users/zngiron/Library/Caches/ms-playwright/chromium_headless_shell-1234/chrome-headless-shell-mac-arm64/chrome-headless-shell';

const dir = __dirname;
const out = path.join( dir, '..', '..', 'docs', 'emerald-pool-block-system.pdf' );

( async () => {
  const browser = await chromium.launch( { executablePath: EXEC } );
  const page = await browser.newPage( { viewport: { width: 1280, height: 720 } } );
  const errors = [];

  page.on( 'console', ( m ) => m.type() === 'error' && errors.push( m.text() ) );
  page.on( 'pageerror', ( e ) => errors.push( String( e ) ) );

  await page.goto( 'file://' + path.join( dir, 'deck.html' ), { waitUntil: 'networkidle' } );
  await page.evaluate( () => document.fonts.ready );

  // Every image must actually have decoded, or the PDF gets blank frames.
  const broken = await page.evaluate( () =>
    Array.from( document.images )
      .filter( ( img ) => ! img.complete || img.naturalWidth === 0 )
      .map( ( img ) => img.getAttribute( 'src' ) )
  );

  const slides = await page.evaluate( () => document.querySelectorAll( '.slide' ).length );

  // Report any slide whose content runs past the 720px frame.
  const overflow = await page.evaluate( () =>
    Array.from( document.querySelectorAll( '.slide' ) )
      .map( ( s, i ) => ( { i: i + 1, over: s.scrollHeight - s.clientHeight } ) )
      .filter( ( s ) => s.over > 1 )
  );

  await page.pdf( {
    path: out,
    width: '1280px',
    height: '720px',
    printBackground: true,
    pageRanges: '1-' + slides,
  } );

  await browser.close();

  console.log( 'slides: ' + slides );
  console.log( 'broken images: ' + ( broken.length ? broken.join( ', ' ) : 'none' ) );
  console.log(
    'overflowing slides: ' +
      ( overflow.length ? overflow.map( ( s ) => s.i + ' (+' + s.over + 'px)' ).join( ', ' ) : 'none' )
  );
  console.log( 'console errors: ' + ( errors.length ? errors.join( ' | ' ) : 'none' ) );
  console.log( 'wrote ' + out );

  if ( broken.length || overflow.length ) {
    process.exitCode = 1;
  }
} )();
