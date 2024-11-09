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
        {id: '', netto: '', brutto: '', package: '', product_id: '', treatment_id: ''}
    ]); // Инициализируем как массив
    const [errors, setErrors] = useState({});
    const header = "Рецептура";
    const apiTable = "formulations";
    const [treatmentData, setTreatmentsData] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${API_ROUTES.TTKS}/${params.id}/${apiTable}`, {
                    withCredentials: true,
                });
                if (response.data.data.length) {
                    const data = response.data.data;
                    setFormulationData(data);
                    console.log("data = ", data);
                }
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
    }, [params.id, apiTable]);

    const getTreatments = async (productId, index) => {
        try{
            const treatments = await axios.get(API_ROUTES.GET_TREATMENTS(productId), {
                withCredentials: true,
            });
            if (treatments.data.data.length) {
                setTreatmentsData(prevData => ({
                    ...prevData,
                    [index]: treatments.data.data,
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
            if (!record.brutto) validationErrors.brutto = 'Поле брутто обязательно для заполнения';
            if (!record.netto) validationErrors.netto = 'Поле нетто обязательно для заполнения';
        });

        return validationErrors;
    };
    const submitFormulationData = async () => {
        const validationErrors = validate();
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }
        try {
                console.log("formulationData", formulationData);
                const Requests = formulationData.map(item => {
                        console.log("item.id=", item.id);

                        return axios.put(API_ROUTES.PUT_FORMULATION(params.id, item.id > 0 ? item.id : "null"), item, { withCredentials: true })
                    }
                );

                const responses = await Promise.all(Requests);

                // Обновление массива данных с новыми ID
            console.log("responses = ", responses);
                responses.forEach((response, index) => {
                    console.log("response = ", response);
                    const newId = response.data.data.id; // предполагаем, что ID находится в response.data.id
                    formulationData[index].id = newId;
                });

            // if (toDelete.length > 0) {
            //     const deleteRequests = toDelete.map(id =>
            //         axios.delete(`${API_ROUTES.TTKS}/${params.id}/${apiTable}/${id}`, { withCredentials: true })
            //     );
            //     await Promise.all(deleteRequests);
            // }

            //window.location.reload();

        }
        catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                setErrors({ submit: error.message });
            }
        }
    };
    const submitData = async () => {
        await submitFormulationData();
    }

    const addNewRecord = () => {
        setFormulationData(prevData => [
            ...prevData, { product_id: '', formulation_id: '',
                product_name:'', brutto: '', netto: '', isNew: true }]
        );
    };

    const clearInputs = () => {
        // Создаем новый массив, исключая элементы, которые нужно удалить
        formulationData.forEach((_, index) => {deleteRecord(index)})
        // Удаляем все элементы из data и responseData
        setFormulationData([]);
    };
    const deleteRecord = (index) => {
        const idToDelete = formulationData[index]?.id;
        try {
               axios.delete(API_ROUTES.DELETE_FORMULATION(params.id, idToDelete), { withCredentials: true });
        }
         catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                setErrors({ submit: error.message });
            }
        }
    }
    const clearInput = (index) => {
        deleteRecord(index);
        var newFormulation = [...formulationData];
        var array =  newFormulation.filter((item, i) => i !== index);
        setFormulationData(array);
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
    const handleFormulation = (index, itemValue, itemName, float = false) => {
        var newFormulation = [...formulationData];
        console.log("float = ", float);
        if (float) {
            newFormulation[index][itemName] =  itemValue.replace(/,/g, '.');
        } else {
            newFormulation[index][itemName] = itemValue;
        }
        console.log("newFormulation = ", newFormulation);
        setFormulationData(newFormulation);
    }

    return (
        <div className="container">
            <div className="d-flex justify-content-center">
                <div className="row col-12 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <div className="d-flex justify-content-between">
                            <div className="" />
                            <h2 className="mb-5 title">{header}</h2>
                            <ActionIconButton img="/images/add.svg" className="" onClick={addNewRecord}/>
                        </div>
                        <div className="row flex-column">
                            <table className="bg-transparent">
                                <thead>
                                <tr>
                                    <th scope="col" >Наименование</th>
                                    <th scope="col">Обработка</th>
                                    <th scope="col">Брутто г.</th>
                                    <th scope="col">Нетто г.</th>
                                    <th scope="col" />
                                </tr>
                                </thead>
                                <tbody>
                                {Array.isArray(formulationData) && formulationData.map((item, index) => (
                                    <tr scope="row" className="mb-4" key={index}>
                                        <td>
                                            <SearchPopup className="select-button" itemName={"name"} apiRoute={API_ROUTES.GET_PRODUCTS} currItem={item.product_name}
                                                         setSelectedItemId={(id) => handleFormulation(index, id, "product_id")
                                            }
                                            />
                                        </td>
                                        <td>
                                            <PopupBox className="select-button" onMainButtonClick={() => getTreatments(item.product_id, index)} data={treatmentData[index]} itemName={"name"} currItem={item.treatment_name}
                                                      setSelectedItemId={(id) => handleFormulation(index, id, "treatment_id")}
                                            />
                                        </td>
                                        <td>
                                            <TtkInput name="brutto" type="text" value={item.brutto} onChange={(e) => handleFormulation(index, e.target.value, 'brutto', true)}/>
                                        </td>
                                        <td>
                                            <TtkInput name="netto" type="text" value={item.netto} onChange={(e) => handleFormulation(index, e.target.value, 'netto', true)}/>
                                        </td>
                                        <td onClick={() => clearInput(index)}><ActionIconButton img="/images/minus.svg" className=""/></td>
                                    </tr>
                                ))
                                }
                                <tr scope="row" className="mb-4" >
                                    <td className='text-end'>
                                        <b>
                                            Итого, выход на порцию:
                                        </b>
                                    </td>
                                    <td />
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
