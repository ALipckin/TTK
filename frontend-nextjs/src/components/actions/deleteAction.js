import ActionButton from "../buttons/ActionIconButton";
import React from "react";

const DeleteAction = ({apiUrl, id }) => {
    const handleDelete = () => {
        // Логика удаления, возможно вызов модального окна
        console.log(`Deleting item with ID: ${id}`);
    };
    return <ActionButton img={`/images/trash.svg`} alt="delete" onClick={handleDelete}/>
};

export default DeleteAction;
