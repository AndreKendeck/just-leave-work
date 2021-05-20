import { collect } from 'collect.js';
import React from 'react';

const Field = (props) => {

    const getErrors = () => {
        return collect(props.errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }
    return (
        <div className="flex flex-col space-y-1">
            <label htmlFor={props.name} className="text-gray-600">{props.label ? props.label : props.name}</label>
            <input type={props.type ? props.type : 'text '} readOnly={props.readOnly} value={props.value} onChange={props.onChange} onKeyUp={props.onKeyUp} id={props.name} name={props.name}
                className={`form-input border-2  rounded-lg ${props.hasError ? 'border-red-500' : 'border-gray-300'}`} />
            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
        </div>
    )
}

export default Field;