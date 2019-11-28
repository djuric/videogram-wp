/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
  TextControl,
  TextareaControl,
  ToggleControl
} from '@wordpress/components';

export default props => {
  const {
    attributes: { embeddedCode, length, featured },
    setAttributes,
    className
  } = props;

  return (
    <div className={className}>
      <TextareaControl
        label={__('Embedded Code')}
        value={embeddedCode}
        onChange={embeddedCode => setAttributes({ embeddedCode })}
      />
      <TextControl
        type="number"
        label={__('Video length')}
        value={length}
        onChange={length => setAttributes({ length })}
      />
      <ToggleControl
        label={__('Featured Video')}
        checked={featured}
        onChange={featured => setAttributes({ featured })}
      />
    </div>
  );
};
