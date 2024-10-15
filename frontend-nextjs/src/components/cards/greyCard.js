import React from 'react'
import './greyCard.css'
import { redirect } from 'next/navigation'
import { useRouter } from 'next/navigation'
function GreyCard({ title, actions, onActionClick, actionRoute, href, children}) {
    const id = 0
    const router = useRouter();
    return (
        <div className="greyCard d-flex align-items-end w-75" onClick={onActionClick}>
            <div className="m-1 d-flex justify-content-between w-100">
                <div className="card-content d-flex justify-content-between align-items-end">
                    <div>
                        <a className="title" href={href}>{title}</a>
                    </div>
                </div>
                <div className="card-actions d-flex justify-content-end" style={{ background: 'transparent' }}>
                    {actions && actions.map((ActionComponent, index) => (
                        <ActionComponent key={index} id={id} actionRoute={actionRoute}/>))}
                    {children}
                </div>
            </div>
        </div>
    )
}

export default GreyCard
