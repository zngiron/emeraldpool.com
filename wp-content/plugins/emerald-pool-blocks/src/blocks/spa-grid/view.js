/**
 * Spa grid — browser filtering.
 *
 * Interactivity API only: no jQuery, no page reload, no library. Cards are
 * hidden with the `hidden` attribute so assistive technology and the layout
 * agree on what is on screen, and the result count is announced politely.
 *
 * The series a chip or card belongs to is read from its own data attribute
 * rather than from a nested context, so a single context object at the root
 * holds the whole state of the grid.
 */
import { store, getContext, getElement } from '@wordpress/interactivity';

store( 'emerald-pool/spa-grid', {
	state: {
		/**
		 * True when a card belongs to a series the visitor has filtered out.
		 */
		get isHidden() {
			const { activeSeries } = getContext();
			const { ref } = getElement();

			return activeSeries !== '' && ref.dataset.series !== activeSeries;
		},

		/**
		 * True for the chip matching the active filter.
		 */
		get isPressed() {
			const { activeSeries } = getContext();
			const { ref } = getElement();

			return ref.dataset.series === activeSeries;
		},

		/**
		 * Announcement for the live region.
		 */
		get resultsMessage() {
			const { activeSeries, counts, labels, messageTemplate } = getContext();
			const count = counts[ activeSeries ] ?? 0;
			const label = labels[ activeSeries ] ?? '';

			return messageTemplate.replace( '%1$s', String( count ) ).replace( '%2$s', label );
		},
	},

	actions: {
		/**
		 * Apply the clicked chip's series as the active filter.
		 */
		filter() {
			const context = getContext();
			const { ref } = getElement();

			context.activeSeries = ref.dataset.series;
		},
	},
} );
