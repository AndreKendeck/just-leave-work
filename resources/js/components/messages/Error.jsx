import React from 'react';

const Error = ({ message, onClose }) => {
    return (
        <div className="p-4 bg-red-300 flex flex-col space-y-2 w-full">
            <div className="flex flew-row items-center justify-between">
                <span className="text-red-800 text-sm">
                    {message}
                </span>
                <button type="button" onClick={(e) => onClose(e)} className="px-3 py-1 rounded focus:outline-none hover:bg-red-500 text-sm" >&times;</button>
            </div>
        </div>
    )
}

export default Error;
