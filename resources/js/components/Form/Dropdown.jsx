import { collect } from 'collect.js';
import React from 'react';



const Dropdown = ({ options, errors, hasError, name, label, onChange, tip }) => {

    const getErrors = (errors) => {
        return collect(errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }

    const mapOptions = (options) => {
        return options?.map((option, index) => {
            // first option is always selected
            if (index === 0) {
                return (
                    <option key={index} className="text-gray-800 text-base"  selected={true} value={option?.value}>{option?.label}</option>
                );
            }
            return (
                <option key={index} className="text-gray-800 text-base" value={option?.value}>{option?.label}</option>
            )
        })
    }
    return (
        <div className="flex flex-col space-y-1 w-full">
            <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>
            <select defaultValue="Choose" onChange={onChange} name={name} id={name} className={`form-select border-2  rounded-lg ${hasError ? 'border-red-500' : 'border-gray-300'}`}>
                {mapOptions(options)}
            </select>
            <div className="flex flex-col space-y-1">
                {getErrors(errors)}
            </div>
            {tip ? (
                <div className="w-full text-gray-500 text-sm">{tip}</div>
            ) : null}
        </div>
    )
}

export default Dropdown;