import './TtkInput.css'
import React from 'react'

const TtkInput = ({
                      title = '', value = '', type='', disabled = false,
                    className = '', onChange = null,
                      ...props
                  }) => (

                <input
                    className={`ttk-input ${className} ${title ? 'ml-1' : ''}`}
                    disabled={disabled}
                    type={type}
                    value={value ? value : ''}
                    onChange={onChange}
                    {...props}
                />
)

export default TtkInput
