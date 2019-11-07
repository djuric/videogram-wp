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
  icon: 'smiley',
  category: 'common',

  attributes: {
    embeddedCode: {
      type: 'string',
      default: ''
    },
    length: {
      type: 'string',
      default: ''
    }
  },

  edit,
  save() {
    return null;
  }
});
