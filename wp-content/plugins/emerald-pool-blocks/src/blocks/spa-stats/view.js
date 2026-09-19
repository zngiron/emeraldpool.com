/**
 * Stat column — the count-up.
 *
 * The numbers are already correct in the HTML. This only replays them: when a
 * figure first scrolls into view it is rewound to zero and run back up to the
 * value the server printed, once, and then the observer lets it go.
 *
 * Under prefers-reduced-motion nothing is touched at all, so the figure is
 * simply the number — which is what it was before the script loaded.
 */
import { store, getElement } from '@wordpress/interactivity';

const reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' );

const DURATION = 1400;

/**
 * Ease-out cubic: fast first, settling on the value rather than snapping to it.
 *
 * @param {number} t Progress, 0–1.
 * @return {number} Eased progress.
 */
const ease = ( t ) => 1 - Math.pow( 1 - t, 3 );

/**
 * @param {HTMLElement} el     The figure.
 * @param {number}      target Value to land on.
 */
function run( el, target ) {
	const format = new Intl.NumberFormat();
	const start = performance.now();

	const frame = ( now ) => {
		const progress = Math.min( 1, ( now - start ) / DURATION );
		const value = Math.round( target * ease( progress ) );

		el.textContent = format.format( value );

		if ( progress < 1 ) {
			window.requestAnimationFrame( frame );
		}
	};

	window.requestAnimationFrame( frame );
}

store( 'emerald-pool/spa-stats', {
	callbacks: {
		count() {
			const { ref } = getElement();
			const target = Number( ref.dataset.target );

			if ( reduced.matches || ! Number.isFinite( target ) || ! ( 'IntersectionObserver' in window ) ) {
				return;
			}

			const observer = new IntersectionObserver(
				( entries ) => {
					entries.forEach( ( entry ) => {
						if ( ! entry.isIntersecting ) {
							return;
						}

						observer.disconnect();
						run( ref, target );
					} );
				},
				{ threshold: 0.5 }
			);

			observer.observe( ref );

			return () => observer.disconnect();
		},
	},
} );
