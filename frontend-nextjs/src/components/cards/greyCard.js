import React, { useState } from 'react';
import './greyCard.css';

function GreyCard({ title, actions, onActionClick, apiUrl }) {
    const id = 0;
    return (
        <div className="greyCard" onClick={onActionClick}>
            <div className="card-content d-flex justify-content-between align-items-end">
                <div>
                    {title}
                </div>
                <div className="icons row justify-content-end align-items-end">
                    {/* Иконки или другие элементы */}
                </div>
            </div>
                <div className="card-actions">
                    {actions && actions.map((ActionComponent, index) => (
                        <ActionComponent key={index} id={id} apiUrl={apiUrl}/>
                    ))}
                </div>
        </div>
    );
}

export default GreyCard;
