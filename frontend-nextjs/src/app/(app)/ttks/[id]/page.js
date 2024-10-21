"use client";
import './ttk.css'
import { API_ROUTES } from '@/components/apiRoutes'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { useRouter } from 'next/navigation'
import IconItem from "@/app/(app)/profile/iconItem";

export default function page({params}) {
    const router = useRouter();
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)

    const ratingNum = '26'

        useEffect(() => {
            const fetchData = async () => {
                try {
                    const response = await axios.get(API_ROUTES.TTKS + "/" + params.id, {
                        withCredentials: true,
                    })
                    setData(response.data.data)
                } catch (err) {
                    //router.push('/ttks/my')
                    setError(err)
                }
            }

            fetchData()
        }, [])
    const downloadPdf = async () => {
        try {
            const response = await axios.get(API_ROUTES.DOWNLOAD_TTK_PDF(params.id), {
                withCredentials: true,
                responseType: 'blob', // Указываем, что ожидаем Blob (бинарные данные)
            });

            const blob = new Blob([response.data], { type: 'application/pdf' });
            const url = window.URL.createObjectURL(blob);

            // Создаём ссылку для скачивания и автоматически её нажимаем
            const a = document.createElement('a');
            a.href = url;
            a.download = 'ttk-'+params.id+'.pdf'; // Имя файла
            document.body.appendChild(a);
            a.click();

            // Очищаем объект URL после использования
            window.URL.revokeObjectURL(url);
        } catch (err) {
            setError(err);
        }
    };

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
                <h4 className="mh">{data.name}</h4>
                <div className="">
                    <h4 className="mh">{data.category_name}</h4>
                    <IconItem title="Скачать pdf" img={`/images/download.png`} imgClass={"download-icon"} mainContainerClass={"col-8 col-sm-4 col-md-2"} onClick={() => downloadPdf()} />
                </div>
                <div className="mt-4 d-flex flex-column justify-content-center">
                    <div className="row flex-column col-md-12">
                    <a className="link" href={`/ttks/${params.id}/header/`}>Шапка документа</a>
                        <a className="link" href={`/ttks/${params.id}/scope/`}>Область применения</a>
                        <a className="link" href={`/ttks/${params.id}/quality-requirement/`}>Требования к качеству сырья</a>
                        <a className="link" href={`/ttks/${params.id}/formulation/`}>Рецептура</a>
                        <a className="link" href={`/ttks/${params.id}/tp/`}>Описание технологического процесса</a>
                        <a className="link" href={`/ttks/${params.id}/realization-requirement/`}>Требования к оформлению и подаче</a>
                        <ul className="mt-3">
                            <b>Показатели качества и безопасности</b>
                            <div className="ml">
                                <li><a className="link" href={`/ttks/${params.id}/org-characteristics/`}>Органолептические показатели</a></li>
                                <li><a className="link" href={`/ttks/${params.id}/phys-chem-params/`}>Физико-химические показатели</a></li>
                                <li><a className="link" href={`/ttks/${params.id}/microbio-params/`}>Микробиологические показатели</a></li>
                            </div>
                        </ul>
                        <a className="link" href={`/ttks/${params.id}/ne-value/`}>Пищевая и энергетическая ценность</a>
                    </div>
                </div>
            </div>
        </div>
    )
}
