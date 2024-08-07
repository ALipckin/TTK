const Header = ({ title }) => {
    return (
        <header className="bg-light shadow-sm">
            <div className="container py-6 px-4">
                <h2 className="font-weight-bold text-xl text-dark">
                    {title}
                </h2>
            </div>
        </header>
    )
}

export default Header
