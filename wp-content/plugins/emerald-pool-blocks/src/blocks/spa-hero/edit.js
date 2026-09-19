/**
 * Hero — editor.
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InnerBlocks,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	FocalPointPicker,
	Button,
	TextControl,
	ToggleGroupControl,
	ToggleGroupControlOption,
} from '@wordpress/components';

const ALLOWED_BUTTONS = [ 'core/buttons' ];

const TEMPLATE = [
	[
		'core/buttons',
		{},
		[
			[ 'core/button', { text: __( 'Browse hot tubs', 'emerald-pool-blocks' ) } ],
			[
				'core/button',
				{
					className: 'is-style-outline-quiet',
					text: __( 'Book a site visit', 'emerald-pool-blocks' ),
				},
			],
		],
	],
];

export default function Edit( { attributes, setAttributes } ) {
	const {
		eyebrow,
		heading,
		standfirst,
		mediaUrl,
		mediaAlt,
		focalPoint,
		overlayOpacity,
		minHeight,
		contentAlign,
	} = attributes;

	const blockProps = useBlockProps( {
		className: `ep-hero is-align-${ contentAlign }`,
		style: {
			'--ep-hero-min-height': `${ minHeight }vh`,
			'--ep-hero-overlay': overlayOpacity / 100,
			'--ep-hero-focal': `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%`,
		},
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Background', 'emerald-pool-blocks' ) }>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( media ) =>
								setAttributes( {
									mediaId: media.id,
									mediaUrl: media.url,
									mediaAlt: media.alt || '',
								} )
							}
							allowedTypes={ [ 'image' ] }
							render={ ( { open } ) => (
								<Button variant="secondary" onClick={ open } __next40pxDefaultSize>
									{ mediaUrl
										? __( 'Replace image', 'emerald-pool-blocks' )
										: __( 'Choose image', 'emerald-pool-blocks' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>
					{ mediaUrl && (
						<>
							<FocalPointPicker
								label={ __( 'Focal point', 'emerald-pool-blocks' ) }
								url={ mediaUrl }
								value={ focalPoint }
								onChange={ ( value ) => setAttributes( { focalPoint: value } ) }
								__nextHasNoMarginBottom
							/>
							<TextControl
								label={ __( 'Alt text', 'emerald-pool-blocks' ) }
								help={ __(
									'Describe the photograph for people who cannot see it. Leave empty only if the image is purely decorative.',
									'emerald-pool-blocks'
								) }
								value={ mediaAlt }
								onChange={ ( value ) => setAttributes( { mediaAlt: value } ) }
								__next40pxDefaultSize
								__nextHasNoMarginBottom
							/>
						</>
					) }
				</PanelBody>
				<PanelBody title={ __( 'Layout', 'emerald-pool-blocks' ) }>
					<ToggleGroupControl
						label={ __( 'Text position', 'emerald-pool-blocks' ) }
						value={ contentAlign }
						onChange={ ( value ) => setAttributes( { contentAlign: value } ) }
						isBlock
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					>
						<ToggleGroupControlOption value="left" label={ __( 'Left', 'emerald-pool-blocks' ) } />
						<ToggleGroupControlOption value="center" label={ __( 'Centre', 'emerald-pool-blocks' ) } />
					</ToggleGroupControl>
					<RangeControl
						label={ __( 'Height', 'emerald-pool-blocks' ) }
						help={ __( 'Percentage of the viewport height.', 'emerald-pool-blocks' ) }
						value={ minHeight }
						onChange={ ( value ) => setAttributes( { minHeight: value } ) }
						min={ 30 }
						max={ 90 }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<RangeControl
						label={ __( 'Scrim strength', 'emerald-pool-blocks' ) }
						help={ __(
							'Darkens the photograph behind the text. Keep it high enough for the heading to stay readable.',
							'emerald-pool-blocks'
						) }
						value={ overlayOpacity }
						onChange={ ( value ) => setAttributes( { overlayOpacity: value } ) }
						min={ 0 }
						max={ 90 }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ mediaUrl && (
					// eslint-disable-next-line jsx-a11y/alt-text
					<img className="ep-hero__media" src={ mediaUrl } alt={ mediaAlt } />
				) }
				<div className="ep-hero__scrim" aria-hidden="true" />
				<div className="ep-hero__inner">
					<RichText
						tagName="p"
						className="ep-hero__eyebrow"
						value={ eyebrow }
						allowedFormats={ [] }
						onChange={ ( value ) => setAttributes( { eyebrow: value } ) }
						placeholder={ __( 'Eugene & Bend, Oregon', 'emerald-pool-blocks' ) }
					/>
					<RichText
						tagName="h1"
						className="ep-hero__heading"
						value={ heading }
						allowedFormats={ [ 'core/italic' ] }
						onChange={ ( value ) => setAttributes( { heading: value } ) }
						placeholder={ __( 'Write the promise, not the product', 'emerald-pool-blocks' ) }
					/>
					<RichText
						tagName="p"
						className="ep-hero__standfirst"
						value={ standfirst }
						onChange={ ( value ) => setAttributes( { standfirst: value } ) }
						placeholder={ __( 'One sentence of support. Say what happens next.', 'emerald-pool-blocks' ) }
					/>
					<div className="ep-hero__actions">
						<InnerBlocks allowedBlocks={ ALLOWED_BUTTONS } template={ TEMPLATE } templateLock={ false } />
					</div>
				</div>
			</div>
		</>
	);
}
