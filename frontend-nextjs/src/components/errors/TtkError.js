import styles from "./Error.module.css";

const TtkError = ({ messages, className = '' }) => {
    // Убедитесь, что messages - это массив
    if (!Array.isArray(messages)) {
        console.error("messages должен быть массивом");
        return null;
    }

    return (
        messages.length > 0 ? (
            <div className={`${styles['error-text']} ${className}`}>
                {messages.map((message, index) => (
                    <p key={index}>{message}</p>
                ))}
            </div>
        ) : null
    );
};

export default TtkError;
