import "./AuthInput.css";

const AuthInput = ({ disabled = false, className = '', ...props }) => (
    <input
        disabled={disabled}
        className={`input default-class ${className}`}
        {...props}
    />
);

export default AuthInput;
