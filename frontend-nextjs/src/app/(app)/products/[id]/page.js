'use client'
import { API_ROUTES } from '@/components/apiRoutes'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { useRouter } from 'next/navigation'
import '@/components/Inputs/TtkInput.css'
import InfoCard from '@/components/cards/InfoCard'

export default function page({ params }) {
    const router = useRouter()
    const [data, setData] = useState(null)
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)

    const ratingNum = '26'

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.GET_PRODUCTS + '/' + params.id, {
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


    if (error) {
        return <div>Ошибка: {error.message}</div>
    }
    if (!data) {
        return <div>Загрузка...</div>
    }

    console.log(data)
    return (
        <>
            <div className="container d-flex justify-content-start">
                <div className="row mt-5 mb-5 d-flex justify-content-center col-12 col-sm-7">
                    <h4 className="mh">{data.name}</h4>
                    <div className="mt-4 d-flex flex-column justify-content-center">
                        <InfoCard title="Жиры" className="">
                            {data.fat} г.
                        </InfoCard>
                        <InfoCard title="Белки" className="">
                            {data.protein} г.
                        </InfoCard>
                        <InfoCard title="Углеводы" className="">
                            {data.carbs} г.
                        </InfoCard>
                        <InfoCard title="Вода" className="">
                            {data.water} г.
                        </InfoCard>
                        <InfoCard title="Зола" className="">
                            {data.ash} г.
                        </InfoCard>
                        <InfoCard title="Клетчатка" className="">
                            {data.fiber} г.
                        </InfoCard>
                    </div>
                </div>
            </div>
        </>
    )
}
