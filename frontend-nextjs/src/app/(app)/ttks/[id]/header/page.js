'use client'
import { API_ROUTES } from '@/components/apiRoutes'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import '../data.css'
import InputBox from '@/components/Inputs/ttkInput'
import WideButton from '@/components/buttons/wide-button'
import "./header.css"
import { useRouter } from 'next/navigation'
import { useAuth } from '@/hooks/auth'
import InputError from '@/components/InputError'
export default function page({ params }) {
    const [data, setData] = useState(0)
    const [errors, setErrors] = useState([])

    const [company, setCompany] = useState('')
    const [property, setProperty] = useState('')
    const [position, setPosition] = useState('')
    const [card, setCard] = useState('')
    const [created_date, setCreatedDate] = useState('')
    const [dish, setDish] = useState('')
    const [approver, setApprover] = useState('')
    const [approver2, setApprover2] = useState('')
    const [approver2_position, setApprover2_position] = useState('')
    const [dev, setDev] = useState('')

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.TTKS + '/' + params.id + '/header', {
                    withCredentials: true,
                })
                console.log(response.data)
                setData(response.data.data)
                setAllData(data)
            } catch (err) {
                //router.push('/ttks/my')
                setErrors(err)
            }
        }

        fetchData()
    }, []);

    // if (errors) {
    //     return <div>Ошибка: {errors.message}</div>
    // }
    // if (!data) {
    //     return <div>Загрузка...</div>
    // }
    const router = useRouter()
    // const setAllData = (data) => {
    //     setCompany(data.company)
    //     setProperty(data.property)
    // }
    const sendHeader = async ({ setErrors, setStatus, ...props }) => {
        setErrors([])
        setStatus(null)
        useEffect(() => {
            if (router.reset?.length > 0 && errors.length === 0) {
                setStatus(atob(router.reset))
            } else {
                setStatus(null)
            }
        })

        useEffect(()=> {
            axios
                .post(API_ROUTES.TTKS + '/' + params.id + '/header', props)
                .then(() => mutate())
                .catch(error => {
                    if (error.response.status !== 422) throw error
                    setErrors(error.response.data.errors)
                })
        })
    }

    const submitForm = async event => {

        sendHeader({
            company,
            property,
            position,
            card,
            created_date,
            dish,
            approver,
            approver2,
            approver2_position,
            dev,
        })
    }

    return (
        <div className="container">
            <div className="row d-flex justify-content-center">
                <div className="col-12 col-md-6 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                            <h3 className="mh text-center title">Шапка документа</h3>
                            <div className="row flex-column">
                                <form action="">
                                    <div className="mb-4">
                                        <InputBox placeholder="Название предприятия" value={data.company}
                                                  type={'text'} onChange={event => setCompany(event.target.value)}/>
                                        <InputError
                                            messages={errors.company}
                                            className="mt-2"
                                        />
                                        <InputBox placeholder="Название заведения" defaultValue={data.property}
                                                  onChange={event => setProperty(event.target.value)} />
                                        <InputError
                                            messages={errors.property}
                                            className="mt-2"
                                        />
                                    </div>
                                    <div className="mb-4">
                                        <InputBox title={'Утверждаю'} placeholder="Должность"
                                                  defaultValue={data.position}
                                                  onChange={event => setPosition(event.target.value)}/>
                                        <InputBox placeholder="ФИО" defaultValue={data.approver} />
                                    </div>
                                    <div className="mb-4">
                                        <InputBox title={'Технико-технологическая карта'} placeholder="Номер карты"
                                                  defaultValue={data.card} className={"w-auto"}
                                                  onChange={event => setCard(event.target.value)}
                                        />
                                        <InputBox title={'от'} placeholder="Дата" defaultValue={data.created_date}
                                                  onChange={event => setCreatedDate(event.target.value)}/>
                                    </div>
                                    <div className="mb-4">
                                        <InputBox placeholder="Название блюда" defaultValue={data.dish}
                                                  onChange={event => setDish(event.target.value)}/>
                                    </div>
                                    <div className="mb-4">
                                        <p className="title d-flex justify-content-center mb-3">Конец документа</p>
                                        <InputBox title={'Разработчик'} placeholder="ФИО"
                                                  defaultValue={data.dev}
                                                  onChange={event => setDev(event.target.value)}
                                        />
                                        <InputBox placeholder="Должность" defaultValue={data.approver2_position}
                                                  onChange={event => setApprover2_position(event.target.value)}
                                        />
                                        <InputBox placeholder="ФИО" defaultValue={data.approver2}
                                                  onChange={event => setApprover2(event.target.value)}
                                        />
                                    </div>
                                    <div className="d-flex justify-content-center">
                                        <WideButton type={'button'} text={'Сохранить'} onClick={submitForm()} />
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
