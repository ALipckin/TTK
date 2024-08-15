import Link from 'next/link';
import "./WideButton.css";
import React from 'react';

const WideButton = ({ href = "#", onClick, className = "", iconSrc, children, ...props }) => {
    const buttonContent = (
        <>
            <div className="d-flex justify-content-start">
                {iconSrc && <img src={iconSrc} alt="icon" className="button-icon" />}
            </div>
            <div className={`d-flex justify-content-start ${iconSrc ? "p-l" : "p-l-full"}`}>
            {children}
            </div>
        </>
    );

    if (props.type === "button") {
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
            <Link href={href} passHref>
                <a className={`${className} wide-button text-center`} {...props}>
                    {buttonContent}
                </a>
            </Link>
        );
    }
};

export default WideButton;
