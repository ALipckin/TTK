'use client'
import './menu.css'
import { API_ROUTES } from '@/components/apiRoutes'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { useRouter } from 'next/router'

export default function id() {
    const router = useRouter()
    return <p>Post: {router.query.slug}</p>

    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)


    const ratingNum = '26'

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.GET_MY_ALL_TTKS, {
                    withCredentials: true,
                })
                console.log(response.data)
                setData(response.data.data)
            } catch (err) {
                setError(err)
            }
        }

        fetchData()
    }, [])
    if (error) {
        return <div>Ошибка: {error.message}</div>
    }

    if (!data) {
        return <div>Загрузка...</div>
    }

    console.log(data)
    return (
        <div className="container d-flex justify-content-center">
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-12">
                <h3 className="mh">Меню создания</h3>
                <div className="mt-4 d-flex flex-column justify-content-center">
                    <div className="row flex-column col-md-12">
                        <a className="link" href={{id}}>Шапка документа</a>
                        <a className="link">Требования к качеству сырья</a>
                        <a className="link">Рецептура</a>
                        <a className="link">Описание технологического процесса</a>
                        <a className="link">Требования к оформлению и подаче</a>
                        <a className="link">Органолептические показатели</a>
                    </div>
                </div>
            </div>
        </div>
    )
}
