import "./error.css"
const TtkError = ({ messages , className = '' }) => {
    // Убедитесь, что messages - это массив
    console.log(messages)
    return (
        messages ? <div className={'error ' + className}>{messages}</div> : null
    );
};

export default TtkError;
