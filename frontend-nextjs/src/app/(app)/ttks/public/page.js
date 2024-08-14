"use client";
import { API_ROUTES } from "@/components/apiRoutes";
import GreyCard from "@/components/cards/greyCard";
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import EditAction from "@/components/actions/editAction";
import DeleteAction from "@/components/actions/deleteAction";
import { redirect } from 'next/navigation'
import TtkInput from '@/components/Inputs/TtkInput'
import AuthInput from '@/components/Inputs/AuthInput'
import { format } from 'date-fns'

const Page = () => {

    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setErrors] = useState(null);
    const [searchVal, setSearchVal] = useState(null);

    const ratingNum = "26";

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.TTKS_PUBLIC, {
                    withCredentials: true,
                });
                console.log(response.data);
                setData(response.data.data);
            } catch (err) {
                setError(err);
            }
        };

        fetchData();
    },[]);
    if (error) {
        return <div>Ошибка: {error.message}</div>;
    }

    if (!data) {
        return <div>Загрузка...</div>;
    }
    const submitSearch = () => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${API_ROUTES.TTKS}/public?name=${searchVal}`, {
                    withCredentials: true,
                });
                console.log(response.data);
                setData(response.data.data);
            } catch (err) {
                setError(err);
            }
        };
        fetchData();
    }
    console.log(data);
    return (
        <div className="container d-flex justify-content-center">
            <div className="row mt-5 mb-5 d-flex justify-content-start col-md-12">
                <h3 className="mh">Опубликованные работы</h3>
                <div>
                <AuthInput
                    id="search"
                    type="text"
                    value={searchVal}
                    className="mt-1"
                    autoFocus
                    placeholder="Поиск"
                    onChange={event => setSearchVal(event.target.value)}
                /><button onClick={submitSearch}>Найти</button></div>
                <div className="mt-4 d-flex flex-column justify-content-center">
                    <div className="row flex-column col-md-12">
                        {data.map((item, index) => (
                            <GreyCard
                                key={index}
                                title={item.name}
                                href={`/ttks/${item.id}`}
                                data={item}
                            />
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Page;
