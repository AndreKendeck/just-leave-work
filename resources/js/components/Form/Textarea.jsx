import collect from 'collect.js';
import React from 'react';

const getErrors = (errors = []) => {
    return collect(errors).flatten().map((err, idx) => {
        return <span className="text-red-800 text-sm" key={idx}>{err}</span>
    });
}
const TextArea = ({ errors = [], name, label = null, value = null, onKeyUp, onChange, tip, disabled = false }) => {
    return (
        <div className="flex flex-col space-y-1">
            <label htmlFor={name} className="text-gray-600">{label ? label : name}</label>
            <textarea name={name} id={name} value={value} onKeyUp={onKeyUp} onChange={(e) => onChange(e)} disabled={disabled}
                className="form-input form-input border-2 rounded-lg" cols="30" rows="10">
            </textarea>
            <div className="flex flex-col space-y-1">
                {getErrors(errors)}
            </div>
            {tip ? (
                <div className="w-full text-gray-500 text-sm">{tip}</div>
            ) : null}
        </div>
    );
}

export default TextArea;