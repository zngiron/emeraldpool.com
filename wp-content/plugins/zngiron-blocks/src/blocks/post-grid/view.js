/**
 * Post Grid — browser filtering.
 *
 * Every card is already on the page; a chip only hides the ones that do not
 * belong to it, using the `hidden` attribute so assistive technology and the
 * layout agree on what is on screen. No fetch, no reload, no jQuery.
 */
import { store, getContext, getElement } from '@wordpress/interactivity';

store( 'zngiron/post-grid', {
  state: {
    get isHidden() {
      const { activeTerm } = getContext();
      const { ref } = getElement();

      return activeTerm !== '' && ref.dataset.term !== activeTerm;
    },

    get isPressed() {
      const { activeTerm } = getContext();
      const { ref } = getElement();

      return ref.dataset.term === activeTerm;
    },
  },

  actions: {
    filter() {
      const context = getContext();
      const { ref } = getElement();

      context.activeTerm = ref.dataset.term;
    },
  },
} );
