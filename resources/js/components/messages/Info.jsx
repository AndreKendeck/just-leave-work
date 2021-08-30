import React from 'react';

const Info = ({ message, onClose }) => {
    return (
        <div className="p-4 bg-green-300 flex flex-col space-y-2 w-full">
            <div className="flex flew-row items-center justify-between">
                <span className="text-green-800 text-sm">
                    {message}
                </span>
                <button type="button" onClick={(e) => { onClose(e) }} className="px-3 py-1 rounded focus:outline-none hover:bg-green-500 text-sm" >&times;</button>
            </div>
        </div>
    )
}

export default Info;
