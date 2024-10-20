import Header from '@/app/(app)/Header'

export const metadata = {
    title: 'Laravel - Dashboard',
}

const Dashboard = () => {
    return (
        <>
            <Header title="Сервис создания ттк" />
            <div className="container">
                <div className="row">
                    <div className="m-3 col-8">
                        <div>
                            <h5>
                                Добро пожаловать!
                            </h5>
                            <br></br>
                            <a href="/profile">Профиль</a>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Dashboard
