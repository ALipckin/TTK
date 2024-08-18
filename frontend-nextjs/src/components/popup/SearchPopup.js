// components/SearchPopup.js

import { useState } from 'react';

const SearchPopup = ({apiRoute}) => {
    const [isOpen, setIsOpen] = useState(false);
    const [query, setQuery] = useState('');
    const [results, setResults] = useState([]);

    const handleClick = () => {
        setIsOpen(!isOpen);
    };

    const handleSearch = async () => {
        // Пример запроса на API. Замените URL на ваш.
        const response = await fetch(`${apiRoute}?name=${query}`);
        const data = await response.json();
        setResults(data);
    };

    const handleChange = (e) => {
        setQuery(e.target.value);
    };

    const handleSelect = (item) => {
        setQuery(item);
        setIsOpen(false);
    };

    return (
        <div>
            <button onClick={handleClick}>Открыть поиск</button>
            {isOpen && (
                <div className="search-popup">
                    <input
                        type="text"
                        value={query}
                        onChange={handleChange}
                        onKeyDown={(e) => e.key === 'Enter' && handleSearch()}
                    />
                    <button onClick={handleSearch}>Поиск</button>
                    <ul>
                        {results.map((item, index) => (
                            <li key={index} onClick={() => handleSelect(item)}>
                                {item}
                            </li>
                        ))}
                    </ul>
                </div>
            )}
            <style jsx>{`
        .search-popup {
          position: absolute;
          top: 50px;
          left: 0;
          border: 1px solid #ccc;
          padding: 10px;
          background: white;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          width: 200px;
        }
        ul {
          list-style-type: none;
          padding: 0;
          margin: 0;
        }
        li {
          padding: 5px;
          cursor: pointer;
        }
        li:hover {
          background-color: #f0f0f0;
        }
      `}</style>
        </div>
    );
};

export default SearchPopup;
