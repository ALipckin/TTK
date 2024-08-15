import "./Trash.css";
import React, { useState } from 'react';
import WideButton from '@/components/buttons/WideButton'
import TrashButton from '@/components/buttons/TrashButton'
const TrashForm = (props) => {
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
            <TrashButton onClick={handleDeleteClick}/>
            {isOpen && (
                <div className="confirm-box row col-12 d-flex justify-content-center">
                    <p>Вы действительно хотите удалить весь текст?</p>
                    <div className="d-flex justify-content-between">
                        <div className="col-6 d-flex justify-content-center">
                            <WideButton type="button"  onClick={handleConfirmDelete} className="pt-1 pb-1"  iconSrc="/images/mainPage/white-fire.svg">Удалить</WideButton>
                        </div>
                        <div className="col-6 d-flex justify-content-center">
                            <WideButton type="button" onClick={handleCancel} className="pt-1 pb-1 cancel" iconSrc="/images/mainPage/white-fire.svg">Отмена</WideButton>
                        </div>
                    </div>
                </div>
            )}
        </div>

    )
}

export default TrashForm;
