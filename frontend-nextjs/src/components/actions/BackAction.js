import ActionButton from "../buttons/ActionIconButton";
import React from "react";

const BackAction = ({ buttonClassName = "icon-button"  }) => {
    const handleBack = () => {
        window.history.back(); // Возвращаемся на предыдущую страницу
    };

    return <button style={{ backgroundImage: 'url(\'/images/back-arrow.svg\')' }} onClick={handleBack}
                   className={`${buttonClassName}`} />
};

export default BackAction;
