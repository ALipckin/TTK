import "./listItem.css"
function listItem(props) {
    return (
        <li>
            <img className="icon" src={props.img} alt=""/>
            <div className="text">{props.text}
                <hr className="hrUnderline"/>
            </div>
        </li>
    )
}

export default listItem
