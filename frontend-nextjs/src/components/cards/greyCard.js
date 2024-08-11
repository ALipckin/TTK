import React from 'react'
import './greyCard.css'

function GreyCard({ title, actions, onActionClick, apiUrl }) {
    const id = 0
    return (
        <div className="greyCard d-flex align-items-end w-75" onClick={onActionClick}>
            <div className="m-1 d-flex justify-content-between w-100">
                <div className="card-content d-flex justify-content-between align-items-end">
                    <div>
                        {title}
                    </div>
                </div>
                <div className="card-actions d-flex justify-content-end" style={{ background: 'transparent' }}>
                    {actions && actions.map((ActionComponent, index) => (
                        <ActionComponent key={index} id={id} apiUrl={apiUrl} />))}
                </div>
            </div>
        </div>
    )
}

export default GreyCard
