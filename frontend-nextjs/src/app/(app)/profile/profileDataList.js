import ConstItem from "./constItem";
import IconItem from "./iconItem";

const profileDataList = () => {

    const registrationDate = "10.10.2024";
    const lastVisit = "10.10.2024";
    const views = "6";
    const worksNum = "4";
    const downloadsNum = "3";
    const draftsNum = "2";
    const productsNum = "1";


    return (
        <div className="mt-4 d-flex flex-column justify-content-start">
            <ul className="mb-2 p-0">
                <ConstItem title="Дата регистрации" data={registrationDate}/>
                <ConstItem title="Последний визит" data={lastVisit}/>
                <ConstItem title="Просмотры" data={views}/>
            </ul>
            <ul className="p-0">
                <IconItem title="Мои работы" data={worksNum} img={`${process.env.PUBLIC_URL}/images/picture.svg`}/>
                <IconItem title="Скаченные работы" data={downloadsNum} img={`${process.env.PUBLIC_URL}/images/picture.svg`}/>
                <IconItem title="Черновики" data={draftsNum} img={`${process.env.PUBLIC_URL}/images/edit.svg`}/>
                <IconItem title="Мои список продуктов" data={productsNum} img={`${process.env.PUBLIC_URL}/images/radish.svg`}/>
                <IconItem title="Создать новую карту" img={`${process.env.PUBLIC_URL}/images/add.svg`}/>
            </ul>
        </div>
     
    );
}

export default profileDataList;
