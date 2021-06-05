import { collect } from 'collect.js';
import moment from 'moment';
import React from 'react';
import Calendar from 'react-calendar';


const DatePicker = ({ value, errors, name, label, onChange, hasError }) => {

    const getErrors = () => {
        return collect(errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }
    return (
        <div className="flex flex-col space-y-1">
            <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>
            <Calendar returnValue="range" selectRange={true} allowPartialRange={true} onChange={onChange} value={value} className="form-input" />
            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
        </div>
    )
}

export default DatePicker;