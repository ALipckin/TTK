'use client'
import '../profile.css'
import ProfileDataList from '../profileDataList'
import { API_ROUTES } from '@/components/apiRoutes'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import ConstItem from '@/app/(app)/profile/constItem'
import IconItem from '@/app/(app)/profile/iconItem'
import dayjs from 'dayjs'
import GreyCard from '@/components/cards/greyCard'
import { redirect } from 'next/navigation'
import { router } from 'next/client'
import { useRouter } from 'next/navigation';
export default function page({ params }) {
    const [user, setUser] = useState(null)
    const [ttks, setTtks] = useState(null)
    const [error, setError] = useState(null)
    const [selectedFile, setSelectedFile] = useState(null)  // Для хранения выбранного файла
    const [avatarUrl, setAvatarUrl] = useState('/images/defaultAvatar.png')  // Ссылка на аватар по умолчанию
    const [isHovered, setIsHovered] = useState(false)  // Для отслеживания наведения на аватар
    const router = useRouter();
    // Получение данных профиля
    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.GET_PROFILE(params.id), {
                    withCredentials: true,
                })
                setUser(response.data.data)
                if (response.data.data.avatar) {
                    setAvatarUrl(API_ROUTES.DOMAIN_NAME + response.data.data.avatar)  // Устанавливаем аватар, если он уже есть
                }
            } catch (err) {
                setError(err)
            }

            try {
                const responseTtk = await axios.get(API_ROUTES.TTKS +"/?user_id=" + params.id, {
                    withCredentials: true,
                })
                setTtks(responseTtk.data.data)
            } catch (err) {
                setError(err)
            }
        }

        fetchData()
    }, [])

    return (

        <div className="container d-flex justify-content-center text">
            {user ? (
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-8">

                <div className="user-card p-0">
                    <h3 className="mh d-flex align-content-start">{user.name}</h3>
                    <div className="d-flex justify-content-start">
                        <div
                            className="avatar d-flex justify-content-center align-items-center position-relative"
                            onMouseEnter={() => setIsHovered(true)}  // Показываем кнопку при наведении
                            onMouseLeave={() => setIsHovered(false)}  // Скрываем кнопку при уходе
                        >
                            <img src={avatarUrl} alt="Аватар" className="avatar-image" />
                        </div>
                    </div>
                </div>
                <div className="p-0 m-0">
                    <div className="mt-4 d-flex flex-column justify-content-start">
                        <ul className="mb-2 p-0">
                            <ConstItem title="Дата регистрации" data={dayjs(user.created_at).format('DD.MM.YYYY')} />
                            <ConstItem title="Последний визит"
                                       data={ user.last_visit ? (dayjs(user.last_visit).format('DD.MM.YYYY HH:mm') + ' msk') : "-"} />
                            <ConstItem title="Просмотры" data={user.views} />
                            <ConstItem title="Количество работ" data={user.ttk_num} />
                        </ul>
                    </div>
                    <div className={"mb-2"}>
                        {ttks && ttks.map((item, index) => (
                            <GreyCard
                                key={index}
                                title={item.name}
                                href={`ttks/${item.id}`}
                                data={item}
                            />
                        ))}
                    </div>
                    <IconItem title="Показать все работы" img={`/images/picture.svg`} onClick={() => router.push("/ttks?user_id=" + params.id)}/>
                </div>
            </div> ) : null}
        </div>

    )
}
