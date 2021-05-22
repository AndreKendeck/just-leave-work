import { collect } from 'collect.js';
import React from 'react';

/**
 * options should structure in this way
 * @var {object} { value : any , label : any }
 */
const Dropdown = ({ options, errors, hasError, selectedOption, name, label, onChange }) => {

    const getErrors = (errors) => {
        return collect(errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }

    const mapOptions = (options) => {
        return options?.map(option => {
            if (selectedOption?.value === option?.value) {
                return (
                    <option className="text-gray-800 text-base" selected={true} value={option?.value}>{option?.label}</option>
                );
            }
            return (
                <option className="text-gray-800 text-base" value={option?.value}>{option?.label}</option>
            )
        })
    }
    return (
        <div className="flex flex-col space-y-1">
            <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>
            <select onChange={onChange} name={name} id={name} className={`form-select border-2  rounded-lg ${hasError ? 'border-red-500' : 'border-gray-300'}`}>
                {mapOptions(options)}
            </select>
            <div className="flex flex-col space-y-1">
                {getErrors(errors)}
            </div>
        </div>
    )
}

export default Dropdown;