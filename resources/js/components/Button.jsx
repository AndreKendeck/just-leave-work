import React from 'react';

const Button = (props) => {
    switch (props.type) {
        case 'secondary':
            return <button onClick={props.onClick} disabled={props.disabled} className={`items-center focus:outline-none bg-gray-700 text-white p-2 w-full rounded text-center hover:bg-gray-600 tranform ${props.className}`} >{props.children}</button>
        case 'outlined-secondary':
            return <button onClick={props.onClick} disabled={props.disabled} className={`items-center focus:outline-none bg-white text-gray-700 p-2 w-full rounded text-center border border-gray-700 hover:bg-gray-700 hover:text-white tranform ${props.className}`} >{props.children}</button>
        case 'outlined':
            return <button onClick={props.onClick} disabled={props.disabled} className={`items-center text-purple-500 border border-purple-500 p-2 w-full rounded text-center hover:bg-purple-500 hover:text-white tranform ${props.className}`} >{props.children}</button>
        case 'soft':
            return <button onClick={props.onClick} disabled={props.disabled} className={`items-center focus:outline-none bg-gray-300 text-gray-800 p-2 w-full rounded text-center hover:bg-gray-200 tranform ${props.className}`}>{props.children}</button>
        case 'danger':
            return <button onClick={props.onClick} disabled={props.disabled} className={`items-center focus:outline-none bg-red-500 text-white p-2 w-full rounded text-center hover:bg-red-400 tranform ${props.className}`}>{props.children}</button>
        case 'outlined-danger':
            return <button onClick={props.onClick} disabled={props.disabled} className={`items-center focus:outline-none bg-white text-red-500 border border-red-500 p-2 w-full rounded text-center hover:bg-red-500 hover:text-white tranform ${props.className}`}>{props.children}</button>
        default:
            return <button onClick={props.onClick} disabled={props.disabled} className={`items-center focus:outline-none bg-purple-500 text-white p-2 w-full  rounded text-center hover:bg-purple-400 tranform ${props.className}`}>{props.children}</button>
    }
}

export default Button;