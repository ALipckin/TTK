import styles from "./Error.module.css";

const TtkError = ({ messages, className = '' }) => {
    // Убедитесь, что messages - это массив

    if (Array.isArray(messages)) {
        return (
            messages.length > 0 ? (
                <div className={`${styles['error-text']} ${className}`}>
                    {messages.map((message, index) => (
                        <p key={index}>{message}</p>
                    ))}
                </div>
            ) : null
        );
    }else{
        return (
            <div className={`${styles['error-text']} ${className}`}>
                    <p>{messages}</p>
            </div>
        )
    }
};

export default TtkError;
