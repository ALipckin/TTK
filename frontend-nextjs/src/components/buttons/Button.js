import "./WideButton.css"
const Button = ({ type = 'submit', className, ...props }) => (
    <button
        type={type}
        className={`${className} wide-button d-flex flex-column align-content-center align-items-center`}
        {...props}
    />
)

export default Button
