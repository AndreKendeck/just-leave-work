import { collect } from 'collect.js';
import React from 'react';

const Checkbox = (props) => {

    const getErrors = () => {
        return collect(props.errors).flatten().map((error, index) => {
            return <span className="text-red-800 text-sm" key={index}>{error}</span>
        })
    }
    return (
        <div className="flex flex-col space-y-1">
            <div className="flex flex-row space-x-1 items-center">
                <input type='checkbox' onChange={props.onChange} id={props.name} name={props.name}
                    className={`form-checkbox border-2 text-gray-800`} checked={props.checked} />
                <label htmlFor={props.name} className="text-gray-600">{props.label ? props.label : props.name}</label>
            </div>
            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
        </div>
    )
}

export default Checkbox;