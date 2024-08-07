import Link from 'next/link'
import "./wide-button.css"
const WideButton = (props) => {
    const { type, href, text, onClick } = props

    if (type === 'button') {
        return (
            <button
                className="wide-button d-flex flex-column align-content-center align-items-center"
                onClick={onClick}
            >
                {text}
            </button>
        )
    }

    return (
        <Link
            href={href}
            className="wide-button d-flex flex-column align-content-center align-items-center"
        >
            {text}
        </Link>
    )
}

export default WideButton
