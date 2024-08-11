import ConstItem from "./constItem";
import IconItem from "./iconItem";
import axios from 'axios'
import { API_ROUTES } from '@/components/apiRoutes'
import ReactModal from 'react-modal';
import React, { useState } from 'react';
import { redirect } from 'next/navigation'
import "./profileDataList.css"
const profileDataList = (data) => {
    console.log(data);
    data = data.data;
    var dateObject = new Date(data.created_at);
    const registrationDate= ("0" + dateObject.getDate()).slice(-2)+ "." +
        ("0" + (dateObject.getMonth() + 1)).slice(-2) + "."
        + dateObject.getFullYear();
    const lastVisit = "10.10.2024" ?? 0;
    const views = "6" ?? 0;
    const worksNum = data.ttk_num ?? 0;
    const downloadsNum = data.downloads_num ?? 0;
    const draftsNum = data.draft_num ?? 0;
    const productsNum = data.product_num ?? 0;
    const [newTtkId, setTtkId] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [error, setError] = useState(null);
    const openModal = () => {
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    const [name, setName] = useState(''); // Используйте useState для хранения значения поля Name

    const handleCreateTTK = async () => {
        try {
            const response = await axios.post(API_ROUTES.TTKS, {name}, {withCredentials: true});
            const ttkId = response.data.data.id;
            console.log(response.data);
            console.log(response.data.data);
            console.log(response.data.data.id);
            if(response.data.data.id) {
                redirect(`/ttks/${ttkId}/menu/`); // Замените на ваш путь к странице с технико-технологической картой
            }
        } catch (error) {
            if (error.response.status !== 419) throw error;
            setError(error.response.data.errors);
        }
    };

    return (
        <div>
            <div className="mt-4 d-flex flex-column justify-content-start">
                <ul className="mb-2 p-0">
                    <ConstItem title="Дата регистрации" data={registrationDate} />
                    <ConstItem title="Последний визит" data={lastVisit} />
                    <ConstItem title="Просмотры" data={views} />
                </ul>
                <ul className="p-0">
                    <IconItem title="Мои работы" data={worksNum} img={`/images/picture.svg`} />
                    <IconItem title="Черновики" data={draftsNum} img={`/images/edit.svg`} />
                    <IconItem title="Мои список продуктов" data={productsNum} img={`/images/radish.svg`} />
                    <IconItem title="Создать новую карту" img={`/images/add.svg`} onClick={openModal}/>
                </ul>
                <ReactModal
                    isOpen={isModalOpen}
                    onRequestClose={closeModal}
                    style={{

                        overlay: {
                            // Стили для фона модального окна
                            backgroundColor: 'rgba(0, 0, 0, 0.75)',
                            zIndex: 1000,
                        },
                        content: {
                            // Стили для содержимого модального окна
                            top: '50%',
                            left: '50%',
                            right: 'auto',
                            bottom: 'auto',
                            marginRight: '-50%',
                            transform: 'translate(-50%, -50%)',
                            width: '50%', // Ширина модального окна
                            maxWidth: '500px', // Максимальная ширина модального окна
                            minWidth: '300px', // Минимальная ширина модального окна
                        },
                    }}
                    contentLabel="Модальное окно"
                >
                    <h1>Создание технико технологической карты</h1>
                    <p className="m-1">Наименование</p>
                    <input className="modal-input" value={name} onChange={(event) => setName(event.target.value)} />
                    <div className="d-flex justify-content-between mt-3">
                        <button onClick={handleCreateTTK} className="modal-btn">Создать</button>
                        <button onClick={closeModal} className="modal-btn">Закрыть</button>
                    </div>
                </ReactModal>
            </div>
        </div>
    );
}

export default profileDataList;
