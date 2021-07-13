import React from 'react';

const Button = (props) => {
    switch (props.type) {
        case 'secondary':
            return <button onClick={props.onClick} disabled={props.disabled} className="items-center focus:outline-none bg-purple-500 text-white p-3 w-full font-bold rounded text-center hover:bg-purple-400 tranform" >{props.children}</button>
        case 'outlined':
            return <button onClick={props.onClick} disabled={props.disabled} className="items-center text-gray-800 border-2 border-gray-800 p-3 w-full rounded font-bold  text-center hover:bg-gray-800 hover:text-white tranform" >{props.children}</button>
        case 'soft':
            return <button onClick={props.onClick} disabled={props.disabled} className="items-center focus:outline-none bg-gray-300 text-gray-800 p-3 w-full font-bold rounded text-center hover:bg-gray-200 tranform">{props.children}</button>
        case 'danger':
            return <button onClick={props.onClick} disabled={props.disabled} className="items-center focus:outline-none bg-red-500 text-white p-3 w-full font-bold rounded text-center hover:bg-red-400 tranform">{props.children}</button>
        default:
            return <button onClick={props.onClick} disabled={props.disabled} className="items-center focus:outline-none bg-gray-800 text-white p-3 w-full  font-bold rounded text-center hover:bg-gray-700 tranform">{props.children}</button>
    }
}

export default Button;