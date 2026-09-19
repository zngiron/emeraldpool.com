/**
 * Store cards — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	ToggleControl,
	ToggleGroupControl,
	ToggleGroupControlOption,
} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';

export default function Edit( { attributes, setAttributes } ) {
	const { location, showHours, showMapLink, showNote, layout, headingLevel } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Which store', 'emerald-pool-blocks' ) }>
					<SelectControl
						label={ __( 'Store', 'emerald-pool-blocks' ) }
						value={ location }
						options={ [
							{ label: __( 'Both stores', 'emerald-pool-blocks' ), value: '' },
							{ label: 'Eugene', value: 'eugene' },
							{ label: 'Bend', value: 'bend' },
						] }
						onChange={ ( value ) => setAttributes( { location: value } ) }
						help={ __( 'Stores are configured in the plugin, not typed into the page.', 'emerald-pool-blocks' ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<ToggleGroupControl
						label={ __( 'Layout', 'emerald-pool-blocks' ) }
						value={ layout }
						onChange={ ( value ) => setAttributes( { layout: value } ) }
						isBlock
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					>
						<ToggleGroupControlOption value="cards" label={ __( 'Cards', 'emerald-pool-blocks' ) } />
						<ToggleGroupControlOption value="inline" label={ __( 'One line', 'emerald-pool-blocks' ) } />
					</ToggleGroupControl>
					<SelectControl
						label={ __( 'Heading level', 'emerald-pool-blocks' ) }
						value={ String( headingLevel ) }
						options={ [ 2, 3, 4 ].map( ( level ) => ( {
							label: `H${ level }`,
							value: String( level ),
						} ) ) }
						onChange={ ( value ) => setAttributes( { headingLevel: Number( value ) } ) }
						help={ __( 'Match the level to where the block sits in the page outline.', 'emerald-pool-blocks' ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
				</PanelBody>
				<PanelBody title={ __( 'What to show', 'emerald-pool-blocks' ) }>
					<ToggleControl
						label={ __( 'Opening hours', 'emerald-pool-blocks' ) }
						checked={ showHours }
						onChange={ ( value ) => setAttributes( { showHours: value } ) }
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Map link', 'emerald-pool-blocks' ) }
						checked={ showMapLink }
						onChange={ ( value ) => setAttributes( { showMapLink: value } ) }
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'One-line description', 'emerald-pool-blocks' ) }
						checked={ showNote }
						onChange={ ( value ) => setAttributes( { showNote: value } ) }
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...useBlockProps() }>
				<ServerSideRender block={ metadata.name } attributes={ attributes } />
			</div>
		</>
	);
}
