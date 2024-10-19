'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/WideButton';
import '../data.css';
import "react-datepicker/dist/react-datepicker.css";
import { format } from 'date-fns';
import SimpleInput from '@/components/Inputs/SimpleInput';
import './microbio-params.css';
export default function Page({ params }) {
    const [data, setData] = useState({
    });

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.MICROBIO_PARAMS(params.id), {
                    withCredentials: true,
                });
                console.log("response", response.data.data.rem);
                setData(response.data.data);
            } catch (err) {
                alert(err);
            }
        };
        fetchData();
    }, [params.id]);

    return (
        <div className="container">
            <div className="row d-flex justify-content-center">
                <div className="col-12 col-md-10">
                    <h3 className="mh text-center title">Нормируемые физико-химические показатели</h3>
                    <p>
                        Микробиологические показатели качества блюда (изделия) должны соответствовать требованиям
                        Технического регламента Таможенного союза "О безопасности пищевой продукции" ТР ТС 021/2011, или
                        гигиеническим нормативам, установленным в соответствии с нормативными правовыми актами или
                        нормативными документами, действующими на территории государства, принявшего стандарт.
                    </p>
                    <table>
                        <thead>
                        <tr>
                            <th colSpan="1" rowSpan="2">КМА-ФАнМ КОЕ/г, не более</th>
                            <th colSpan="5">Масса продукта (г), в которой не допускаются:</th>
                        </tr>
                        <tr>
                            <th>БГКП
                                (колиформы)
                            </th>
                            <th>E/coli</th>
                            <th>S.aureus</th>
                            <th>Proteus</th>
                            <th>Патогенные, в т.ч. сальмонеллы</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{data?.kma ?? null}</td>
                            <td>{data?.bgkp ?? null}</td>
                            <td>{data?.ecoli ?? null}</td>
                            <td>{data?.saur ?? null}</td>
                            <td>{data?.prot ?? null}</td>
                            <td>{data?.pato ?? null}</td>
                        </tr>
                        </tbody>
                    </table>
                    <p>{data.rem}</p>
                </div>
            </div>
        </div>
    );
}
