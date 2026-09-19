/**
 * Feature grid — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	ToggleGroupControl,
	ToggleGroupControlOption,
} from '@wordpress/components';

const ALLOWED = [ 'emerald-pool/icon-feature' ];

const TEMPLATE = [
	[ 'emerald-pool/icon-feature', { icon: 'droplet' } ],
	[ 'emerald-pool/icon-feature', { icon: 'leaf' } ],
	[ 'emerald-pool/icon-feature', { icon: 'wrench' } ],
];

export default function Edit( { attributes, setAttributes } ) {
	const { columns, iconStyle } = attributes;

	const blockProps = useBlockProps( {
		className: `ep-features has-${ columns }-columns is-icon-${ iconStyle }`,
	} );

	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: ALLOWED,
		template: TEMPLATE,
		orientation: 'horizontal',
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Layout', 'emerald-pool-blocks' ) }>
					<RangeControl
						label={ __( 'Columns', 'emerald-pool-blocks' ) }
						value={ columns }
						onChange={ ( value ) => setAttributes( { columns: value } ) }
						min={ 2 }
						max={ 4 }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<ToggleGroupControl
						label={ __( 'Icon treatment', 'emerald-pool-blocks' ) }
						value={ iconStyle }
						onChange={ ( value ) => setAttributes( { iconStyle: value } ) }
						isBlock
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					>
						<ToggleGroupControlOption value="plain" label={ __( 'Plain', 'emerald-pool-blocks' ) } />
						<ToggleGroupControlOption value="badge" label={ __( 'Badge', 'emerald-pool-blocks' ) } />
					</ToggleGroupControl>
				</PanelBody>
			</InspectorControls>

			<div { ...innerBlocksProps } />
		</>
	);
}
