import ActionButton from "../buttons/ActionIconButton";
import React, {useState} from "react";
import axios from "axios";
import ConfirmModal from "@/components/modals/ConfirmModal";
import WideButton from "@/components/buttons/WideButton";
import {format} from "date-fns";
import {API_ROUTES} from "@/components/apiRoutes";

const DeleteAction = ({actionRoute }) => {
    const [response, setResponse] = useState(null);
    const [isModalVisible, setModalVisible] = useState(false);
    const [error, setError] = useState(false)
    const handleDelete = () => {
        const fetchData = async () => {
            try {
                console.log("deleting")
                console.log("route = " + actionRoute)
                if (actionRoute) {
                    // Если есть ID, делаем PATCH запрос
                    const response = await axios.delete(actionRoute, {
                        withCredentials: true
                    });
                    if(response.status === 204) {
                        window.location.reload();
                    }
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    setError(error.response.data.message || {});
                }
            }
        }
        fetchData();
    };
    // Логика удаления, возможно вызов модального окна
    const showModal = () => setModalVisible(true);
    const hideModal = () => setModalVisible(false);

    return (
    <>
        <ActionButton img={`/images/trash.svg`} alt="delete" onClick={showModal} />
        <ConfirmModal isVisible={isModalVisible} onClose={hideModal}>
            <h2>Удаление</h2>
            <p>Вы уверенны что хотите удалить работу?</p>
            <div className="d-flex justify-content-around">
                <button onClick={handleDelete} className="confirm-button btn btn-danger">Удалить</button>
                <button onClick={hideModal} className="cancel-button btn btn-secondary">Отмена</button>
            </div>

        </ConfirmModal>
    </>
    );
};

export default DeleteAction;
