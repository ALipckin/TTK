import "./ttkInput.css";

const TtkInput = ({ title, value, disabled = false,
                      titleClassName = '', className = '', onChange,
                      ...props }) => (
<div className="input-box d-flex justify-content-start align-items-center">
    <p className={`title ${titleClassName}`}>
        {title}
    </p>
    <input
        className={`input ${className} ${title ? "ml-1" : ""}`}
        disabled={disabled}
        value={value}
        onChange={onChange}
        {...props}
    />
</div>
);

export default TtkInput;
