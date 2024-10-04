import './TtkInput.css';
import InputError from '@/components/errors/TtkError';
import TtkInput from './TtkInput';
import React from 'react';
import ActionIconButton from '@/components/buttons/ActionIconButton'

const TtkInputBox = ({
  title = '',
  value = '',
    onDeleteButton = false,
  errors,
  disabled = false,
  titleClassName = '',
  className = '',
  onChange = null,
  children,
  ...props
}) => (
  <div>
    <div className="input-box d-flex justify-content-start align-items-center">
      <p className={`title ${titleClassName}`}>
        {title}
      </p>
      {children ? (
        React.Children.map(children, child =>
          React.isValidElement(child) ? child : null
        )
      ) : (
        <TtkInput
          title={title}
          value={value}
          disabled={disabled}
          className={className}
          onChange={onChange}
          {...props}
        />
      )}
        {onDeleteButton ? (
            <ActionIconButton onClick={onDeleteButton} img="/images/minus.svg" />
            )
            : (null)
        }
    </div>
    <InputError messages={errors} className="mt-2" />
  </div>
);

export default TtkInputBox;
