'use client'

import WideInput from '@/components/Inputs/WideInput'
import InputError from '@/components/InputError'
import Link from 'next/link'
import { useAuth } from '@/hooks/auth'
import { useState } from 'react'
import './registation.css'
import WideButton from '@/components/buttons/WideButton'

const Page = () => {
    const { register } = useAuth({
        middleware: 'guest',
        redirectIfAuthenticated: '/dashboard',
    })

    const [name, setName] = useState('')
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [passwordConfirmation, setPasswordConfirmation] = useState('')
    const [errors, setErrors] = useState([])

    const submitForm = event => {
        event.preventDefault()

        register({
            name,
            email,
            password,
            password_confirmation: passwordConfirmation,
            setErrors,
        })
    }

    return (
        <div className="container">
            <div className="mt-5 mb-5">
                <h3 className="mh">Регистрация</h3>
                <form onSubmit={submitForm}>
                    {/* Name */}
                    <div className="d-flex justify-content-center flex-column align-items-center mb-4">
                        <div className="d-flex flex-column align-items-start">
                            <div>
                                <WideInput
                                    id="name"
                                    type="text"
                                    value={name}
                                    className=""
                                    onChange={event => setName(event.target.value)}
                                    required
                                    autoFocus
                                    placeholder="Имя"
                                />
                                <InputError messages={errors.name} className="mt-2" />
                            </div>
                            {/* Email Address */}
                            <div>
                                <WideInput
                                    id="email"
                                    type="email"
                                    value={email}
                                    className="block mt-1 w-full"
                                    onChange={event => setEmail(event.target.value)}
                                    placeholder="Email"
                                    required
                                />

                                <InputError messages={errors.email} className="mt-2" />
                            </div>

                            {/* Password */}
                            <div>
                                <WideInput
                                    id="password"
                                    type="password"
                                    value={password}
                                    className="block mt-1 w-full"
                                    onChange={event => setPassword(event.target.value)}
                                    required
                                    autoComplete="new-password"
                                    placeholder="Пароль"
                                />

                                <InputError messages={errors.password} className="mt-2" />
                            </div>

                            {/* Confirm Password */}
                            <div>
                                <WideInput
                                    id="passwordConfirmation"
                                    type="password"
                                    value={passwordConfirmation}
                                    className="block mt-1 w-full"
                                    onChange={event =>
                                        setPasswordConfirmation(event.target.value)
                                    }
                                    placeholder="Подтвердите пароль"
                                    required
                                />

                                <InputError
                                    messages={errors.password_confirmation}
                                    className="mt-2"
                                />
                            </div>
                        </div>
                    </div>
                    <div className="d-flex flex-column align-content-center align-items-center">
                        <Link
                            href="/login"
                            className="underline text-sm text-gray-600 hover:text-gray-900">
                            Уже заригистрированны?
                        </Link>
                        <WideButton>Зарегистрироваться</WideButton>
                    </div>
                </form>
            </div>
        </div>
    )
}

export default Page
