/*
 * Hover video for spa imagery.
 *
 * Registered as a script module by inc/Media.php and enqueued only by a render
 * that actually emitted a <video>. It is deliberately small and has no imports.
 *
 * Contract with the markup:
 *   [data-ep-video]        the <video>, muted/loop/playsinline/preload="none"
 *   source[data-src]       the clip URL, withheld until the visitor asks for it
 *   [data-ep-video-root]   the element whose hover/focus drives that video
 *
 * Behaviour by input:
 *   fine pointer   hover or keyboard focus on the root plays; leaving stops
 *   coarse pointer no hover exists, so the clip plays while the card is the
 *                  thing on screen and pauses when it is not
 *   reduced motion nothing plays, ever; the poster is the whole experience
 */

const reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' );
const coarse = window.matchMedia( '(pointer: coarse)' );

/**
 * Hand the element its source the first time it is needed, and no earlier.
 *
 * @param {HTMLVideoElement} video The video element.
 */
function prime( video ) {
	if ( video.dataset.epPrimed ) {
		return;
	}

	const source = video.querySelector( 'source[data-src]' );

	if ( source && ! source.getAttribute( 'src' ) ) {
		source.setAttribute( 'src', source.dataset.src );
	}

	video.dataset.epPrimed = '1';
	video.load();
}

/**
 * @param {HTMLVideoElement} video The video element.
 */
function play( video ) {
	if ( reduced.matches ) {
		return;
	}

	prime( video );

	const playing = video.play();

	// A rejected play() is normal (no gesture, tab hidden) and is not an error.
	if ( playing && typeof playing.catch === 'function' ) {
		playing.catch( () => {} );
	}
}

/**
 * @param {HTMLVideoElement} video The video element.
 */
function stop( video ) {
	if ( ! video.dataset.epPrimed ) {
		return;
	}

	video.pause();
	video.currentTime = 0;
}

/**
 * @param {HTMLVideoElement} video The video element.
 */
function bindPointer( video ) {
	const root = video.closest( '[data-ep-video-root]' ) || video.parentElement;

	if ( ! root || root.dataset.epVideoBound ) {
		return;
	}

	root.dataset.epVideoBound = '1';

	root.addEventListener( 'pointerenter', () => play( video ) );
	root.addEventListener( 'pointerleave', () => stop( video ) );

	// Keyboard parity: the card's link taking focus is the same intent.
	root.addEventListener( 'focusin', () => play( video ) );
	root.addEventListener( 'focusout', ( event ) => {
		if ( ! root.contains( event.relatedTarget ) ) {
			stop( video );
		}
	} );
}

/**
 * On touch there is no hover, so being the card on screen is the trigger.
 *
 * @param {NodeListOf<HTMLVideoElement>} videos All hover videos on the page.
 */
function bindViewport( videos ) {
	if ( ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	const observer = new IntersectionObserver(
		( entries ) => {
			entries.forEach( ( entry ) => {
				if ( entry.isIntersecting ) {
					play( entry.target );
				} else {
					stop( entry.target );
				}
			} );
		},
		{ threshold: 0.6 }
	);

	videos.forEach( ( video ) => observer.observe( video ) );
}

const videos = document.querySelectorAll( '[data-ep-video]' );

if ( videos.length && ! reduced.matches ) {
	if ( coarse.matches ) {
		bindViewport( videos );
	} else {
		videos.forEach( bindPointer );
	}
}
