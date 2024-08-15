'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/WideButton';
import InputError from '@/components/errors/TtkError';
import '../data.css';
import './header.css';
import DatePicker from 'react-datepicker'
import "react-datepicker/dist/react-datepicker.css";
import TtkInput from '@/components/Inputs/TtkInput';
import { ru } from 'date-fns/locale';
import { format } from 'date-fns';

export default function Page({ params }) {
    const [data, setData] = useState({
        company: '',
        property: '',
        position: '',
        card: '',
        created_date: '',
        dish: '',
        approver: '',
        approver2: '',
        approver2_position: '',
        dev: ''
    });
    const [startDate, setStartDate] = useState(new Date());
    const [errors, setErrors] = useState({});

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${API_ROUTES.TTKS}/${params.id}/header`, {
                    withCredentials: true,
                });
                setData(response.data.data || {});
                setStartDate(format(data.created_date, 'dd/MM/yyyy'))
            } catch (err) {
                setErrors({ fetch: err.message });
            }
        };
        fetchData();
    }, [params.id]);

    const validate = () => {
        const validationErrors = {};
        if (!data.company) validationErrors.company = 'Поле обязательно для заполнения';
        if (!data.property) validationErrors.property = 'Поле обязательно для заполнения';
        if (!data.position) validationErrors.position = 'Поле обязательно для заполнения';
        if (!data.card) validationErrors.card = 'Поле обязательно для заполнения';
        if (!startDate) validationErrors.created_date = 'Поле обязательно для заполнения';
        if (!data.dish) validationErrors.dish = 'Поле обязательно для заполнения';
        if (!data.approver) validationErrors.approver = 'Поле обязательно для заполнения';
        if (!data.approver2) validationErrors.approver2 = 'Поле обязательно для заполнения';
        if (!data.approver2_position) validationErrors.approver2_position = 'Поле обязательно для заполнения';
        if (!data.dev) validationErrors.dev = 'Поле обязательно для заполнения';
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
            console.log("errors")
            setErrors(validationErrors);
            return;
        }
        try {
            data.created_date = format(startDate, 'yyyy-MM-dd');
            if (data?.id) {
                // Если есть ID, делаем PATCH запрос
                await axios.patch(`${API_ROUTES.TTKS}/${params.id}/header`, data, { withCredentials: true });
            } else {
                // Если нет ID, делаем POST запрос
                data.ttk_id = params.id
                await axios.post(`${API_ROUTES.TTKS}/${params.id}/header`, data, { withCredentials: true });
            }
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
                <div className="col-12 col-md-6 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <h3 className="mh text-center title">Шапка документа</h3>
                        <div className="row flex-column">
                            <div className="mb-4">
                                <InputBox
                                    name="company"
                                    placeholder="Название предприятия"
                                    value={data.company}
                                    type="text"
                                    onChange={handleChange}
                                    errors={errors.company}
                                />

                                <InputBox
                                    name="property"
                                    placeholder="Название заведения"
                                    value={data.property}
                                    onChange={handleChange}
                                    errors={errors.property}
                                />
                            </div>
                            <div className="mb-4">
                                <InputBox
                                    name="position"
                                    title="Утверждаю"
                                    placeholder="Должность"
                                    value={data.position}
                                    onChange={handleChange}
                                    errors={errors.position}
                                />
                                <InputBox
                                    name="approver"
                                    placeholder="ФИО"
                                    value={data.approver}
                                    onChange={handleChange}
                                    errors={errors.approver}
                                />
                            </div>
                            <div className="mb-4">
                                <InputBox
                                    name="card"
                                    title="Технико-технологическая карта"
                                    placeholder="Номер карты"
                                    value={data.card}
                                    className="w-auto"
                                    onChange={handleChange}
                                    errors={errors.card}
                                />

                                <InputBox
                                        name="created_date"
                                        title="от"
                                        placeholder="Дата"
                                        onChange={(date) => setStartDate(date)}
                                        errors={errors.created_date}>
                                        <DatePicker
                                        selected={startDate}
                                        onChange={(date) => setStartDate(date)}
                                        locale={ru}
                                        dateFormat="yyyy-MM-dd"
                                        customInput={
                                            <TtkInput title="1" className='m-2'/>
                                        }/>
                                </InputBox>
                            </div>
                            <div className="mb-4">
                                <InputBox
                                    name="dish"
                                    placeholder="Название блюда"
                                    value={data.dish}
                                    onChange={handleChange}
                                    errors={errors.dish}
                                />
                            </div>
                            <div className="mb-4">
                                <p className="title d-flex justify-content-center mb-3">Конец документа</p>
                                <InputBox
                                    name="dev"
                                    title="Разработчик"
                                    placeholder="ФИО"
                                    value={data.dev}
                                    onChange={handleChange}
                                    errors={errors.dev}
                                />
                                <InputBox
                                    name="approver2_position"
                                    placeholder="Должность"
                                    value={data.approver2_position}
                                    onChange={handleChange}
                                    errors={errors.approver2_position}
                                />
                                <InputBox
                                    name="approver2"
                                    placeholder="ФИО"
                                    value={data.approver2}
                                    onChange={handleChange}
                                    errors={errors.approver2}
                                />
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
