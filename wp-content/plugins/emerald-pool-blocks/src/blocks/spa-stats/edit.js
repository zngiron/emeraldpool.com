/**
 * Stat column — editor.
 *
 * The figures are edited as rows in the sidebar rather than in the canvas: a
 * number, an optional prefix or suffix, and the sentence that says what it
 * counts. The canvas previews the real render.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, ToggleControl } from '@wordpress/components';

const EMPTY = { value: 0, label: '', prefix: '', suffix: '', format: '' };

export default function Edit( { attributes, setAttributes } ) {
	const { heading, standfirst, items } = attributes;
	const blockProps = useBlockProps( { className: 'ep-stats' } );

	const update = ( index, patch ) =>
		setAttributes( {
			items: items.map( ( item, i ) => ( i === index ? { ...item, ...patch } : item ) ),
		} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Figures', 'emerald-pool-blocks' ) }>
					{ items.map( ( item, index ) => (
						<div key={ index } style={ { marginBottom: '1.5rem' } }>
							<TextControl
								label={ __( 'Number', 'emerald-pool-blocks' ) }
								type="number"
								value={ item.value }
								onChange={ ( value ) => update( index, { value: Number( value ) } ) }
								__next40pxDefaultSize
								__nextHasNoMarginBottom
							/>
							<TextControl
								label={ __( 'What it counts', 'emerald-pool-blocks' ) }
								value={ item.label }
								onChange={ ( value ) => update( index, { label: value } ) }
								__next40pxDefaultSize
								__nextHasNoMarginBottom
							/>
							<TextControl
								label={ __( 'Before', 'emerald-pool-blocks' ) }
								value={ item.prefix || '' }
								onChange={ ( value ) => update( index, { prefix: value } ) }
								__next40pxDefaultSize
								__nextHasNoMarginBottom
							/>
							<TextControl
								label={ __( 'After', 'emerald-pool-blocks' ) }
								value={ item.suffix || '' }
								onChange={ ( value ) => update( index, { suffix: value } ) }
								__next40pxDefaultSize
								__nextHasNoMarginBottom
							/>
							<ToggleControl
								label={ __( 'This is a year', 'emerald-pool-blocks' ) }
								help={ __(
									'A year is a label, not a quantity: it is never grouped with a thousands separator and never counts up.',
									'emerald-pool-blocks'
								) }
								checked={ 'plain' === item.format }
								onChange={ ( on ) => update( index, { format: on ? 'plain' : '' } ) }
								__nextHasNoMarginBottom
							/>
							<Button
								variant="link"
								isDestructive
								onClick={ () =>
									setAttributes( { items: items.filter( ( _, i ) => i !== index ) } )
								}
							>
								{ __( 'Remove this figure', 'emerald-pool-blocks' ) }
							</Button>
						</div>
					) ) }
					<Button
						variant="secondary"
						onClick={ () => setAttributes( { items: [ ...items, { ...EMPTY } ] } ) }
						__next40pxDefaultSize
					>
						{ __( 'Add a figure', 'emerald-pool-blocks' ) }
					</Button>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="ep-stats__head">
					<RichText
						tagName="h2"
						className="ep-stats__heading"
						value={ heading }
						allowedFormats={ [ 'core/italic' ] }
						onChange={ ( value ) => setAttributes( { heading: value } ) }
						placeholder={ __( 'What the numbers are about', 'emerald-pool-blocks' ) }
					/>
					<RichText
						tagName="p"
						className="ep-stats__standfirst"
						value={ standfirst }
						onChange={ ( value ) => setAttributes( { standfirst: value } ) }
						placeholder={ __( 'One sentence, or none.', 'emerald-pool-blocks' ) }
					/>
				</div>
				<dl className="ep-stats__list">
					{ items.map( ( item, index ) => (
						<div className="ep-stats__row" key={ index }>
							<dt className="ep-stats__figure">
								{ item.prefix && <span className="ep-stats__affix">{ item.prefix }</span> }
								<span className="ep-stats__value">
									{ 'plain' === item.format
										? item.value
										: new Intl.NumberFormat().format( item.value ) }
								</span>
								{ item.suffix && <span className="ep-stats__affix">{ item.suffix }</span> }
							</dt>
							<dd className="ep-stats__label">{ item.label }</dd>
						</div>
					) ) }
				</dl>
			</div>
		</>
	);
}
