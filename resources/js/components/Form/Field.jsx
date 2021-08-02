import { collect } from 'collect.js';
import React from 'react';

const Field = ({ name, label, errors = [], tip, onKeyUp, onChange, hasError = false, readOnly = false, type = 'text', placeHolder, value, disabled = false }) => {

    const getErrors = () => {
        return collect(errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }
    return (
        <div className="flex flex-col space-y-1 w-full">
            <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>
            <input type={type} readOnly={readOnly} disabled={disabled} value={value} placeholder={placeHolder} onChange={onChange} onKeyUp={onKeyUp} id={name} name={name}
                className={`form-input ${disabled ? 'bg-gray-200 text-gray-500' : null} border-2 placeholder-gray-400 rounded-lg ${hasError ? 'border-red-500' : 'border-gray-300'}`} />
            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
            {tip ? (
                <div className="w-full text-gray-500 text-sm">{tip}</div>
            ) : null}
        </div>
    )
}

export default Field;