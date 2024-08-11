"use client";
import "./profile.css"
import ProfileDataList from "./profileDataList";
import {API_ROUTES} from "@/components/apiRoutes";
import { useEffect, useState } from 'react';
import axios from 'axios';
const Page = () => {

    const [data, setData] = useState(null);
    const [error, setError] = useState(null);

    const ratingNum = "26";

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.GET_PROFILE, {
                    withCredentials: true,
                });
                setData(response.data.data);
            } catch (err) {
                setError(err);
            }
        };

        fetchData();
    },[]);

    // const getProfile = async({setErrors, setStatus, ...props}) => {
    //     await csrf()
    //     setErrors([])
    //     setStatus(null)
    //     axios
    //         .get(API_ROUTES.GET_PROFILE)
    //         .then(()=> muatate())
    //         .catch(error => {
    //             if(error.response.status !== 422) throw error
    //             setErrors(error.response.data.errors)
    //         })
    // }

    if (error) {
        return <div>Ошибка: {error.message}</div>;
    }

    if (!data) {
        return <div>Загрузка...</div>;
    }
    console.log(data);
    return (
        <div className="container d-flex justify-content-center text">
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-8">
                <div className="user-card p-0">
                    <h3 className="mh d-flex align-content-start">{data.name}</h3>
                    <div className="d-flex justify-content-start">
                        <div className="avatar d-flex justify-content-center align-items-center">
                            <img src={`/images/defaultAvatar.png`} alt="" />
                        </div>
                        {/*<div className="">*/}
                        {/*    Рейтинг <b>{ratingNum}</b>*/}
                        {/*</div>*/}
                    </div>
                </div>
                <div className="p-0 m-0">
                    <ProfileDataList data={data}/>
                </div>
            </div>
        </div>
    );
}

export default Page;
