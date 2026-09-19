/**
 * marquee — registration. Server-rendered, so there is no save().
 */
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit';

import './style.scss';


registerBlockType( metadata.name, { edit: Edit } );
