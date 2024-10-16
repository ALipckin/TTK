'use client'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { API_ROUTES } from '@/components/apiRoutes'
import InputBox from '@/components/Inputs/TtkInputBox'
import WideButton from '@/components/buttons/WideButton'
import '@/components/forms/data.css'
import TrashForm from '@/components/buttons/TrashForm'
import ActionIconButton from '@/components/buttons/ActionIconButton'
import '@/components/forms/ttk.css'
import './ne-value.css'
import SearchPopup from '@/components/popup/SearchPopup'
import PopupBox from '@/components/popup/PopupBox'
import WideInput from '@/components/Inputs/WideInput'
import TtkInput from '@/components/Inputs/TtkInput'
import InputError from '@/components/errors/TtkError'
import { forEach } from 'react-bootstrap/ElementChildren'

export default function Page({ params }) {
    const [Data, setData] = useState([]) // Инициализируем как массив

    useEffect(() => {
        const fetchData = async () => {
            try {
                const result = await axios.get(API_ROUTES.GET_NE_VALUE(params.id), {
                    withCredentials: true,
                })
                if (result.data.data) {
                    setData(result.data.data)
                }
            } catch (err) {
                //error
            }
        }
        fetchData()
    }, [])

    return (
        <div className="container">
            <div className="d-flex justify-content-center">
                <div className="row col-12 d-flex justify-content-center">
                    <div className="mt-5 mb-5 d-flex justify-content-center flex-column">
                        <div className="d-flex d-flex justify-content-center">
                            <h2 className="mb-5 title">Пищевая и энергетическая ценность</h2>
                        </div>
                        <div className="row flex-column">
                            <table className="bg-transparent">
                                <thead>
                                <tr>
                                    <th scope="col">Белки г.</th>
                                    <th scope="col">Жиры г.</th>
                                    <th scope="col">Углев г.</th>
                                    <th scope="col">ккал</th>
                                    <th scope="col">кДж г.</th>
                                </tr>
                                </thead>
                                <tbody>
                                {Array.isArray(Data.ne_values) && Data.ne_values.map((item, index) => (
                                    <tr scope="row" className="mb-4" key={index}>
                                        <td>
                                            {item.elems.protein}
                                        </td>
                                        <td>
                                            {item.elems.fat}
                                        </td>
                                        <td>
                                            {item.elems.carbs}
                                        </td>
                                        <td>
                                            {item.elems.kcal}
                                        </td>
                                        <td>
                                            {item.elems.kj}
                                        </td>
                                    </tr>
                                ))
                                }
                                <tr scope="row" className="mb-4">
                                    <td className="border-0"></td>
                                    <td className="border-0"></td>
                                    <td className="border-0"></td>
                                    <td className="border-0"></td>
                                    <td className="border-0"></td>
                                </tr>
                                </tbody>
                                <tfoot className="mt-2">
                                <tr scope="row" className="mb-4 sum-result">
                                    <td>
                                        {Data.result?.protein ?? null}
                                    </td>
                                    <td>
                                        {Data.result?.fat ?? null}
                                    </td>
                                    <td>
                                        {Data.result?.carbs ?? null}
                                    </td>
                                    <td>
                                        {Data.result?.kcal ?? null}
                                    </td>
                                    <td>
                                        {Data.result?.kj ?? null}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
