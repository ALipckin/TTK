// components/PopUpSearchButton.js
import { useState, useRef, useEffect } from 'react';
import axios from 'axios';
import PopupBox from '@/components/popup/PopupBox'
import WideButton from '@/components/buttons/WideButton'
import WideInput from '@/components/Inputs/WideInput'

const SearchPopup = ({apiRoute, itemName, selectedItemId, setSelectedItemId, currItem, mButtonClassName}) => {
    const [searchTerm, setSearchTerm] = useState('');
    const [loading, setLoading] = useState(false);
    const [newItem, setNewItem] = useState(null);
    const [results, setResults] = useState([]);

    useEffect(() => {
            if (!newItem) {
                setNewItem(currItem)
            }
        }
    );

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


    return (
        <PopupBox itemName={"name"} currItem={newItem} >
            <div className="">
         <WideInput
            className={"block mt-1 content-width m-0"} type="text" value={searchTerm}
            placeholder="Поиск"
            onChange={(e) => setSearchTerm(e.target.value)}
            onKeyPress={(e) => {
                if (e.key === 'Enter') {
                   handleSearch();
               }
            }
         }/>
                <div className="d-flex justify-content-center">
                    <WideButton className={"h-25 pt-1 pb-1 m-1"} onClick={handleSearch} disabled={loading}>{loading ? 'Загрузка...' : 'Найти'}</WideButton>
                </div>
            </div>
            <ul className={"m-0 p-0"}>
                {results.map((item, index) => (
                    <li className="item" key={index} onClick={() => setNewItem(item[itemName])}>{item[itemName]}</li>
                ))}
            </ul>
        </PopupBox>
    );
};

export default SearchPopup;
