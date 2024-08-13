'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/wide-button';
import '../data.css';
import Trash from '@/components/buttons/Trash'
export default function Page({ params }) {
    const [data, setData] = useState({
        description: '',
    });
    const [startDate, setStartDate] = useState(new Date());
    const [errors, setErrors] = useState({});

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${API_ROUTES.TTKS}/${params.id}/scope`, {
                    withCredentials: true,
                });
                setData(response.data.data || {});
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
    }, [params.id]);

    const validate = () => {
        const validationErrors = {};
        if (!data.description) validationErrors.description = 'Поле обязательно для заполнения';// Добавьте проверки для других полей по необходимости
        return validationErrors;
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setData(prevData => ({ ...prevData, [name]: value }));
    };

    const submitForm = async () => {
        const validationErrors = validate();
        if (Object.keys(validationErrors).length > 0) {
            console.log("errors")
            setErrors(validationErrors);
            return;
        }
        try {
            data.created_date = format(startDate, 'yyyy-MM-dd');
            if (data?.id) {
                // Если есть ID, делаем PATCH запрос
                await axios.patch(`${API_ROUTES.TTKS}/${params.id}/scopr`, data, { withCredentials: true });
            } else {
                // Если нет ID, делаем POST запрос
                data.ttk_id = params.id
                await axios.post(`${API_ROUTES.TTKS}/${params.id}/scope`, data, { withCredentials: true });
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                setErrors({ submit: error.message });
            }
        }
    };
    const clearInputs = () => {
        setData( '');
    };
    return (
        <div className="container">
            <div className="row d-flex justify-content-center">
                <div className="col-12 col-md-6 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <h3 className="mh text-center title">Шапка документа</h3>
                        <div className="row flex-column">
                            <div className="mb-4">
                                <InputBox
                                    name="scope"
                                    placeholder="Область применения"
                                    value={data.scope}
                                    type="text"
                                    onChange={handleChange}
                                    errors={errors.scope}
                                />
                            </div>
                            <div className="d-flex justify-content-center">
                                <WideButton type="button" text="Сохранить" onClick={submitForm} />
                            </div>
                            <Trash confirmEvent={clearInputs}/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
