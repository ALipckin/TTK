import ActionButton from "../buttons/actionIconButton";
import React from "react";

const EditAction = ({apiUrl, id }) => {
    const handleEdit = () => {
        // Логика редактирования, возможно вызов модального окна
        console.log(`Editing item with UUID: ${id}`);
    };

    return <ActionButton img={`/images/edit.svg`} alt="edit" onClick={handleEdit}/>;
};

export default EditAction;
