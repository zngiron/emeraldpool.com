/*
 * The theme's only front-end script. No dependencies, deferred, ~1 KB.
 *
 * Two jobs:
 *   1. publish the fixed header's height as --z-header-h, and toggle the one
 *      class that makes it transparent over a Hero;
 *   2. reveal elements as they arrive, where the browser can do it cheaply.
 *
 * Both are enhancements. Blocked, failed or unsupported, the page is a solid
 * header over visible content — which is the CSS default, not a fallback.
 */
( function () {
  'use strict';

  var header = document.querySelector( '.z-header' );

  if ( header ) {
    var publishHeight = function () {
      document.documentElement.style.setProperty( '--z-header-h', header.offsetHeight + 'px' );
    };

    publishHeight();

    if ( window.ResizeObserver ) {
      new ResizeObserver( publishHeight ).observe( header );
    } else {
      window.addEventListener( 'resize', publishHeight, { passive: true } );
    }

    /*
     * Transparent only while a Hero is genuinely behind the header. On a page
     * without one — FAQ, financing, a search result — the header stays solid
     * from the first frame, so its sand text never lands on a white ground.
     */
    var hero = document.querySelector( '.z-main .z-hero' );
    var ticking = false;

    var sync = function () {
      ticking = false;
      header.classList.toggle( 'is-over-hero', !! hero && window.scrollY < 80 );
    };

    if ( hero ) {
      window.addEventListener(
        'scroll',
        function () {
          if ( ! ticking ) {
            ticking = true;
            window.requestAnimationFrame( sync );
          }
        },
        { passive: true }
      );
    }

    sync();
  }

  /* ------------------------------------------------------------- reveal. */

  if (
    ! ( 'IntersectionObserver' in window ) ||
    window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches
  ) {
    return;
  }

  var targets = document.querySelectorAll( '.z-reveal' );

  if ( ! targets.length ) {
    return;
  }

  var observer = new IntersectionObserver(
    function ( entries ) {
      entries.forEach( function ( entry ) {
        if ( entry.isIntersecting ) {
          entry.target.classList.add( 'is-revealed' );
          observer.unobserve( entry.target );
        }
      } );
    },
    /* threshold 0, no negative margin: a band taller than the viewport, an
       element already on screen, and an anchor jump all resolve on the first
       callback, which fires as soon as the target is observed. */
    { threshold: 0 }
  );

  /* Only now may CSS start anything hidden. */
  document.documentElement.classList.add( 'z-motion' );

  targets.forEach( function ( el ) {
    observer.observe( el );
  } );

  /* Last resort: anything still hidden inside the viewport two seconds after
     load is shown, whatever happened to the observer. */
  window.addEventListener( 'load', function () {
    window.setTimeout( function () {
      document.querySelectorAll( '.z-reveal:not(.is-revealed)' ).forEach( function ( el ) {
        if ( el.getBoundingClientRect().top < window.innerHeight ) {
          el.classList.add( 'is-revealed' );
          observer.unobserve( el );
        }
      } );
    }, 2000 );
  } );
} )();
