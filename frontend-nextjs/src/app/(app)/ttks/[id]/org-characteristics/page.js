'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/WideButton';
import '../data.css';
import "react-datepicker/dist/react-datepicker.css";
import { format } from 'date-fns';
import SimpleInput from '@/components/Inputs/SimpleInput'

export default function Page({ params }) {
    const [data, setData] = useState({
        company: '',
        property: '',
        position: '',
        card: '',
    });
    const [errors, setErrors] = useState({});

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.ORG_CHARACTERISTICS(params.id), {
                    withCredentials: true,
                });
                setData(response.data.data);
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
    }, [params.id]);

    const validate = () => {
        const validationErrors = {};
        if (!data.view) validationErrors.company = 'Поле обязательно для заполнения';
        if (!data.color) validationErrors.property = 'Поле обязательно для заполнения';
        if (!data.cons) validationErrors.position = 'Поле обязательно для заполнения';
        if (!data.taste) validationErrors.card = 'Поле обязательно для заполнения';
        // Добавьте проверки для других полей по необходимости
        return validationErrors;
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setData(prevData => ({ ...prevData, [name]: value }));
    };

    const submitForm = async () => {
        const validationErrors = validate();
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }
        try {
            // Если есть ID, делаем PATCH запрос
            await axios.put(API_ROUTES.ORG_CHARACTERISTICS(params.id), data, { withCredentials: true });
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                setErrors({ submit: error.message });
            }
        }
    };

    return (
        <div className="container">
            <div className="row d-flex justify-content-center">
                <div className="col-12 col-md-8">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <h3 className="mh text-center title">Органолептические показатели</h3>
                        <div className="row flex-column">
                            <div className="mb-4">
                                <SimpleInput title="Внешний вид:" name="view" value={data.view} onChange={handleChange} errors={errors.view} />
                                <SimpleInput title="Цвет:" name="color" value={data.color} onChange={handleChange} errors={errors.color} />
                                <SimpleInput title="Консистенция:" name="cons" value={data.cons} onChange={handleChange} errors={errors.cons} />
                                <SimpleInput title="Вкус и запах:" name="taste" value={data.taste} onChange={handleChange} errors={errors.taste} />
                            </div>
                            <div className="d-flex justify-content-center">
                                <WideButton type="button" text="Сохранить" onClick={submitForm} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
