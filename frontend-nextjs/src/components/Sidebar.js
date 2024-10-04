// components/Sidebar.js
import { useState } from 'react';
import styles from './Sidebar.module.css'; // Подключаем CSS модули
import  "../app/(app)/Navigation.css";
const Sidebar = () => {
    const [isOpen, setIsOpen] = useState(false);

    const toggleSidebar = () => {
        setIsOpen(!isOpen);
    };

    return (
        <>
            <button style={{backgroundImage: 'url(\'/images/menu.svg\')'}} onClick={toggleSidebar} className="icon-button m-4" />
            <div className={`${styles.sidebar} ${isOpen ? styles.open : ''}`}>
                <button onClick={toggleSidebar} className={styles.closeButton}>
                    ×
                </button>
                <nav className={styles.sidebarNav}>
                    <ul>
                        <li><a href="/profile">Мой аккаунт</a></li>
                        <li><a href="/drafts">Черновики</a></li>
                        <li><a href="/products">Список продуктов</a></li>
                        <li><a href="/products/my">Мои список продуктов</a></li>
                        <li><a href="/ttks">Каталог технологических карт</a></li>
                    </ul>
                </nav>
            </div>
        </>
    );
};

export default Sidebar;
