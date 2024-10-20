import { useState } from 'react';
import "./dropdown.css";
import { useAuth } from '@/hooks/auth';
const Dropdown = () => {
    const { logout } = useAuth()
    const [isOpen, setIsOpen] = useState(false);

    const toggleDropdown = () => {
        setIsOpen(!isOpen);
    };

    return (
        <div className="main-div">
            <button onClick={toggleDropdown} className="main-button"
                    style={{ backgroundImage: 'url(\'/images/defaultAvatarOrange.png\')' }} />
            {isOpen && (
                <div className="window">
                    <button className="button" onClick={logout}>
                        Выход
                    </button>
                    <a href="/profile" className="button">
                        Профиль
                    </a>
                </div>
            )}
        </div>
    );
};

export default Dropdown;
