import { collect } from 'collect.js';
import React from 'react';
import ReactDatePicker from 'react-datepicker';


const DatePicker = ({ value, errors, name, label, onChange, hasError }) => {

    const getErrors = () => {
        return collect(errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }

    return (
        <div className="flex flex-col space-y-1">
            <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>
            <ReactDatePicker selected={value} className={`form-input border-2  rounded-lg w-full ${hasError ? 'border-red-500' : 'border-gray-300'}`} onChange={onChange} />
            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
        </div>
    )
}

export default DatePicker;