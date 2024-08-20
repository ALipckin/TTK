"use client"

import GreyCard from "@/components/cards/greyCard"
import Pagination from '@/components/Pagination'
import React, { useEffect, useState } from 'react'
import axios from 'axios';
import WideInput from '@/components/Inputs/WideInput'
import WideButton from '@/components/buttons/WideButton'
import { useSearchParams, useRouter } from 'next/navigation'

const SearchForm = ({header="Список", itemName="name", itemRoute, apiRoute, ...params}) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [searchVal, setSearchVal] = useState(null);
    const [pagination, setPagination] = useState({});
    const [currPath, setCurrPath] = useState({});
    //const { page, name, category } = router.query;
    const ratingNum = "26";
    const searchParams = useSearchParams();
    const router = useRouter();
    const queryString = Array.from(searchParams.entries())

    .map(([key, value]) => `${key}=${value}`)
    .join('&');
    console.log("queryString =" + queryString);

    var currentPath;

    const getTtks = async () => {
        try {
            var response;
            if(queryString) {
                response = await axios.get(`${apiRoute}?${queryString}`, {
                    withCredentials: true,
                });
                setSearchVal(searchParams.get({itemName}));
            }
            else{
                response = await axios.get(`${apiRoute}`, {
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
       setCurrPath(window.location.pathname);
       console.log("curr path = " + currentPath);
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
                const response = await axios.get(`${apiRoute}?${itemName}=${searchVal}`, {
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
                <h3 className="mh">{header}</h3>
                <div className="mt-4 d-flex flex-column justify-content-center">
                    <WideInput
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
                                title={item[itemName]}
                                href={itemRoute ? `${itemRoute}/${item.id}` : `${currPath}/${item.id}`}
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

export default SearchForm;
