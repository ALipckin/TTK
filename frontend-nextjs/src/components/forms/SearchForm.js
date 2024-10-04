"use client"

import GreyCard from "@/components/cards/greyCard"
import Pagination from '@/components/Pagination'
import React, { useEffect, useState } from 'react'
import axios from 'axios';
import WideInput from '@/components/Inputs/WideInput'
import WideButton from '@/components/buttons/WideButton'
import { useSearchParams, useRouter } from 'next/navigation'
import MultiSelectDropdown from '@/components/dropdowns/MultiSelectDropdown'

const SearchForm = ({header="Список", itemName="name", itemRoute, categoriesRoute, apiRoute, ...params}) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [searchVal, setSearchVal] = useState(null);
    const [pagination, setPagination] = useState({});
    const [currPath, setCurrPath] = useState({});
    const [categories, setCategories] = useState({});
    const [selectedCategories, setSelectedCategories] = useState([]);
    //const { page, name, category } = router.query;
    const ratingNum = "26";
    const searchParams = useSearchParams();
    const router = useRouter();
    const queryString = Array.from(searchParams.entries())

    .map(([key, value]) => `${key}=${value}`)
    .join('&');

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
            setData(response.data.data);
            setPagination(response.data.pagination)
        } catch (err) {
            setError(err);
        }
    }
    const getCategories = async () => {
        try {
            const response = await axios.get(categoriesRoute, {
                withCredentials: true,
            });
            setCategories(response.data.data);
        } catch (err) {
            setError(err);
        }
    }

    useEffect(() => {
       getTtks();
       if(categoriesRoute){
        getCategories();
       }
       setCurrPath(window.location.pathname);
    },[]);
    if (error) {
        return <div>Ошибка: {error.message}</div>;
    }

    if (!data) {
        return <div>Загрузка...</div>;
    }

    const handlePageChange = (newPage) => {
            const params = new URLSearchParams(searchParams);
            params.set('page', newPage);
            const newPath = `${window.location.pathname}?${params.toString()}`;
            router.replace(newPath);
            setTimeout(() => {
                window.location.reload();
              }, 600);
      };


    const search = async () => {
        try {
            const params = new URLSearchParams();

            // Добавляем searchVal, если он существует
            if (searchVal) {
                params.append(itemName, searchVal);
            }

            // Проверка и добавление selectedCategories
            if (selectedCategories && selectedCategories.length > 0) {
                selectedCategories.forEach((item) => {
                    params.append('category_id', item);
                });
            }

            // Обязательно, чтобы хотя бы один параметр был добавлен
            if (params.toString()) {
                const response = await axios.get(`${apiRoute}?${params.toString()}`, {
                    withCredentials: true,
                });
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
                    />{
                        categoriesRoute ?
                        <div className="row d-flex justify-content-start col-12">
                            <WideButton type="button" onClick={search}>Поиск</WideButton>
                            <div className="mb-3">
                                <p className="p-1 m-0">Категории:</p>
                                <MultiSelectDropdown
                                    items={categories} selectedItems={selectedCategories} setSelectedItems={setSelectedCategories} />
                            </div>
                        </div>
                        : null
                    }
          
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
                    <Pagination pagination={pagination} handlePageChange={handlePageChange} />
                </div>
            </div>
        </div>
    );
};

export default SearchForm;
