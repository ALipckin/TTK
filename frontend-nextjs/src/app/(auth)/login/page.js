'use client'

import WideInput from '@/components/Inputs/WideInput'
import InputError from '@/components/InputError'
import Link from 'next/link'
import { useAuth } from '@/hooks/auth'
import { useEffect, useState } from 'react'
import { useRouter } from 'next/navigation'
import AuthSessionStatus from '@/app/(auth)/AuthSessionStatus'
import WideButton from '@/components/buttons/WideButton'
import TtkError from '@/components/errors/TtkError'

const Login = () => {
    const router = useRouter()

    const { login } = useAuth({
        middleware: 'guest',
        redirectIfAuthenticated: '/dashboard',
    })

    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [shouldRemember, setShouldRemember] = useState(false)
    const [errors, setErrors] = useState([])
    const [status, setStatus] = useState(null)

    useEffect(() => {
        if (router.reset?.length > 0 && errors.length === 0) {
            setStatus(atob(router.reset))
        } else {
            setStatus(null)
        }
    })

    const submitForm = async event => {
        event.preventDefault()

        login({
            email,
            password,
            remember: shouldRemember,
            setErrors,
            setStatus,
        })
    }

    return (
        <>
            <div className="container">
                <div className="col-md-12 mt-5 mb-5 flex-column align-items-center">
                    <div className="d-flex flex-column align-items-center mb-4">
                        <div className="d-flex flex-column align-items-center">
                            <AuthSessionStatus className="mb-4" status={status} />
                            <h3 className="mh"> Авторизация</h3>
                            <form onSubmit={submitForm}>
                                {/* Email Address */}
                                <div>
                                    <WideInput
                                        id="email"
                                        type="email"
                                        value={email}
                                        className="block mt-1 w-full"
                                        onChange={event => setEmail(event.target.value)}
                                        required
                                        autoFocus
                                        placeholder="Email"
                                    />
                                </div>
                                {/* Password */}
                                <div className="mt-4">
                                    <WideInput
                                        id="password"
                                        type="password"
                                        value={password}
                                        className="block mt-1 w-full"
                                        onChange={event => setPassword(event.target.value)}
                                        required
                                        autoComplete="current-password"
                                        placeholder="Пароль"
                                    />
                                </div>
                                <TtkError messages={errors.email} className={"text-center"}></TtkError>
                                <TtkError messages={errors.password} className={"text-center"}></TtkError>
                                {/* Remember Me */}
                                <div className="block mt-4 m-lg-2">
                                    <label
                                        htmlFor="remember_me"
                                        className="inline-flex items-center">
                                        <input
                                            id="remember_me"
                                            type="checkbox"
                                            name="remember"
                                            className="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            onChange={event =>
                                                setShouldRemember(event.target.checked)
                                            }
                                        />

                                        <span className="ml-2 text-sm text-gray-600">
                                            Запомнить меня
                                        </span>
                                    </label>
                                    <div>
                                        <Link
                                            href="/forgot-password"
                                            className="underline text-sm text-gray-600 hover:text-gray-900">
                                            Забыли пароль?
                                        </Link>
                                    </div>
                                </div>
                                <div className="d-flex flex-column align-content-center align-items-center">
                                    <WideButton className="ml-3">Войти</WideButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Login
