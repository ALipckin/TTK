import Link from 'next/link';
import "./WideButton.css";
import React from 'react';

const WideButton = ({ href = "#", onClick, text = "",className = "", iconSrc, children, type = "button", ...props }) => {
    const buttonContent = (
        <>
            <div className="d-flex justify-content-start">
                {iconSrc && <img src={iconSrc} alt="icon" className="button-icon" />}
            </div>
            <div className={`d-flex justify-content-start ${iconSrc ? "p-l" : "p-l-full"}`}>
                {text}{children}
            </div>
        </>
    );

    if (type === "button") {
        return (
            <button
                className={`${className} wide-button text-center`}
                onClick={onClick}
                {...props}
            >
                {buttonContent}
            </button>
        );
    } else {
        return (
            <Link href={href}
                className={`${className} wide-button text-center`} {...props}>
                    {buttonContent}
            </Link>
        );
    }
};

export default WideButton;
