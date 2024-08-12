import "./ttkInput.css";

const TtkInput = ({ title, value, disabled = false, className = '', ...props }) => (
<div className="input-box d-flex justify-content-start align-items-center">
    <p className="title">
        {title}
    </p>
    <input
        className={`input ${className}`}
        disabled={disabled}
        value={value}
        {...props}
    />
</div>
);

export default TtkInput;
