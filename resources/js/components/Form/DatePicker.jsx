import { collect } from 'collect.js';

import React, { useState } from 'react';
import 'react-date-range/dist/styles.css'; // main style file
import 'react-date-range/dist/theme/default.css'; // theme css file
import { DateRange, DateRangePicker } from 'react-date-range';


const DatePicker = ({ errors, name, label, onChange, tip }) => {


    const [range, setRange] = useState({ startDate: new Date(), endDate: new Date(), key: 'selection' });

    const getErrors = () => {
        return collect(errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }
    return (
        <div className="flex flex-col space-y-1 w-full">
            <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>

            <div className="hidden md:flex">
                <DateRangePicker ranges={[range]} showDateDisplay={false}
                    rangeColors={['#9f7aea']} direction="horizontal"
                    showSelectionPreview={true} onChange={(ranges) => {
                        const { selection } = ranges;
                        setRange(selection);
                        onChange(selection);
                    }} />
            </div>
            <div className="md:hidden">
                <DateRange ranges={[range]} showDateDisplay={false}
                    rangeColors={['#9f7aea']}  className="w-full"
                    direction="horizontal"
                    showSelectionPreview={true} onChange={(ranges) => {
                        const { selection } = ranges;
                        setRange(selection);
                        onChange(selection);
                    }} />
            </div>

            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
            {tip ? (
                <div className="w-full text-gray-500 text-sm">{tip}</div>
            ) : null}
        </div>
    )
}

export default DatePicker;