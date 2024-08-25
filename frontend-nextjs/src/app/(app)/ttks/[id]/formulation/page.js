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
import { forEach } from 'react-bootstrap/ElementChildren'

export default function Page({params }) {
    const [formulationData, setFormulationData] = useState([
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
    const [currInitialTreatments, setCurrInitialTreatments] = useState([]);
    const [responseInitialTreatments, setResponseInitialTreatments] = useState([]);
    const [responseHeatTreatments, setResponseHeatTreatments] = useState([]);
    const [currHeatTreatments, setCurrHeatTreatments] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${API_ROUTES.TTKS}/${params.id}/${apiTable}`, {
                    withCredentials: true,
                });
                if (response.data.data.length) {
                    const data = response.data.data;

                    const formulations = data.map(item => item.formulation);
                    const heatTreatments = data.map(item => item.heat_treatments);
                    const initialTreatments = data.map(item => item.initial_treatments);

                    // Установка состояния
                    setFormulationData(formulations);
                    setCurrHeatTreatments(heatTreatments);
                    setResponseHeatTreatments(heatTreatments);
                    setCurrInitialTreatments(initialTreatments);
                    setResponseInitialTreatments(initialTreatments);
                    setResponseData([data]);
                } else {
                    setFormulationData([{ description: '', isNew: true }]);
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
        console.log("data =" + formulationData)
        const validationErrors = {};
        formulationData.forEach((record, i) => {
            if (!record.product_id) validationErrors.product_id = 'Выберите продукт';
            if (!record.package_id) validationErrors.package_id = 'Выберите тип упаковки';
            if (!record.brutto) validationErrors.brutto = 'Поле брутто обязательно для заполнения';
            if (!record.netto) validationErrors.netto = 'Поле нетто обязательно для заполнения';
        });

        return validationErrors;
    };

    const handleFormulationChange = (index, e, name = null, value = null) => {
        console.log("handling changes");
        if(e && e.target)
        {
            ({ name, value } = e.target);
        }
        console.log("name = "+ name);
        console.log("value = "+ value);
        setFormulationData(prevData => {
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

    // Универсальная функция для обработки изменений
    const handleChange = (updateStateFunction, responseData, index, j, e, name = null, value = null) => {
        // Если event объект существует, извлекаем name и value
        if (e && e.target) {
            ({ name, value } = e.target);
        }

        updateStateFunction(prevData => {
            // Обновляем данные с учетом изменений
            const updatedData = prevData.map((outerArray, i) => {
                if (i === index) {
                    // Обрабатываем внутренний массив по индексу j
                    const updatedInnerArray = outerArray.map((innerItem, innerIndex) => {
                        if (innerIndex === j) {
                            return { ...innerItem, [name]: value };
                        }
                        return innerItem;
                    });
                    return updatedInnerArray;
                }
                return outerArray;
            });
            console.log("updatedData = " + updatedData);
            // Проверяем изменения по сравнению с responseData
            const changes = updatedData.map((outerArray, i) => {
                const originalOuterArray = responseData[i];
                if (i === index) {
                    const updatedInnerArray = outerArray.map((innerItem, innerIndex) => {
                        const originalInnerItem = originalOuterArray[innerIndex];
                        return {
                            ...innerItem,
                            isChanged: innerItem[name] !== originalInnerItem?.[name] || innerItem.isNew
                        };
                    });
                    return updatedInnerArray;
                }
                return outerArray.map((innerItem, innerIndex) => {
                    const originalInnerItem = originalOuterArray[innerIndex];
                    return {
                        ...innerItem,
                        isChanged: innerItem[name] !== originalInnerItem?.[name] || innerItem.isNew
                    };
                });
            });

            return changes;
        });

    };

    const removeHeatTreatment = (itemIndex, treatmentIndex) => {
        setFormulationData(prevData => {
            const newData = [...prevData];
            newData[itemIndex] = {
                ...newData[itemIndex],
                heat_treatments: newData[itemIndex].heat_treatments.filter((_, i) => i !== treatmentIndex)
            };
            return newData;
        });
    };

    const removeInitialTreatment = (itemIndex, treatmentIndex) => {
        setFormulationData(prevData => {
            const newData = [...prevData];
            newData[itemIndex] = {
                ...newData[itemIndex],
                initial_treatments: newData[itemIndex].initial_treatments.filter((_, i) => i !== treatmentIndex)
            };
            return newData;
        });
    };

    const submitData = async () => {
        await submitFormulationData();
        await submitHeatTreatmentData();
    }
    const submitFormulationData = async () => {
        const validationErrors = validate();
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }
        try {
            console.log("sumbit");
            // Фильтрация и очистка измененных данных
            const changedFormulationData = formulationData
                .filter(item => item.isChanged && !item.isNew)
                .map(({ isNew, isChanged, ...rest }) => rest);

            // Фильтрация и очистка новых данных
            const newFormulationData = formulationData
                .filter(item => item.isNew)
                .map(({ isNew, isChanged, ...rest }) => rest);

            // Создаем массив запросов для измененных данных
            if(changedFormulationData.length > 0) {
                const changeRequests = changedFormulationData.map(item =>
                    axios.patch(`${API_ROUTES.TTKS}/${params.id}/${apiTable}/${item.id}`, item, { withCredentials: true })
                );
                // Отправка запросов для измененных данных параллельно
                await Promise.all(changeRequests);
            }

            // Параллельное выполнение запросов для новых данных
            if (newFormulationData.length > 0) {
                const createRequests = newFormulationData.map(item =>
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

    const submitHeatTreatmentData = async () => {
        const validationErrors = validate();
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }
        try {
            // Логирование текущих данных
            console.log("Current heat treatments:", currHeatTreatments);

            // Извлечение всех элементов из вложенных массивов
            const flattenedHeatTreatments = currHeatTreatments.flat();

            // Фильтрация измененных данных
            const changedHeatTreatmentData = flattenedHeatTreatments
                .filter(item => item.isChanged && !item.isNew)
                .map(({ isNew, isChanged, ...rest }) => rest);
            console.log("Changed heat treatments:", changedHeatTreatmentData);

            // Фильтрация новых данных
            const newHeatTreatmentData = flattenedHeatTreatments
                .filter(item => item.isNew)
                .map(({ isNew, isChanged, ...rest }) => rest);
            console.log("New heat treatments:", newHeatTreatmentData);

            // Отправка запросов для измененных данных
            if (changedHeatTreatmentData.length > 0) {
                const changeRequests = changedHeatTreatmentData.map((item, i) => {
                        const formulationId = formulationData[i]?.id;
                        axios.post(
                            API_ROUTES.PATCH_HEAT_TREATMENTS(params.id, formulationId),
                            { heat_treatments: [item] }, // Отправляем каждый объект в массиве
                            { withCredentials: true }
                        )
                    }
                );
                await Promise.all(changeRequests);
                console.log('All heat treatments updated successfully');
            } else {
                console.log('No heat treatments to update');
            }

            // Отправка запросов для новых данных
            if (newHeatTreatmentData.length > 0) {
                const createRequests = newHeatTreatmentData.map((item, i) => {
                    const formulationId = formulationData[i]?.id;
                    axios.post(
                        API_ROUTES.PATCH_HEAT_TREATMENTS(params.id, formulationId),
                        { heat_treatments: [item] }, // Отправляем каждый объект в массиве
                        { withCredentials: true }
                    )
                }
                );
                await Promise.all(createRequests);
                console.log('All new heat treatments created successfully');
            }

            // Отправка запросов для удаленных данных
            if (toDelete.length > 0) {
                const deleteRequests = toDelete.map(id =>
                    axios.delete(`${API_ROUTES.TTKS}/${params.id}/${apiTable}/${id}`, { withCredentials: true })
                );
                await Promise.all(deleteRequests);
                console.log('All heat treatments deleted successfully');
            }

        } catch (error) {
            console.error('Error submitting heat treatment data:', error);
        }
    };

    const addNewRecord = () => {
        setFormulationData(prevData => [
            ...prevData, { product_id: '', initial_treatment: [],
                heat_treatment: [], package_id: '',package_name: '',
                product_name:'', brutto: '', netto: '', isNew: true }
        ]);
    };
    const addNewInitialTreatment = (outerIndex) => {
        setCurrInitialTreatments(prevTreatments => {
            // Клонируем массив, чтобы не мутировать оригинальный
            const newTreatments = prevTreatments.map((innerArray, index) => {
                if (index === outerIndex) {
                    // Если это нужный вложенный массив, добавляем новый элемент
                    return [...innerArray, { id: '', title: '', isNew: true }];
                }
                // Иначе возвращаем как есть
                return innerArray;
            });
            return newTreatments;
        });
    };

    const addNewHeatTreatment = (outerIndex) => {
        setCurrHeatTreatments(prevTreatments => {
            // Клонируем массив, чтобы не мутировать оригинальный
            const newTreatments = prevTreatments.map((innerArray, index) => {
                if (index === outerIndex) {
                    // Если это нужный вложенный массив, добавляем новый элемент
                    return [...innerArray, { id: '', title: '', isNew: true }];
                }
                // Иначе возвращаем как есть
                return innerArray;
            });
            return newTreatments;
        });
    };
    const clearInputs = () => {
        // Создаем новый массив, исключая элементы, которые нужно удалить
        const idsToDelete = formulationData.map(item => item.id);
        setToDelete(idsToDelete);

        // Удаляем все элементы из data и responseData
        setFormulationData([]);
        setResponseData([]);
    };
    const deleteRecord = (index) => {
        const idToDelete = formulationData[index]?.id;
        if (idToDelete) {
            setToDelete(prevToDelete => [...prevToDelete, idToDelete]);
        }

        setFormulationData(prevData => prevData.filter((_, i) => i !== index));
    }
    const SumItems = (itemName) => {
        // Сумма элементов массива с определенным названием
        let sum = 0;
        if(formulationData.length > 0) {
            formulationData.forEach(item => {
                sum += parseFloat(item[itemName]) || 0; // Преобразуем в число, если не число, используем 0
            });
        }
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
                                {Array.isArray(formulationData) && formulationData.map((item, index) => (
                                    <tr scope="row" className="mb-4" key={index}>
                                        <td>
                                            <SearchPopup className="select-button" itemName={"name"} apiRoute={API_ROUTES.GET_PRODUCTS} currItem={item.product_name}
                                                         setSelectedItemId={(id) => handleFormulationChange(index, null, "product_id", id)}
                                            />
                                        </td>
                                        <td>
                                            <div className="d-flex justify-content-between">
                                                {
                                                    Array.isArray(currInitialTreatments[index]) && currInitialTreatments[index].map((init, j) => (
                                                        <PopupBox
                                                            onMainButtonClick={() => getInitialTreatments(item.product_id, index)}
                                                            className="select-button" data={initialTreatmentData?.[index]}
                                                            itemName={'title'} currItem={init.title}
                                                            setSelectedItemId={(id) => handleChange(setCurrInitialTreatments, responseInitialTreatments, index, j, null, 'id', id)}
                                                        />
                                                    ))
                                                }
                                                <ActionIconButton img="/images/add.svg" className=""
                                                                  onClick={() => addNewInitialTreatment(index)} />
                                            </div>
                                        </td>
                                        <td>
                                            <div className="d-flex justify-content-between">
                                            {
                                                Array.isArray(currHeatTreatments[index]) && currHeatTreatments[index].map((heat, j) => (
                                                        <PopupBox
                                                            onMainButtonClick={() => getHeatTreatments(item.product_id, index)}
                                                            className="select-button" data={heatTreatmentData?.[index]}
                                                            itemName={'title'} currItem={heat.title}
                                                            setSelectedItemId={(id) => handleChange(setCurrHeatTreatments, responseHeatTreatments, index, j, null, 'id', id)}
                                                        />
                                                    ))
                                                }
                                            <ActionIconButton img="/images/add.svg" className=""
                                                              onClick={() => addNewHeatTreatment(index)} />
                                            </div>
                                        </td>
                                        <td>
                                            <PopupBox className="select-button" data={packageData} itemName={"title"} currItem={item.package_name}
                                                      setSelectedItemId={(id) => handleFormulationChange(index, null, "package_id", id)}
                                            />
                                        </td>
                                        <td>
                                            <TtkInput name="brutto" type="text" value={item.brutto} onChange={(e) => handleFormulationChange(index, e)}/>
                                        </td>
                                        <td>
                                            <TtkInput name="netto" type="text" value={item.netto} onChange={(e) => handleFormulationChange(index, e)}/>
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
                                <WideButton type="button" onClick={() => submitData()}>Сохранить</WideButton>
                            </div>
                            <TrashForm confirmEvent={clearInputs} />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
