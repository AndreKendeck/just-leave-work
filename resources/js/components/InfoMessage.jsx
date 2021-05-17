import React, { useState } from "react";

const InfoMessage = (props) => {
    const [visible, setVisible] = useState(true);
    return (
        <div className={`flex flex-row justify-beteen items-center w-full bg-blue-300 bg-opacity-25 text-blue-800 p-4 rounded ${visible ? '' : 'hidden'}`}>
            <div className="w-full">
                {props.text}
            </div>
            <button onDismiss={props.onDismiss} onClick={(event) => { setVisible(false); props.onDismiss(); }} className="hover:bg-blue-200 p-1 focus:outline-none rounded">
                <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-blue-800 h-6 w-6" xmlns="http://www.w3.org/2000/svg" ><g fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 8l8 8">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8l-8 8">
                    </path></g>
                </svg>
            </button>
        </div>
    )
};

export default InfoMessage;