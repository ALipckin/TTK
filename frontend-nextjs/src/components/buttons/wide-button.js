import Link from 'next/link'
import "./wide-button.css"
const WideButton = (props) => {
    const { type, href, text, onClick, className } = props

    if (type === 'button') {
        return (
            <button
                className={`wide-button d-flex flex-column align-content-center align-items-center ${className}`}
                onClick={onClick} {...props}
            >
                {text}
            </button>
        )
    }

    return (
        <Link
            href={href}
            className={`wide-button d-flex flex-column align-content-center align-items-center ${className}`}
        >
            {text}
        </Link>
    )
}

export default WideButton
