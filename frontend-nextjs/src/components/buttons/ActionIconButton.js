import "./ActionIconButton.css"

const actionIconButton = ({className,...props}) => {
    return (
        <button className={`${className} action-btn`} onClick={props.onClick}>
            <img src={props.img} alt={props.alt} className="" />
        </button>
    )
}

export default actionIconButton;
