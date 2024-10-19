'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/WideButton';
import '../data.css';
import "react-datepicker/dist/react-datepicker.css";
import { format } from 'date-fns';
import SimpleInput from '@/components/Inputs/SimpleInput';
import './phys-chem-params.css';
export default function Page({ params }) {
    const [data, setData] = useState({
    });
    const [errors, setErrors] = useState({});

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.PHYS_CHEM_PARAMS(params.id), {
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
                    <h3 className="mh text-center title">Нормируемые физико-химические показатели</h3>
                    <table>
                        <thead>
                        <tr>
                            <th colSpan="2">Массовая доля сухих в-в, %</th>
                            <th colSpan="2">Массовая доля жира, %</th>
                            <th colSpan="2">Массовая доля, %</th>
                        </tr>
                        <tr>
                            <th>Мин</th>
                            <th>Макс</th>
                            <th>Мин</th>
                            <th>Макс</th>
                            <th>Сахара</th>
                            <th>Соли</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{data.dry?.min ?? null}</td>
                            <td>{data.dry?.max ?? null}</td>
                            <td>{data.fat?.min ?? null}</td>
                            <td>{data.fat?.max ?? null}</td>
                            <td>{data?.sugar ?? null}</td>
                            <td>{data?.salt ?? null}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}
