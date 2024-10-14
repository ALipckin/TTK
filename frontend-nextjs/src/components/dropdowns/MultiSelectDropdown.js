import React, { useEffect, useRef, useState } from 'react'
import './MultiSelect.css'

const MultiplySelectDropdown = ({ items, itemName, selectedCategories, setSelectedCategories }) => {
    const [isOpen, setIsOpen] = useState(false)
    const [selectedNames, setSelectedNames] = useState('')
    const dropdownRef = useRef(null)

    useEffect(() => {
        const names = getSelectedNames(items, selectedCategories)
        setSelectedNames(names)
    }, [selectedCategories, items])

    function getSelectedNames(items, selectedCategories) {
        let selectedNames = []

        function traverse(item) {
            if (selectedCategories.includes(item.id)) {
                selectedNames.push(item[itemName])
            }

            if (item.children && Array.isArray(item.children)) {
                item.children.forEach(child => traverse(child))
            }
        }

        if (Array.isArray(items)) {
            items.forEach(item => traverse(item))
        }
        return selectedNames.join(', ')
    }

    const handleCategoryChange = (id) => {
        const isSelected = selectedCategories.includes(id)
        if (isSelected) {
            const updatedItems = selectedCategories.filter(itemId => itemId !== id)
            const childrenIds = getAllChildrenIds(id)
            const filtered = updatedItems.filter(itemId => !childrenIds.includes(itemId))
            setSelectedCategories(filtered)
        } else {
            const updatedItems = [...selectedCategories, id]
            const childrenIds = getAllChildrenIds(id)
            setSelectedCategories([...updatedItems, ...childrenIds])
        }
    }

    const getAllChildrenIds = (parentId) => {
        const parentCategory = items.find(category => category.id === parentId)
        if (!parentCategory || !parentCategory.children) return []
        const childrenIds = parentCategory.children.map(child => child.id)
        childrenIds.forEach(childId => {
            childrenIds.push(...getAllChildrenIds(childId))
        })
        return childrenIds
    }

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setIsOpen(false)
            }
        }

        document.addEventListener('mousedown', handleClickOutside)
        return () => {
            document.removeEventListener('mousedown', handleClickOutside)
        }
    }, [])

    const renderCategoryTree = (categories, depth = 0) => {
        return categories.map((category) => (
            <div key={category.id} style={{ paddingLeft: `${depth * 20}px` }}>
                <label className="multi-dropdown-item d-flex align-items-center p-2">
                    <input
                        type="checkbox"
                        checked={selectedCategories.includes(category.id)}
                        onChange={() => handleCategoryChange(category.id)}
                        className="me-2"
                    />
                    {category[itemName]}
                </label>
                {category.children && category.children.length > 0 && (
                    <div>{renderCategoryTree(category.children, depth + 1)}</div>
                )}
            </div>
        ))
    }

    return (
        <div className="position-relative" ref={dropdownRef}>
            <input
                type="text"
                readOnly
                value={selectedNames}
                onClick={() => setIsOpen(!isOpen)}
                placeholder="Выберите элементы"
                className="form-control col-8"
            />
            {isOpen && (
                <div className="multi-dropdown-menu position-absolute bg-white border rounded shadow-lg mt-1">
                    {Array.isArray(items) && renderCategoryTree(items)}
                </div>
            )}
        </div>
    )
}

export default MultiplySelectDropdown
