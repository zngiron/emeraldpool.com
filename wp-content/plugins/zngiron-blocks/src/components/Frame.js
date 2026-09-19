/**
 * Frame — the editor side of the sizing contract.
 *
 * One media field (image or video), one ratio from the five the system allows,
 * a fit, and a focal point. Every block that shows media uses this, so no block
 * can invent a sixth ratio or a bespoke crop.
 */
import { __ } from '@wordpress/i18n';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import {
  Button,
  FocalPointPicker,
  PanelBody,
  SelectControl,
  ToggleGroupControl,
  ToggleGroupControlOption,
} from '@wordpress/components';

export const RATIOS = [ '21:9', '16:9', '3:2', '4:5', '1:1' ];

export const FRAME_DEFAULTS = {
  mediaId: 0,
  mediaUrl: '',
  mediaType: 'image',
  alt: '',
  ratio: '16:9',
  fit: 'cover',
  focalPoint: { x: 0.5, y: 0.5 },
};

/**
 * Inline style the front end also emits, so the editor preview is not a guess.
 *
 * @param {Object} frame Frame attribute.
 * @return {Object} Style object.
 */
export function frameStyle( frame = {} ) {
  const { ratio = '16:9', focalPoint = { x: 0.5, y: 0.5 } } = frame;

  return {
    '--z-ratio': ratio.replace( ':', '/' ),
    '--z-focal-x': `${ Math.round( ( focalPoint.x ?? 0.5 ) * 100 ) }%`,
    '--z-focal-y': `${ Math.round( ( focalPoint.y ?? 0.5 ) * 100 ) }%`,
  };
}

/**
 * The Frame as the editor canvas shows it.
 *
 * @param {Object} props       Component props.
 * @param {Object} props.frame Frame attribute.
 * @return {JSX.Element} Preview.
 */
export function FramePreview( { frame = {} } ) {
  const { mediaUrl, mediaType, alt, fit = 'cover' } = frame;

  return (
    <figure className={ `z-frame is-fit-${ fit }` } style={ frameStyle( frame ) }>
      { mediaUrl && mediaType === 'video' && (
        <video className="z-frame__media" src={ mediaUrl } muted loop playsInline />
      ) }
      { mediaUrl && mediaType !== 'video' && (
        <img className="z-frame__media" src={ mediaUrl } alt={ alt || '' } />
      ) }
      { ! mediaUrl && <span className="z-frame__placeholder">{ __( 'No media', 'zngiron-blocks' ) }</span> }
    </figure>
  );
}

/**
 * Inspector controls for a Frame attribute.
 *
 * @param {Object}   props          Component props.
 * @param {Object}   props.frame    Frame attribute.
 * @param {Function} props.onChange Receives the next Frame attribute.
 * @param {string}   props.title    Panel title.
 * @return {JSX.Element} Controls.
 */
export function FrameControls( { frame = {}, onChange, title = __( 'Media', 'zngiron-blocks' ) } ) {
  const value = { ...FRAME_DEFAULTS, ...frame };
  const set = ( next ) => onChange( { ...value, ...next } );

  return (
    <PanelBody title={ title }>
      <MediaUploadCheck>
        <MediaUpload
          allowedTypes={ [ 'image', 'video' ] }
          value={ value.mediaId }
          onSelect={ ( media ) =>
            set( {
              mediaId: media.id,
              mediaUrl: media.url,
              mediaType: media.type === 'video' ? 'video' : 'image',
              alt: media.alt || '',
            } )
          }
          render={ ( { open } ) => (
            <Button variant="secondary" onClick={ open } __next40pxDefaultSize>
              { value.mediaUrl ? __( 'Replace media', 'zngiron-blocks' ) : __( 'Select media', 'zngiron-blocks' ) }
            </Button>
          ) }
        />
      </MediaUploadCheck>

      { value.mediaUrl && (
        <Button
          variant="tertiary"
          isDestructive
          onClick={ () => set( { mediaId: 0, mediaUrl: '', alt: '' } ) }
          __next40pxDefaultSize
        >
          { __( 'Remove media', 'zngiron-blocks' ) }
        </Button>
      ) }

      <SelectControl
        label={ __( 'Aspect ratio', 'zngiron-blocks' ) }
        value={ value.ratio }
        options={ RATIOS.map( ( ratio ) => ( { label: ratio, value: ratio } ) ) }
        onChange={ ( ratio ) => set( { ratio } ) }
        __next40pxDefaultSize
        __nextHasNoMarginBottom
      />

      <ToggleGroupControl
        label={ __( 'Fit', 'zngiron-blocks' ) }
        value={ value.fit }
        onChange={ ( fit ) => set( { fit } ) }
        isBlock
        __next40pxDefaultSize
        __nextHasNoMarginBottom
      >
        <ToggleGroupControlOption value="cover" label={ __( 'Cover', 'zngiron-blocks' ) } />
        <ToggleGroupControlOption value="contain" label={ __( 'Contain', 'zngiron-blocks' ) } />
      </ToggleGroupControl>

      { value.mediaUrl && value.mediaType !== 'video' && (
        <FocalPointPicker
          label={ __( 'Focal point', 'zngiron-blocks' ) }
          url={ value.mediaUrl }
          value={ value.focalPoint }
          onChange={ ( focalPoint ) => set( { focalPoint } ) }
          __nextHasNoMarginBottom
        />
      ) }
    </PanelBody>
  );
}
