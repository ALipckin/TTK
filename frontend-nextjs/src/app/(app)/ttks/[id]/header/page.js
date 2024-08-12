"use client";
import { API_ROUTES } from '@/components/apiRoutes'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import "../data.css"
import InputBox from '@/components/Inputs/ttkInput'

export default function page({params}) {
    const [data, setData] = useState(null)
    const [error, setError] = useState(null)

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.TTKS + "/" + params.id + "/header", {
                    withCredentials: true,
                })
                console.log(response.data)
                setData(response.data.data)
            } catch (err) {
                //router.push('/ttks/my')
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

    return (
        <div className="container d-flex justify-content-center">
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-12">
                <h3 className="mh">Шапка документа</h3>
                <div className="mt-4 d-flex flex-column justify-content-center">
                    <div className="row flex-column col-md-12">
                        <InputBox placeholder="Название предприятия" value={data.company}/>
                        <InputBox placeholder="Название заведения" value={data.property}/>
                        <InputBox title={"Утверждаю"} placeholder="Должность" value={data.position}/>
                        <InputBox placeholder="ФИО" value={data.approver}/>
                        <InputBox title={"Технико-технологическая карта №"} placeholder="Номер карты" value={data.card}/>
                        <InputBox title={"от"} placeholder="Дата" value={data.created_date}/>
                        <InputBox placeholder="Название блюда" value={data.dish}/>
                        <p className="d-flex justify-content-center">Конец документа</p>
                        <InputBox title={"Разработчик"} placeholder="ФИО" value={data.approver2}/>
                        <InputBox placeholder="Должность" value={data.approver2_position}/>
                        <InputBox placeholder="ФИО" value={data.approver2}/>
                    </div>
                </div>
            </div>
        </div>
    )
}
