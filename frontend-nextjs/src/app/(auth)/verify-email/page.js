'use client'

import { useAuth } from '@/hooks/auth'
import { useState } from 'react'
import WideButton from '@/components/buttons/WideButton'

const Page = () => {
    const { logout, resendEmailVerification } = useAuth({
        middleware: 'auth',
        redirectIfAuthenticated: '/dashboard',
    })

    const [status, setStatus] = useState(null)

    return (
        <>
            <div className="mb-4 text-sm text-gray-600">
                Thanks for signing up! Before getting started, could you verify
                your email address by clicking on the link we just
                emailed to you? If you didn't receive the email, we will gladly
                send you another.
            </div>

            {status === 'verification-link-sent' && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    A new verification link has been sent to the email address
                    you provided during registration.
                </div>
            )}

            <div className="mt-4 flex items-center justify-between">
                <WideButton onClick={() => resendEmailVerification({ setStatus })}>
                    Resend Verification Email
                </WideButton>

                <button
                    type="button"
                    className="underline text-sm text-gray-600 hover:text-gray-900"
                    onClick={logout}>
                    Logout
                </button>
            </div>
        </>
    )
}

export default Page
