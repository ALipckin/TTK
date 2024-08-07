import "./Input.css";

const Input = ({ disabled = false, className = '', ...props }) => (
    <input
        disabled={disabled}
        className={`input default-class ${className}`}
        {...props}
    />
);

export default Input;
