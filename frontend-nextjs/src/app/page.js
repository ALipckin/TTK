import WideButton from '@/components/buttons/WideButton'
import List from '@/components/list/list'
import "./mainPage.css"
export const metadata = {
    title: 'Laravel',
}
const Home = () => {
    return (
        <>
            <div
                className="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                <div className="background description_text">
                    <div className=" container">
                        <div className="row">
                            <div className="description_text mainH pb-5 pt-5 col-md-12">
                                Создавайте <br />блюда <br /> вместе с <br /> сервисом создания ттк
                            </div>
                            <div className="col-md-12">
                                <hr className="hr-wide" />
                                <div className="d-flex justify-content-center">
                                    <List />
                                </div>
                                <hr className="hr-wide" />
                            </div>
                            <div className="d-flex justify-content-center col">
                                <div className="justify-content-center mt-5 mb-5 ">
                                    <p>Мы всегда стараемся<br /> прислушиваться к пользователям,<br /> чтобы улучшать
                                        наш
                                        продукт.</p>
                                </div>
                            </div>

                            <div className="col-md-12">
                                <hr className="hr-wide" />
                                <div className="d-flex justify-content-center">
                                    <div className="mt-5 mb-5">
                                        <div className="subH">Начните работу прямо сейчас</div>
                                        <p className="mb-5 mt-4">Хотите приступить к работе чтобы <br />
                                            немедленно начать создание<br />
                                            технико-технологических карт или<br />
                                            чтобы скачать их?</p>
                                        <div className="d-flex justify-content-center">
                                            <WideButton text={"Зарегистрироваться"} href="/register"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Home
