import React, { useState, useEffect, useRef } from 'react';
import './MultiSelect.css';

const MultiplySelectDropdown = ({ items, selectedItems, setSelectedItems }) => {
    const [isOpen, setIsOpen] = useState(false);
    const dropdownRef = useRef(null);

    const handleCategoryChange = (id) => {
        const updatedItems = selectedItems.includes(id)
            ? selectedItems.filter((itemId) => itemId !== id)
            : [...selectedItems, id];

        setSelectedItems(updatedItems);
    };

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setIsOpen(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    const selectedNames = Array.isArray(items)   
    ? items.filter(({ id }) => selectedItems.includes(id))  
           .map(({ title }) => title)  
           .join(', ')  
    : '';  

    return (
        <div className="position-relative" ref={dropdownRef}>
            <input
                type="text"
                readOnly
                value={selectedNames}
                onClick={() => setIsOpen(!isOpen)}
                placeholder="Выберите элементы"
                className="form-control multi-dropdown-width"
            />

            {isOpen && (
                <div className="multi-dropdown-menu position-absolute bg-white border rounded shadow-lg mt-1 multi-dropdown-width">
                    {Array.isArray(items) && items.map(({ id, title }) => (
                        <label key={id} className="multi-dropdown-item d-flex align-items-center p-2">
                            <input
                                type="checkbox"
                                checked={selectedItems.includes(id)}
                                onChange={() => handleCategoryChange(id)}
                                className="me-2"
                            />
                            {title}
                        </label>
                    ))}
                </div>
            )}
        </div>
    );
};

export default MultiplySelectDropdown;
