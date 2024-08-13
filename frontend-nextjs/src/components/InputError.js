const InputError = ({ messages = [], className = '' }) => {
    // Убедитесь, что messages - это массив
    const errorMessages = Array.isArray(messages) ? messages : [];

    return (
        <>
            {errorMessages.length > 0 && (
                <>
                    {errorMessages.map((message, index) => (
                        <p
                            className={`${className} text-sm text-red-600`}
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
