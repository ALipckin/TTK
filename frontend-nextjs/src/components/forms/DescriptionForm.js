'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/WideButton';
import './data.css';
import TrashForm from '@/components/buttons/TrashForm';
import ActionIconButton from '@/components/buttons/ActionIconButton'
import "./ttk.css"

export default function DescriptionForm({header, apiTable, params }) {
    const [data, setData] = useState([]); // Инициализируем как массив
    const [responseData, setResponseData] = useState([]); // Инициализируем как массив
    const [errors, setErrors] = useState({});
    const [toDelete, setToDelete] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${API_ROUTES.TTKS}/${params.id}/${apiTable}`, {
                    withCredentials: true,
                });
                if(response.data.data.length){
                    setData(response.data.data)
                }
                else{

                }
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
        if(data.length === 0){
            setData([{description: '', isNew: true}])
            setResponseData([{description: '', isNew: true}])
        }
    }, [params.id]);

    const validate = () => {
        const validationErrors = {};
        data.forEach((item, index) => {
            if (!item.description) {
                validationErrors[`description_${index}`] = 'Поле обязательно для заполнения';
            }
        });
        return validationErrors;
    };

    const handleChange = (index, e) => {
        const { name, value } = e.target;

        setData(prevData => {
            const updatedData = prevData.map((item, i) =>
                i === index ? { ...item, [name]: value} : item
            );

            // Проверяем изменения
            const changes = updatedData.map((item, i) => {
                const originalItem = responseData[i];
                return {
                    ...item,
                    isChanged: item.description !== originalItem?.description || item.isNew
                };
            });

            return changes;
        });
    };
    const submitForm = async () => {
        const validationErrors = validate();
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }

        try {
            // Фильтрация и очистка измененных данных
            const changedData = data
                .filter(item => item.isChanged && !item.isNew)
                .map(({ isNew, isChanged, ...rest }) => rest);

            // Фильтрация и очистка новых данных
            const newData = data
                .filter(item => item.isNew)
                .map(({ isNew, isChanged, ...rest }) => rest);

            // Создаем массив запросов для измененных данных
            if(changedData.length > 0) {
                const changeRequests = changedData.map(item =>
                    axios.patch(`${API_ROUTES.TTKS}/${params.id}/${apiTable}/${item.id}`, item, { withCredentials: true })
                );
                // Отправка запросов для измененных данных параллельно
                await Promise.all(changeRequests);
            }

            // Параллельное выполнение запросов для новых данных
            if (newData.length > 0) {
                const createRequests = newData.map(item =>
                    axios.post(`${API_ROUTES.TTKS}/${params.id}/${apiTable}`, item, { withCredentials: true })
                );
                await Promise.all(createRequests);
            }

            toDelete.map(item =>
                console.log("delete = "),

            )
            console.log("deleting ")
            if (toDelete.length > 0) {
                const deleteRequests = toDelete.map(id =>
                    axios.delete(`${API_ROUTES.TTKS}/${params.id}/${apiTable}/${id}`, { withCredentials: true })
                );
                await Promise.all(deleteRequests);
            }

            window.location.reload();

        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                setErrors({ submit: error.message });
            }
        }
    };
    const addNewDescription = () => {
        setData(prevData => [...prevData, { description: '', isNew: true }]);
    };

    const clearInputs = () => {
        // Создаем новый массив, исключая элементы, которые нужно удалить
        const idsToDelete = data.map(item => item.id);
        setToDelete(idsToDelete);

        // Удаляем все элементы из data и responseData
        setData([]);
        setResponseData([]);
    };
    const deleteRecord = (index) => {
        const idToDelete = data[index]?.id;
        if (idToDelete) {
            setToDelete(prevToDelete => [...prevToDelete, idToDelete]);
        }

        setData(prevData => prevData.filter((_, i) => i !== index));}
    return (
        <div className="container">
            <div className="d-flex justify-content-center">
                <div className="row col-12 col-md-8 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <div className="d-flex justify-content-between">
                            <div className=""></div>
                            <h3 className="mh mb-5 title">{header}</h3>
                            <ActionIconButton img="/images/add.svg" className="" onClick={addNewDescription}/>
                        </div>
                        <div className="row flex-column">
                            {Array.isArray(data) && data.map((item, index) => (
                                <div className="mb-4" key={index}>
                                    <InputBox
                                        name="description"
                                        placeholder="Область применения"
                                        value={item.description}
                                        type="text"
                                        onChange={(e) => handleChange(index, e)}
                                        errors={errors[`description_${index}`]}
                                        id={item.id}
                                        onDeleteButton={() => deleteRecord(index)}
                                    />
                                </div>
                            ))}
                            <div className="d-flex justify-content-center">
                                <WideButton type="button" onClick={submitForm}>Сохранить</WideButton>
                            </div>
                            <TrashForm confirmEvent={clearInputs} />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
