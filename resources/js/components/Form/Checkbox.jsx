import { collect } from 'collect.js';
import React from 'react';

const Checkbox = ({ name, label, onChange, errors = [], checked, disabled = false }) => {

    const getErrors = () => {
        return collect(errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }
    return (
        <div className="flex flex-col space-y-1">
            <div className="flex flex-row space-x-1 items-center">
                <input type="checkbox" disabled={disabled} onChange={onChange} id={name} name={name}
                    className={`${disabled ? 'bg-gray-500' : null} form-checkbox border-2 text-purple-500`} checked={checked} />
                <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>
            </div>
            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
        </div>
    )
}

export default Checkbox;