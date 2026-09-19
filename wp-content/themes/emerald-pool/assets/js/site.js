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

	/* ------------------------------------------- 2. reveal fallback only. */

	/*
	 * Browsers that support animation-timeline do the reveals themselves, in
	 * CSS, off the main thread. This runs only where they do not.
	 */
	if (
		reduced.matches ||
		! ( 'IntersectionObserver' in window ) ||
		CSS.supports( 'animation-timeline', 'view()' )
	) {
		return;
	}

	var targets = document.querySelectorAll( '.ep-reveal' );

	if ( ! targets.length ) {
		return;
	}

	/* Only now is it safe for CSS to start these elements hidden. */
	document.documentElement.classList.add( 'ep-io' );

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-revealed' );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ rootMargin: '0px 0px -12% 0px', threshold: 0.08 }
	);

	targets.forEach( function ( el ) {
		observer.observe( el );
	} );
} )();
