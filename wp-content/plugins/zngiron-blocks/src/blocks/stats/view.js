/**
 * Stats — the count-up.
 *
 * The number in the HTML is already right. This rewinds it to zero the first
 * time it scrolls into view and runs it back up, once. Under reduced motion, or
 * without IntersectionObserver, nothing is touched at all.
 */
import { store, getElement } from '@wordpress/interactivity';

const DURATION = 1400;
const ease = ( t ) => 1 - Math.pow( 1 - t, 3 );

function run( el, target ) {
  const format = new Intl.NumberFormat();
  const start = performance.now();

  const frame = ( now ) => {
    const progress = Math.min( 1, ( now - start ) / DURATION );

    el.textContent = format.format( Math.round( target * ease( progress ) ) );

    if ( progress < 1 ) {
      window.requestAnimationFrame( frame );
    }
  };

  window.requestAnimationFrame( frame );
}

store( 'zngiron/stats', {
  callbacks: {
    count() {
      const { ref } = getElement();
      const target = Number( ref.dataset.target );
      const reduced = window.matchMedia( '(prefers-reduced-motion: reduce)' );

      if ( reduced.matches || ! Number.isFinite( target ) || ! ( 'IntersectionObserver' in window ) ) {
        return;
      }

      const observer = new IntersectionObserver(
        ( entries ) => {
          entries.forEach( ( entry ) => {
            if ( entry.isIntersecting ) {
              observer.disconnect();
              run( ref, target );
            }
          } );
        },
        { threshold: 0.4 }
      );

      observer.observe( ref );

      return () => observer.disconnect();
    },
  },
} );
