// components/PopUpSearchButton.js
import { useState, useRef, useEffect } from 'react';
import axios from 'axios';

const SearchPopup = ({apiRoute, selectedItemId, setSelectedItemId,currItem}) => {
    const [isVisible, setIsVisible] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);
    const [selectedItem, setSelectedItem] = useState(false);

    const popUpRef = useRef(null); // Ссылка на попап
    const buttonRef = useRef(null); // Ссылка на кнопку

    const handleSearch = async () => {
        setLoading(true);
        try {
            const response = await axios.get(`${apiRoute}`,
                { params: { name: searchTerm },  withCredentials: true }
                );
            setResults(response.data.data);
        } catch (error) {
            console.error("Error fetching search results", error);
        } finally {
            setLoading(false);
        }
    };

    const handleClick = () => {
        setIsVisible(!isVisible);
    };

    const handleClose = () => {
        setIsVisible(false);
    };
    const setItem = (item) => {
        setSelectedItem(item.name);
        setSelectedItemId(item.id);
        setIsVisible(false);
    }
    // Закрыть попап, если кликнули вне его
    useEffect(() => {
        const handleClickOutside = (event) => {
            // Проверяем, что клик был вне кнопки и попапа
            if (
                buttonRef.current && !buttonRef.current.contains(event.target) &&
                popUpRef.current && !popUpRef.current.contains(event.target)
            ) {
                setIsVisible(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    return (
        <div style={{ position: 'relative' }}>
            <button ref={buttonRef} onClick={handleClick}>
                {selectedItem ? selectedItem : currItem}
            </button>
            {isVisible && (
                <div
                    ref={popUpRef}
                    style={{
                        position: 'absolute',
                        top: '100%', // Позиционируем попап под кнопкой
                        left: 0,
                        backgroundColor: 'white',
                        border: '1px solid #ddd',
                        padding: '10px',
                        zIndex: 1000,
                        width: '200px' // Установите ширину по вашему усмотрению
                    }}
                >
                    <input
                        type="text"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        onKeyPress={(e) => {
                            if (e.key === 'Enter') {
                                handleSearch();
                            }
                        }}
                    />
                    <button onClick={handleSearch} disabled={loading}>
                        {loading ? 'Loading...' : 'Search'}
                    </button>
                    <button onClick={handleClose}>Close</button>
                    <ul>
                        {results.map((result, index) => (
                            <li key={index} onClick={() => setItem(result)}>{result.name}</li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
};

export default SearchPopup;
