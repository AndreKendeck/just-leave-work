import React, { useState } from "react";

const InfoMessage = ({ text, onDismiss }) => {
    const [visible, setVisible] = useState(true);
    if (visible) {
        return (
            <div className="bg-white rounded-lg shadow p-2 pb-10 flex flex-col items-center w-full h-full border-purple-800 border-2">
                <div className="w-full flex flex-row justify-between items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-purple-500 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <button onClick={(event) => { setVisible(false); onDismiss(event); }} className="hover:bg-purple-200 p-1 focus:outline-none rounded">
                            <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-purple-500 h-6 w-6" xmlns="http://www.w3.org/2000/svg" ><g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 8l8 8">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8l-8 8">
                                </path></g>
                            </svg>
                        </button>
                    </div>
                </div>
                <div className="w-full text-purple-500 text-lg text-center">
                    {text}
                </div>
            </div>
        )
    }
    return null;
};

export default InfoMessage;