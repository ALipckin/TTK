"use client";
import "./myAllTtks.css";
import { API_ROUTES } from "@/components/apiRoutes";
import GreyCard from "@/components/cards/greyCard";
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import EditAction from "@/components/actions/editAction";
import DeleteAction from "@/components/actions/deleteAction";

const Page = () => {

    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);


    const ratingNum = "26";

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.GET_MY_ALL_TTKS, {
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

    console.log(data);
    return (
        <div className="container d-flex justify-content-center">
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-12">
                <h3 className="mh">Шапка документа</h3>

            </div>
        </div>
    );
};

export default Page;
