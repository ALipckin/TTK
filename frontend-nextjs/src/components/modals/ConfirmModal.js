// components/Modal.js
import React from 'react';
import "./ConfirmModal.css"// Импортируйте стили

const ConfirmModal = ({ isVisible, onClose, children }) => {
    if (!isVisible) return null;
    return (
        <div className="modalOverlay" onClick={onClose}>
            <div className="modalContent" onClick={e => e.stopPropagation()}>
                <button onClick={onClose} className="closeButton">X</button>
                {children}
            </div>
        </div>
    );
};

export default ConfirmModal;
