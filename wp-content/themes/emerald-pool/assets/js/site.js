/*
 * Emerald Pool — the theme's only front-end script.
 *
 * Two jobs, no library, no dependencies, deferred:
 *   1. publish the header's height as --ep-header-h and toggle .is-pinned on it;
 *   2. stand in for scroll-driven animations where the browser has none.
 *
 * Both are progressive. If this file never loads: the header is its solid
 * default state, the page clears it via the CSS fallback height, and every
 * .ep-reveal element is simply visible. Nothing is hidden by JavaScript that
 * JavaScript then has to reveal.
 */
( function () {
	'use strict';

	var reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' );

	/* ---------------------------------------------------- 1. header state. */

	var header = document.querySelector( '.ep-site-header' );

	if ( header ) {
		var setHeight = function () {
			document.documentElement.style.setProperty(
				'--ep-header-h',
				header.offsetHeight + 'px'
			);
		};

		setHeight();

		if ( window.ResizeObserver ) {
			new ResizeObserver( setHeight ).observe( header );
		} else {
			window.addEventListener( 'resize', setHeight, { passive: true } );
		}

		/*
		 * The header solidifies once the visitor is past the first screen of the
		 * hero. A sentinel would need markup in the template part; a scroll
		 * listener reading one number does not, and it is rAF-throttled so it
		 * costs nothing.
		 */
		var ticking = false;

		var sync = function () {
			ticking = false;
			header.classList.toggle( 'is-pinned', window.scrollY > 80 );
		};

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

		sync();
	}

	/* -------------------------------------------------- 2. the reveal. */

	/*
	 * Nothing on the page is hidden until this runs, and this runs only where an
	 * observer exists and motion is wanted. `.ep-motion-ready` on <html> is the
	 * one switch that lets CSS start an element hidden, so a script that never
	 * loads, a browser without IntersectionObserver, and a visitor who asked for
	 * reduced motion all get the same thing: content, visible.
	 *
	 * The observer is deliberately viewport-relative and cheap to satisfy —
	 * threshold 0, no negative root margin — so a band taller than the viewport,
	 * an element already on screen at load, and an element landed on by
	 * `scrollTo` or an in-page anchor all resolve to revealed on the first
	 * callback, which fires immediately on observe.
	 */
	if ( reduced.matches || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	var targets = document.querySelectorAll( '.ep-reveal' );

	if ( ! targets.length ) {
		return;
	}

	var reveal = function ( el ) {
		el.classList.add( 'is-revealed' );
	};

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					reveal( entry.target );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ threshold: 0 }
	);

	/* Only now is it safe for CSS to start these elements hidden. */
	document.documentElement.classList.add( 'ep-motion-ready' );

	targets.forEach( function ( el ) {
		observer.observe( el );
	} );

	/*
	 * A last resort. If the observer is ever throttled out of existence — a
	 * background tab restored, a browser that drops callbacks under memory
	 * pressure — the page must not be left blank. Anything still hidden a couple
	 * of seconds after load is simply shown.
	 */
	window.addEventListener( 'load', function () {
		window.setTimeout( function () {
			document
				.querySelectorAll( '.ep-reveal:not(.is-revealed)' )
				.forEach( function ( el ) {
					if ( el.getBoundingClientRect().top < window.innerHeight ) {
						reveal( el );
						observer.unobserve( el );
					}
				} );
		}, 2000 );
	} );
} )();
