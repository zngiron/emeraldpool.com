/**
 * Feature — editor.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';

import { getIcons, Icon } from './icons';

export default function Edit( { attributes, setAttributes, context } ) {
	const { icon, title, text, linkUrl, linkText } = attributes;
	const icons = getIcons();
	const iconStyle = context?.[ 'emerald-pool/iconStyle' ] || 'badge';

	const blockProps = useBlockProps( { className: `ep-feature is-icon-${ iconStyle }` } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Icon', 'emerald-pool-blocks' ) }>
					<div className="ep-icon-picker" role="radiogroup" aria-label={ __( 'Icon', 'emerald-pool-blocks' ) }>
						{ Object.keys( icons ).map( ( name ) => (
							<Button
								key={ name }
								className="ep-icon-picker__option"
								isPressed={ icon === name }
								label={ icons[ name ].label }
								showTooltip
								onClick={ () => setAttributes( { icon: name } ) }
							>
								<Icon name={ name } />
							</Button>
						) ) }
					</div>
				</PanelBody>
				<PanelBody title={ __( 'Link', 'emerald-pool-blocks' ) } initialOpen={ false }>
					<TextControl
						label={ __( 'Link text', 'emerald-pool-blocks' ) }
						help={ __( 'Name the destination, for example “See our service plans”.', 'emerald-pool-blocks' ) }
						value={ linkText }
						onChange={ ( value ) => setAttributes( { linkText: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<TextControl
						label={ __( 'Link URL', 'emerald-pool-blocks' ) }
						type="url"
						value={ linkUrl }
						onChange={ ( value ) => setAttributes( { linkUrl: value } ) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<Icon name={ icon } />
				<RichText
					tagName="h3"
					className="ep-feature__title"
					value={ title }
					allowedFormats={ [] }
					onChange={ ( value ) => setAttributes( { title: value } ) }
					placeholder={ __( 'What the customer gets', 'emerald-pool-blocks' ) }
				/>
				<RichText
					tagName="p"
					className="ep-feature__text"
					value={ text }
					onChange={ ( value ) => setAttributes( { text: value } ) }
					placeholder={ __( 'One sentence of evidence.', 'emerald-pool-blocks' ) }
				/>
				{ linkText && <span className="ep-feature__link">{ linkText }</span> }
			</div>
		</>
	);
}
