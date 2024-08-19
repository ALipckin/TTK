'use client'

import WideInput from '@/components/Inputs/WideInput'
import InputError from '@/components/InputError'
import Label from '@/components/Label'
import { useAuth } from '@/hooks/auth'
import { useState } from 'react'
import AuthSessionStatus from '@/app/(auth)/AuthSessionStatus'
import WideButton from '@/components/buttons/WideButton'

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
                                Forgot your password? No problem. Just let us know your email <br />
                                address and we will email you a password reset link that<br />
                                will allow you to choose a new one.<br />
                            </div>

                            {/* Session Status */}
                            <AuthSessionStatus className="mb-4" status={status} />

                            <form onSubmit={submitForm}>
                                {/* Email Address */}
                                <div>
                                    <Label htmlFor="email">Email</Label>
                                    <WideInput
                                        id="email"
                                        type="email"
                                        name="email"
                                        value={email}
                                        className="block mt-1 w-full"
                                        onChange={event => setEmail(event.target.value)}
                                        required
                                        autoFocus
                                    />

                                    <InputError messages={errors.email} className="mt-2" />
                                </div>

                                <div className="d-flex align-items-center justify-content-center mt-4">
                                    <WideButton>Email Password Reset Link</WideButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Page
