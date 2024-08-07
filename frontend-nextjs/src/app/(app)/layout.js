'use client'

import { useAuth } from '@/hooks/auth'
import Navigation from '@/app/(app)/Navigation'
import Loading from '@/app/(app)/Loading'
import 'bootstrap/dist/css/bootstrap.min.css'

const AppLayout = ({ children }) => {
    const { user } = useAuth({ middleware: 'auth' })
    if (!user) {
        return <Loading />
    }
    return (
        <div className="min-vh-100 bg-light">
            <Navigation user={user} />
            <main className="py-4">{children}</main>
        </div>
    )
}

export default AppLayout
