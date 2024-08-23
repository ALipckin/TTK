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
import InputError from '@/components/errors/TtkError'

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
    const [initialTreatmentData, setInitialTreatmentsData] = useState([]);
    const [heatTreatmentData, setHeatTreatmentsData] = useState([]);

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
                const packages = await axios.get(API_ROUTES.GET_PACKAGES, {
                    withCredentials: true,
                });
                if (packages.data.data.length) {
                    setPackageData(packages.data.data);
                }
    
                const initialTreatments = await axios.get(API_ROUTES.GET_INITIAL_TREATMENTS(id), {
                    withCredentials: true,
                });
                if (initialTreatments.data.data.length) {
                    setInitialTreatmentsData(initialTreatments.data.data); 
                }
    
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
    }, []);
    
    const getHeatTreatments = async (productId, index) => {
        try{
            const heatTreatments = await axios.get(API_ROUTES.GET_HEAT_TREATMENTS(productId), {
                withCredentials: true,
            });
            if (heatTreatments.data.data.length) {
                setHeatTreatmentsData(prevData => ({
                    ...prevData,
                    [index]: heatTreatments.data.data,
                }));
            }
        } catch (err) {
            setErrors({ fetch: err.message });
        }
    }

    const getInitialTreatments = async (productId, index) => {
        try{
            const initialTreatments = await axios.get(API_ROUTES.GET_INITIAL_TREATMENTS(productId), {
                withCredentials: true,
            });
            if (initialTreatments.data.data.length) {
                setInitialTreatmentsData(prevData => ({
                    ...prevData,
                    [index]: initialTreatments.data.data,
                })); 
            }
        } catch (err) {
            setErrors({ fetch: err.message });
        }
    }

    const validate = () => {
        console.log("data =" + data)
        const validationErrors = {};
        data.forEach((record, i) => {
            if (!record.product_id) validationErrors.product_id = 'Выберите продукт';
            if (!record.package_id) validationErrors.package_id = 'Выберите тип упаковки';
            if (!record.brutto) validationErrors.brutto = 'Поле брутто обязательно для заполнения';
            if (!record.netto) validationErrors.netto = 'Поле нетто обязательно для заполнения';
        });

        return validationErrors;
    };

    const handleChange = (index, e, name = null, value = null) => {
        console.log("handling changes");
      
        if(e && e.target)
        {
            ({ name, value } = e.target);
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
                    isChanged: item[name] !== originalItem?.[name] || item.isNew
                };
            });

            return changes;
        });
    };

    const submitForm = async () => {
        const validationErrors = validate();
        if (Object.keys(validationErrors).length > 0) {
            console.log("error");
            setErrors(validationErrors);
            console.log("val errors =" + validationErrors);
            return;
        }
        try {
            console.log("sumbit");
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
    const addNewRecord = () => {
        setData(prevData => [...prevData, { product_id: '',package_id: '',package_name: '', product_name:'', brutto: '', netto: '', isNew: true }]);
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
    const SumItems = (itemName) => {
        // Сумма элементов массива с определенным названием
        let sum = 0;
        data.forEach(item => {
            sum += parseFloat(item[itemName]) || 0; // Преобразуем в число, если не число, используем 0
        });
        return Math.round(sum * 100)/100;
    };

    return (
        <div className="container">
            <div className="d-flex justify-content-center">
                <div className="row col-12 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <div className="d-flex justify-content-between">
                            <div className=""></div>
                            <h2 className="mb-5 title">{header}</h2>
                            <ActionIconButton img="/images/add.svg" className="" onClick={addNewRecord}/>
                        </div>
                        <div className="row flex-column">
                            <table class="bg-transparent">
                                <thead>
                                <tr>
                                    <th scope="col" >Наименование</th>
                                    <th scope="col">Первичная обработка</th>
                                    <th scope="col">Тепловая обработка</th>
                                    <th scope="col">Упаковка</th>
                                    <th scope="col">Брутто г.</th>
                                    <th scope="col">Нетто г.</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                {Array.isArray(data) && data.map((item, index) => (
                                    <tr scope="row" className="mb-4" key={index}>
                                        <td>
                                            <SearchPopup className="select-button" itemName={"name"} apiRoute={API_ROUTES.GET_PRODUCTS} currItem={item.product_name}
                                                         setSelectedItemId={(id) => handleChange(index, null, "product_id", id)}
                                            />
                                        </td>
                                        <td>
                                        {
                                            Array.isArray(item.initial_treatments) && item.initial_treatments.map((init, j) => (
                                                <PopupBox onMainButtonClick={()=> getInitialTreatments(item.product_id, index)} className="select-button" data={initialTreatmentData?.[index]} itemName={"title"} currItem={init.title}
                                                        setSelectedItemId={(id) => handleChange(index, null, "initial_treatments", id)}
                                                />
                                            ))
                                        }
                                        </td>
                                
                                        <td>
                                            {
                                                Array.isArray(item.heat_treatments) && item.heat_treatments.map((heat, j) => (
                                                    <PopupBox onMainButtonClick={() => getHeatTreatments(item.product_id, index)} className="select-button" data={heatTreatmentData?.[index]} itemName={"title"} currItem={heat.title}
                                                            setSelectedItemId={(id) => handleChange(index, null, "heat_treatments", id)}
                                                    />
                                                ))
                                            }
                                        </td>
                                        <td>
                                            <PopupBox className="select-button" data={packageData} itemName={"title"} currItem={item.package_name}
                                                      setSelectedItemId={(id) => handleChange(index, null, "package_id", id)}
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
                                <tr scope="row" className="mb-4" >
                                    <td className='text-end'>
                                        <b>
                                            Итого
                                        </b>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                       <b>
                                            {SumItems("brutto")}
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            {SumItems("netto")}
                                        </b>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="bg-transparent mt-2" border="1">
                                <thead>
                                    <tr>
                                        <th>
                                            Выход на порцию
                                        </th>
                                        <th>
                                            -
                                        </th>
                                        <th>
                                            3.4
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <div className="mt-1 mb-1 d-flex justify-content-center flex-column text-center">
                                {Object.keys(errors).map(key => (
                                    <InputError key={key} messages={errors[key]} />
                                ))}
                            </div>
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
