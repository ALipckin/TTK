import "./Trash.css"
import React, { useState } from 'react';
const Trash = (props) => {
    const [isOpen, setIsOpen] = useState(false); // Состояние для управления отображением окна
    console.log("typeof confirmEvent = " + typeof(confirmEvent));
    const handleDeleteClick = () => {
        setIsOpen(true); // Открыть окно подтверждения
    };

    const handleConfirmDelete = () => {
        setIsOpen(false); // Закрыть окно после удаления
        props.confirmEvent();
    };

    const handleCancel = () => {
        setIsOpen(false); // Закрыть окно без удаления
    };

    return (
        <div>
            <button className="trash-button" onClick={handleDeleteClick}>
                <img src={'/images/trash.svg'} alt={props.alt} className=""/>
            </button>
            {isOpen && (
                <div className="confirm-box">
                    <p>Вы действительно хотите удалить весь текст?</p>
                    <button onClick={handleConfirmDelete} className="confirm-button">
                        Удалить
                    </button>
                    <button onClick={handleCancel} className="cancel-button">
                        Отмена
                    </button>
                </div>
            )}
        </div>

    )
}

export default Trash;
