/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { TextareaControl } from '@wordpress/components';
import { withSelect, withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';

const Edit = ({ className, excerpt, onSetExcerpt }) => {
  return (
    <TextareaControl
      className={className}
      value={excerpt}
      label={__('Video Excerpt')}
      rows="5"
      onChange={excerpt => onSetExcerpt(excerpt)}
    />
  );
};

export default compose([
  withSelect(select => {
    return {
      excerpt: select('core/editor').getEditedPostAttribute('excerpt')
    };
  }),
  withDispatch(dispatch => ({
    onSetExcerpt(excerpt) {
      dispatch('core/editor').editPost({ excerpt });
    }
  }))
])(Edit);
