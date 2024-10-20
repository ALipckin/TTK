import "./ActionIconButton.css"

const actionIconButton = ({buttonClassName, className,...props}) => {
    return (
        <button className={`action-btn ${buttonClassName}`} onClick={props.onClick} {...props} >
            <img src={props.img} alt={props.alt} className={className} />
        </button>
    )
}

export default actionIconButton;
