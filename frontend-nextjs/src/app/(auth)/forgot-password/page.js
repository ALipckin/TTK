'use client'

import WideInput from '@/components/Inputs/WideInput'
import InputError from '@/components/InputError'
import Label from '@/components/Label'
import { useAuth } from '@/hooks/auth'
import { useState } from 'react'
import AuthSessionStatus from '@/app/(auth)/AuthSessionStatus'
import WideButton from '@/components/buttons/WideButton'
import TtkError from '@/components/errors/TtkError'

const Page = () => {
    const { forgotPassword } = useAuth({
        middleware: 'guest',
        redirectIfAuthenticated: '/dashboard',
    })

    const [email, setEmail] = useState('')
    const [errors, setErrors] = useState([])
    const [status, setStatus] = useState(null)

    const submitForm = event => {
        event.preventDefault()
        forgotPassword({ email, setErrors, setStatus })
    }

    return (
        <>
            <div className="container">
                <div className="col-md-12 mt-5 mb-5 flex-column align-items-center">
                    <div className="d-flex flex-column align-items-center mb-4">
                        <div className="d-flex flex-column align-items-center">

                            <div className="mb-4 text-center text-sm text-gray-600">
                                Введите электронную почту для отправки ссылки восстановления пароля<br />
                            </div>



                            <form onSubmit={submitForm}>
                                {/* Адрес электронной почты */}
                                <div>
                                    <WideInput
                                        id="email"
                                        type="email"
                                        name="email"
                                        value={email}
                                        className="block mt-1 w-full"
                                        autoComplete="email"
                                        placeholder="Введите email"
                                        onChange={event => setEmail(event.target.value)}
                                        required
                                        autoFocus
                                    />

                                    <TtkError messages={errors.email} className="mt-2" />
                                </div>

                                <div className="d-flex align-items-center justify-content-center mt-4">
                                    <WideButton className="d-flex justify-content-center text-center">Отправить ссылку</WideButton>
                                </div>
                            </form>

                            {/* Статус сеанса */}
                            <AuthSessionStatus className="mt-4" status={status} />
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Page
