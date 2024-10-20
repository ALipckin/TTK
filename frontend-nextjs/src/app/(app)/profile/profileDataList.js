"use client";
import ConstItem from "./constItem";
import IconItem from "./iconItem";
import axios from 'axios'
import { API_ROUTES } from '@/components/apiRoutes'
import ReactModal from 'react-modal';
import React, { useState } from 'react';
import { redirect } from 'next/navigation'
import "./profileDataList.css"
import { useRouter } from 'next/navigation'
import PopupBox from '@/components/popup/PopupBox'
import MultiSelectDropdown from '@/components/dropdowns/MultiSelectDropdown'
const profileDataList = (data) => {
    data = data.data;
    const dayjs = require('dayjs');
    const registrationDate= dayjs(data.created_at).format('DD.MM.YYYY');
    const lastVisit = dayjs(data.last_visit).format('DD.MM.YYYY HH:mm')+" msk";
    const views = data.views ?? 0;
    const worksNum = data.ttk_num ?? 0;
    const draftsNum = data.draft_num ?? 0;
    const productsNum = data.product_num ?? 0;
    const [isModalOpen, setIsModalOpen] = useState(false);
    const router = useRouter();
    const [ttkCategories, setTtkCategories] = useState([]);
    const [selectedCategories, setSelectedCategories] = useState([])
    const openModal = () => {
        getTtkCategories().then(r => setIsModalOpen(true));

    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    const [name, setName] = useState(''); // Используйте useState для хранения значения поля Name

    const handleCreateTTK = async () => {
            const response = await axios.post(API_ROUTES.TTKS, {name, category_id: selectedCategories[0]}, {withCredentials: true});
            const ttkId = response.data.data.id;
            if(ttkId !== undefined) {
                router.push(`/ttks/${ttkId}`)
            }
    };
    const getTtkCategories = async () => {
        try {
            const response = await axios.get(API_ROUTES.TTKS_CATEGORIES, {
                withCredentials: true
            });
            if (response && response.data) {
                setTtkCategories(response.data.data); // Проверяем, что данные существуют
            }
        } catch (err) {
            alert(err);
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
                    <IconItem title="Мои работы" data={worksNum} img={`/images/picture.svg`} href={"/ttks/my"}/>
                    {/*<IconItem title="Черновики" data={draftsNum} img={`/images/edit.svg`} href={"/drafts/my"}/>*/}
                    <IconItem title="Мои список продуктов" data={productsNum} img={`/images/radish.svg`} href={"/products/my"}/>
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
                            width: '80%', // Ширина модального окна
                            maxWidth: '1000px', // Максимальная ширина модального окна
                            minWidth: '300px', // Минимальная ширина модального окна
                            maxHeight: '1000px', // Минимальная ширина модального окна
                            minHeight: '500px', // Минимальная ширина модального окна
                        },
                    }}
                    contentLabel="Модальное окно"
                >
                    <h1>Создание технико технологической карты</h1>
                    <p className="m-1">Наименование</p>
                    <input className="modal-input" value={name} onChange={(event) => setName(event.target.value)} />
                    <div className="d-flex justify-content-between mt-3">
                        <div className="row d-flex justify-content-start col-12">
                            <div className="mb-3">
                                <p className="p-1 m-0">Категории:</p>
                                <MultiSelectDropdown
                                    items={ttkCategories} itemName={'name'} selectedCategories={selectedCategories}
                                    setSelectedCategories={setSelectedCategories} />
                            </div>
                        </div>
                    </div>
                    <div className="d-flex justify-content-between">
                        <button onClick={handleCreateTTK} className="modal-btn btn btn-success">Создать</button>
                        <button onClick={closeModal} className="modal-btn btn btn-danger">Закрыть</button>
                    </div>
                </ReactModal>
            </div>
        </div>
    );
}

export default profileDataList;
