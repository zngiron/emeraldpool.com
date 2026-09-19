/**
 * Editor-side access to the icon set.
 *
 * The paths themselves live in PHP (inc/Icons.php) and are published to the
 * editor by the `emerald-pool-icons` script, which this block lists in its
 * block.json. That keeps one copy of the artwork for both the picker and the
 * server render.
 */

/**
 * Every icon the site has, keyed by name.
 *
 * @return {Object} Icons keyed by name, each with `label` and `path`.
 */
export function getIcons() {
	return window.emeraldPoolIcons || {};
}

/**
 * Render one icon.
 *
 * @param {Object} props      Component props.
 * @param {string} props.name Icon key.
 * @return {JSX.Element|null} The SVG, or null for an unknown key.
 */
export function Icon( { name } ) {
	const icon = getIcons()[ name ];

	if ( ! icon ) {
		return null;
	}

	return (
		<svg
			className="ep-feature__icon"
			viewBox="0 0 24 24"
			width="28"
			height="28"
			fill="none"
			stroke="currentColor"
			strokeWidth="1.5"
			strokeLinecap="round"
			strokeLinejoin="round"
			aria-hidden="true"
			focusable="false"
		>
			<path d={ icon.path } />
		</svg>
	);
}
