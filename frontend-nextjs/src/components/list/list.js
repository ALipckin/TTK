import ListItem from "./listItem"
import "./listItem.css"
function list(props) {
    return (
        <div className="d-flex justify-content-center mt-5 mb-5 align-items-center">
            <div className="justify-content-center align-items-center">
                <div className="subH text-center"> Что мы предлагаем ?</div>
                <div className="d-flex align-items-center justify-content-center">
                    <ul className="flex-column">
                        <ListItem
                            img={'/images/mainPage/white-list.svg'}
                            text={"Широкая база продуктов"}
                        />
                        <ListItem
                            img={'/images/mainPage/white-checkmark.svg'}
                            text={"Удобный интерфейс"}
                        />
                        <ListItem
                            img={'/images/mainPage/white-pot.svg'}
                            text={"Тонкая настройка параметров"}
                        />
                        <ListItem
                            img={'/images/mainPage/white-fire.svg'}
                            text={"Новые рецепты для всех"}
                        />
                    </ul>
                </div>
            </div>
        </div>
    )
}

export default list
