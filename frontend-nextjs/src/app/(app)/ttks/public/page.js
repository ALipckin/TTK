"use client"
import "./public.css"
import { API_ROUTES } from "@/components/apiRoutes"
import GreyCard from "@/components/cards/greyCard"
import Pagination from '@/components/Pagination'
import { useRouter } from 'next/navigation'
import React, { useEffect, useState } from 'react'
import axios from 'axios';
import EditAction from "@/components/actions/editAction"
import DeleteAction from "@/components/actions/deleteAction"
import { redirect } from 'next/navigation'
import AuthInput from '@/components/Inputs/AuthInput'
import WideButton from '@/components/buttons/WideButton'
import { useSearchParams } from 'next/navigation'


const Page = () => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [searchVal, setSearchVal] = useState(null);
    const [pagination, setPagination] = useState({});
    //const { page, name, category } = router.query;
    const ratingNum = "26";
    const searchParams = useSearchParams();
    const router = useRouter();
    const queryString = Array.from(searchParams.entries())
    
    .map(([key, value]) => `${key}=${value}`)
    .join('&');
    console.log("queryString =" + queryString);

    const getTtks = async () => {
        try {
            var response;
            if(queryString) {
                response = await axios.get(`${API_ROUTES.TTKS_PUBLIC}?${queryString}`, {
                    withCredentials: true,
                });
                setSearchVal(searchParams.get("name"));
            }
            else{
                response = await axios.get(`${API_ROUTES.TTKS_PUBLIC}`, {
                    withCredentials: true,
                });
            }
            console.log(response.data);
            setData(response.data.data);
            setPagination(response.data.pagination)
        } catch (err) {
            setError(err);
        }
    }

    useEffect(() => {
       getTtks()
    },[]);
    if (error) {
        return <div>Ошибка: {error.message}</div>;
    }

    if (!data) {
        return <div>Загрузка...</div>;
    }

    const handlePageChange = (newPage) => {
            console.log("true");
            const params = new URLSearchParams(searchParams);
            console.log("params = " + params);
            params.set('page', newPage);
            const newPath = `${window.location.pathname}?${params.toString()}`;
            router.replace(newPath);
            setTimeout(() => {
                window.location.reload();
              }, 600);
      };
    

    const search = async () => {
        console.log("searching: " + searchVal);
        try {
            if(searchVal) {
                const response = await axios.get(`${API_ROUTES.TTKS_PUBLIC}?name=${searchVal}`, {
                    withCredentials: true,
                });
                console.log(response.data);
                setData(response.data.data);
            }
            else{
                getTtks()
            }
        } catch (err) {
            setError(err);
        }
    }

    return (
        <div className="container d-flex justify-content-center">
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-12">
                <h3 className="mh">Опубликованные работы</h3>
                <div className="mt-4 d-flex flex-column justify-content-center">
                    <p>Все работы</p>
                    <AuthInput
                        id="search"
                        type="text"
                        value={searchVal}
                        className="block mt-1 w-full"
                        onChange={event => setSearchVal(event.target.value)}
                        required
                        autoFocus
                        placeholder="Введите название"
                    />
                    <WideButton type="button" onClick={search}>Поиск</WideButton>
                    <div className="row flex-column col-md-12">
                        {data.map((item, index) => (
                            <GreyCard
                                key={index}
                                title={item.name}
                                apiUrl={API_ROUTES.GET_MY_ALL_TTKS}
                                href={`/ttks/${item.id}`}
                                data={item}
                            />
                        ))}
                    </div>
                    {/* Пагинация */}
                    <Pagination pagination={pagination} handlePageChange={handlePageChange}></Pagination>
                </div>
            </div>
        </div>
    );
};

export default Page;
