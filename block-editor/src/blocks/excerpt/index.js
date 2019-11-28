/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import edit from './edit';

registerBlockType('videogram/excerpt', {
  title: __('Video Excerpt'),
  description: __('Excerpt for current video post type.'),
  icon: 'excerpt-view',
  category: 'common',

  edit
});
