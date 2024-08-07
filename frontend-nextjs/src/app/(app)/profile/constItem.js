import "./constItem.css"

const ConstItem = (props) => {
    return (
        <div className="const-items">
            <div className="row col-12">
                <div className="col-8 col-sm-7  col-md-6">
                    <div className="grey-title d-flex justify-content-start">{props.title}</div>
                    <hr className="hr-underline"/>
                </div>
                <div className="col-4 col-sm-5 col-md-6">
                    <div className="data d-flex justify-content-start">{props.data} </div>
                    <hr className="hr-underline"/>
                </div>
            </div>
        </div>
    );
}

export default ConstItem;
