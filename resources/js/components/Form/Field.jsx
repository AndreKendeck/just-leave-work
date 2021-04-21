import React from 'react';

const Field = (props) => {
    const getErrors = () => {
        if (props.errors?.length > 0) {
            return props.errors.map((error, key) => {
                return <span className="text-red-800 text-sm" key={key}>{error}</span>
            });
        }
    }
    return (
        <div className="flex flex-col space-y-1">
            <label htmlFor={props.name} className="text-gray-600">{props.label ? props.label : props.name}</label>
            <input type={props.type ? props.type : 'text '} onKeyUp={props.onKeyUp} id={props.name} name={props.name} className="form-input border-2 border-gray-300 rounded-lg" />
            <div className="flex flex-col space-y-1">
                {getErrors()}
            </div>
        </div>
    )
}

export default Field;