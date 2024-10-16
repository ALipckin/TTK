import InputBox from '@/components/Inputs/TtkInputBox'
import React from 'react'

const SimpleInput = ({
        title = '',
        value = '',
        errors,
        type = 'text',
        placeholder,
        disabled = false,
        titleClassName = 'title',
        onChange = null,
        ...props
    }) => (
    <div className="row">
        <div className="col-12 col-md-4 col-xl-2">
            <p className={titleClassName}>
                {title}
            </p>
        </div>
        <div className="col-12 col-md-10">
            <InputBox
                name={name}
                placeholder={placeholder}
                value={value}
                type={type}
                onChange={onChange}
                errors={errors}
            /></div>
    </div>
);

export default SimpleInput;
