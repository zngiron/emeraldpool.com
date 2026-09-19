/**
 * Testimonials — previous and next.
 *
 * No autoplay, no timers, no drag library. Off-screen quotes are made inert so
 * keyboard focus stays where the eye is.
 */
import { store, getContext, getElement } from '@wordpress/interactivity';

store( 'zngiron/testimonials', {
  state: {
    get trackTransform() {
      return `translateX(-${ getContext().active * 100 }%)`;
    },

    get isFirst() {
      return getContext().active === 0;
    },

    get isLast() {
      const { active, total } = getContext();

      return total === 0 || active >= total - 1;
    },

    get position() {
      const { active, total } = getContext();

      return total ? `${ active + 1 } / ${ total }` : '';
    },
  },

  actions: {
    next() {
      const context = getContext();

      if ( context.active < context.total - 1 ) {
        context.active += 1;
      }
    },

    previous() {
      const context = getContext();

      if ( context.active > 0 ) {
        context.active -= 1;
      }
    },
  },

  callbacks: {
    syncSlides() {
      const { active } = getContext();
      const { ref } = getElement();

      ref.querySelectorAll( '.z-testimonials__track > *' ).forEach( ( slide, index ) => {
        const isActive = index === active;

        slide.inert = ! isActive;
        slide.setAttribute( 'aria-hidden', isActive ? 'false' : 'true' );
      } );
    },
  },
} );
