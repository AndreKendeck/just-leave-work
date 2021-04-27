import React from 'react';

const Button = (props) => {
    switch (props.type) {
        case 'outlined':
            return <button onClick={props.onClick} className="text-gray-800 border-2 border-gray-800 p-2 w-full rounded text-center hover:bg-gray-800 hover:text-white" >{props.children}</button>
        case 'soft':
            return <button onClick={props.onClick} className="focus:outline-none bg-gray-300 text-gray-800 p-2 w-full rounded text-center hover:bg-gray-200" >{props.children}</button>
        case 'danger':
            return <button onClick={props.onClick} className="focus:outline-none bg-red-500 text-white p-2 w-full rounded text-center hover:bg-red-400" >{props.children}</button>
        default:
            return <button onClick={props.onClick} className="focus:outline-none bg-gray-800 text-white p-2 w-full rounded text-center hover:bg-gray-700" >{props.childrens}</button>
    }
}

export default Button;