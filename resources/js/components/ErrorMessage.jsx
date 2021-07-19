import React, { useState } from "react";

const ErrorMessage = ({ text, onDismiss }) => {
    const [visible, setVisible] = useState(true);
    return (
        <div className={`flex flex-row justify-beteen items-center w-full bg-red-500 bg-opacity-25 text-red-800 p-4 rounded ${visible ? '' : 'hidden'}`}>
            <div className="w-full">
                {text}
            </div>
            <button onClick={(event) => { setVisible(false); onDismiss; }} className="hover:bg-red-100 p-1 focus:outline-none rounded">
                <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-red-800 h-6 w-6" xmlns="http://www.w3.org/2000/svg" >
                    <g fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 8l8 8">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8l-8 8">
                        </path>
                    </g>
                </svg>
            </button>
        </div>
    )
};

export default ErrorMessage;