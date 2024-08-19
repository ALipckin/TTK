'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/WideButton';
import '@/components/forms/data.css';
import TrashForm from '@/components/buttons/TrashForm';
import ActionIconButton from '@/components/buttons/ActionIconButton'
import "@/components/forms/ttk.css"
import "./formulation.css"
import SearchPopup from '@/components/popup/SearchPopup'
import PopupBox from '@/components/popup/PopupBox'
import WideInput from '@/components/Inputs/WideInput'
import TtkInput from '@/components/Inputs/TtkInput'
export default function Page({params }) {
    const [data, setData] = useState([
        {netto: '', brutto: '', package: '', product_id: ''}
    ]); // Инициализируем как массив
    const [responseData, setResponseData] = useState([]); // Инициализируем как массив
    const [errors, setErrors] = useState({});
    const [toDelete, setToDelete] = useState([]);
    const header = "Рецептура";
    const apiTable = "formulations";
    const [packageData, setPackageData] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${API_ROUTES.TTKS}/${params.id}/${apiTable}`, {
                    withCredentials: true,
                });
                if (response.data.data.length) {
                    setData(response.data.data);
                    setResponseData(response.data.data);
                } else {
                    setData([{ description: '', isNew: true }]);
                    setResponseData([{ description: '', isNew: true }]);
                }
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
    }, [params.id, apiTable]);


    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.GET_PACKAGES, {
                    withCredentials: true,
                });
                if (response.data.data.length) {
                    setPackageData(response.data.data);
                }
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
    }, []);

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
        let name, value

        if(e.target) {
            ({ name, value } = e.target);
        }
        else{
            ({name, value} = e);
        }
        console.log("name = "+ name);
        console.log("value = "+ value);
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

            //window.location.reload();

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

        setData(prevData => prevData.filter((_, i) => i !== index));
    }

    return (
        <div className="container">
            <div className="d-flex justify-content-center">
                <div className="row col-12 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <div className="d-flex justify-content-between">
                            <div className=""></div>
                            <h3 className="mh mb-5 title">{header}</h3>
                            <ActionIconButton img="/images/add.svg" className="" onClick={addNewDescription}/>
                        </div>
                        <div className="row flex-column">
                            <table class="table" border="1">
                                <thead>
                                <tr>
                                    <th scope="col" >Наименование</th>
                                    <th scope="col">Упаковка</th>
                                    <th scope="col">Брутто г.</th>
                                    <th scope="col">Нетто г.</th>
                                    <th scope="col">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                {Array.isArray(data) && data.map((item, index) => (
                                    <tr scope="row" className="mb-4" key={index}>
                                        <td>
                                            <SearchPopup className="select-button" itemName={"name"} apiRoute={API_ROUTES.GET_PRODUCTS} currItem={item.product_name}
                                                         setSelectedItemId={(id) => handleChange(index, ({ product_id: id }))}
                                            />
                                        </td>
                                        <td>
                                            <PopupBox className="select-button" data={packageData} itemName={"title"} currItem={item.package_name}
                                                      setSelectedItemId={(id) => handleChange(index, ({ package_id: id }))}
                                            />
                                        </td>
                                        <td>
                                            <TtkInput name="brutto" type="text" value={item.brutto} onChange={(e) => handleChange(index, e)}/>
                                        </td>
                                        <td>
                                            <TtkInput name="netto" type="text" value={item.netto} onChange={(e) => handleChange(index, e)}/>
                                        </td>
                                        <td onClick={() => deleteRecord(index)}><ActionIconButton img="/images/minus.svg" className=""/></td>
                                    </tr>
                                ))
                                }
                                </tbody>
                            </table>

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
