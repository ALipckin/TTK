import "./iconItem.css"

const IconItem = (props) => {
    return (
        <div className="icon-items">
            <div className="row col-12">
                <div className="icon-card d-flex justify-content-between col-8 col-sm-7  col-md-6">
                    <div className="orange-title">{props.title}</div>
                    <div onClick={props.onClick}><a href={props.href}><img src={props.img} alt=""/></a></div>
                </div>
                {props.data !== null && props.data !== undefined ? (
                    <div className="col-4 col-sm-5 col-md-6">
                        <div className="data d-flex justify-content-start">{(props.data)}</div>
                        <hr className="hr-underline"/>
                    </div>
                ) : null}
            </div>
        </div>
    );
}

export default IconItem;
