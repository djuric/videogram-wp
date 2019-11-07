/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { TextControl, TextareaControl } from '@wordpress/components';

export default props => {
  const {
    attributes: { embeddedCode, length },
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
    </div>
  );
};
