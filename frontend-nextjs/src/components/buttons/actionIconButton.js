import "./actionIconButton.css"

const actionIconButton = (props) => {
    return (
        <button className="action-btn" onClick={props.onClick}>
            <img src={props.img} alt={props.alt} className="" />
        </button>
    )
}

export default actionIconButton;
