/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import edit from './edit';

registerBlockType('videogram/video', {
  title: __('Video'),
  description: __('Video block'),
  icon: 'format-video',
  category: 'common',

  attributes: {
    embeddedCode: {
      type: 'string',
      source: 'meta',
      meta: 'embedded_code',
      default: ''
    },
    length: {
      type: 'string',
      source: 'meta',
      meta: 'length',
      default: ''
    },
    featured: {
      type: 'boolean',
      source: 'meta',
      meta: 'featured',
      default: false
    }
  },

  edit,
  save() {
    return null;
  }
});
