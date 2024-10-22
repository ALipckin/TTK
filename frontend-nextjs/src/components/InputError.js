const InputError = ({ messages = [], className = '' }) => {
    // Убедитесь, что messages - это массив
    const errorMessages = Array.isArray(messages) ? messages : [];

    return (
        <>
            {errorMessages.length > 0 && (
                <>
                    {errorMessages.map((message, index) => (
                        <p
                            className={`${className}`}
                            key={index}
                        >
                            {message}
                        </p>
                    ))}
                </>
            )}
        </>
    );
};

export default InputError;
