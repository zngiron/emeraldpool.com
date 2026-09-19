/**
 * Testimonial slider — behaviour.
 *
 * Deliberate omissions: no autoplay, no timers, no drag library, no jQuery.
 * A quote only moves when a person moves it, and the off-screen quotes are made
 * inert so keyboard focus can never land on something nobody can read.
 */
import { store, getContext, getElement } from '@wordpress/interactivity';

store( 'emerald-pool/testimonial-slider', {
	state: {
		get trackTransform() {
			const { active } = getContext();

			return `translateX(-${ active * 100 }%)`;
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

		keydown( event ) {
			const context = getContext();

			if ( event.key === 'ArrowRight' ) {
				event.preventDefault();
				context.active = Math.min( context.active + 1, context.total - 1 );
			}

			if ( event.key === 'ArrowLeft' ) {
				event.preventDefault();
				context.active = Math.max( context.active - 1, 0 );
			}
		},
	},

	callbacks: {
		init() {
			const context = getContext();
			const { ref } = getElement();

			context.total = ref.querySelectorAll( '.ep-slider__track > *' ).length;
		},

		syncSlides() {
			const { active } = getContext();
			const { ref } = getElement();

			ref.querySelectorAll( '.ep-slider__track > *' ).forEach( ( slide, index ) => {
				const isActive = index === active;

				slide.inert = ! isActive;
				slide.setAttribute( 'aria-hidden', isActive ? 'false' : 'true' );
			} );
		},
	},
} );
