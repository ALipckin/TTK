import '@/components/Inputs/TtkInput.css'
import "./InfoCard.css"
export default function InfoCard({title, item, children, className, ...params}) {
    return (
            <div className={"d-flex justify-content-start row col-12 " + className}>
                <div className="ttk-title col-3">
                    {title}
                </div>
                <div className="input-box info-item text-end  col-9">
                    {item}{children}
                </div>
            </div>
    )
}
