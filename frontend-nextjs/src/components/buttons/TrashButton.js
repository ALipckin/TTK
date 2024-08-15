import "./Trash.css";
import React, { useState } from 'react';
import WideButton from '@/components/buttons/WideButton'
const TrashButton= (props) => {
    return (
            <button className="trash-button" onClick={props.onClick}>
                <img src={'/images/trash.svg'} alt={props.alt} className=""/>
            </button>
    )
}

export default TrashButton;
