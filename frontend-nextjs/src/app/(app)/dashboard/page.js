import Header from '@/app/(app)/Header'

export const metadata = {
    title: 'Laravel - Dashboard',
}

const Dashboard = () => {
    return (
        <>
            <Header title="Dashboard" />
            <div className="d-flex justify-content-center align-items-center">
                <div className="py-12">
                    <div className="container-sm px-4">
                        <div className="bg-white overflow-hidden shadow-sm rounded">
                            <div className="p-6 bg-white border-bottom border-gray-200">
                                You are logged in!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Dashboard
