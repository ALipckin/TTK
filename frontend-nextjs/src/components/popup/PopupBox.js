// components/PopUpSearchButton.js
import { useState, useRef, useEffect } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes'
import "./Popup.css"
import ActionIconButton from '@/components/buttons/ActionIconButton'
const PopupBox = ({data, itemName, newSelectedItem, currItem, onMainButtonClick, setSelectedItemId, children, outerIsVisibile = false, outerSetIsVisible}) => {
    const [isVisible, setIsVisible] = useState(false);
    const [selectedItem, setSelectedItem] = useState(false);
    if(newSelectedItem){
        setSelectedItem(newSelectedItem);
    }

    const popUpRef = useRef(null); // Ссылка на попап
    const buttonRef = useRef(null); // Ссылка на кнопку

    const handleClick = () => {
        if(onMainButtonClick) {
            onMainButtonClick();
        }
        setIsVisible(!isVisible);
        if(outerSetIsVisible) {
            outerSetIsVisible(!isVisible);
        }
        };

    const handleClose = () => {
        setIsVisible(false);
    };
    const setItem = (item) => {
        setSelectedItem(item[itemName]);
        setSelectedItemId(item.id);
        setIsVisible(false);
    }
    // Закрыть попап, если кликнули вне его
    useEffect(() => {
        const handleClickOutside = (event) => {
            // Проверяем, что клик был вне кнопки и попапа
            if (
                buttonRef.current && !buttonRef.current.contains(event.target) &&
                popUpRef.current && !popUpRef.current.contains(event.target)
            ) {
                setIsVisible(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    return (
        <div style={{ position: 'relative' }}>
            <button className="main-popup-button btn btn-secondary dropdown-toggle" ref={buttonRef} onClick={handleClick}>
                {selectedItem ? selectedItem : currItem}
            </button>
            {isVisible && outerIsVisibile && (
                <div className="main-window" ref={popUpRef}>
                    {data ? <ul className={"m-0 p-0"}>
                        {data.map((item, index) => (
                            <li className="item" key={index} onClick={() => setItem(item)}>{item[itemName]}</li>
                        ))}
                    </ul>
                        : null
                    }
                    {children}
                </div>
            )}
        </div>
    );
};

export default PopupBox;
