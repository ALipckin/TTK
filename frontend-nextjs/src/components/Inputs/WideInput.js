import "./WideInput.css";

const WideInput = ({ disabled = false, className = '', ...props }) => (
    <input
        disabled={disabled}
        className={`input default-class ${className}`}
        {...props}
    />
);

export default WideInput;
