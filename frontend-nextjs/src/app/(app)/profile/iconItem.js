import "./iconItem.css"
const IconItem = ({title, href, img, data, onClick, imgClass, imgParams, mainContainerClass = "col-8 col-sm-7 col-md-6" }) => {
    return (
        <div className="icon-items">
            <div className="row col-12">
                <div className={`icon-card d-flex justify-content-between ${mainContainerClass}`}>
                    <div className="orange-title">{title}</div>
                    <div className="d-flex align-items-center" onClick={onClick}><a className={imgClass}><img {...imgParams} src={img} alt="Скачать pdf" className={imgClass}/></a></div>
                </div>
                {data !== null && data !== undefined ? (
                    <div className="col-4 col-sm-5 col-md-6">
                        <div className="data d-flex justify-content-start">{(data)}</div>
                        <hr className="hr-underline"/>
                    </div>
                ) : null}
            </div>
        </div>
    );
}

export default IconItem;
