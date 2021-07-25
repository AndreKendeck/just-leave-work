import moment from 'moment';
import React from 'react';


const LeaveDaysLabel = ({ leave }) => {
    if (leave?.isForOneDay) {
        return (<div className="flex flex-row space-x-4">
            <span className="flex text-purple-500"><span className="text-gray-500 text-sm">On &nbsp;</span> {moment(leave?.from).format('Do MMM Y')}</span>
        </div>)
    }
    return (
        <div className="flex flex-row space-x-2 items-center bg-purple-100 px-2 py-1 rounded-lg justify-center">
            <span className="flex text-purple-500 items-center">{moment(leave?.from).format('Do MMM Y')}</span>
            <span>
                <svg version="1.1" viewBox="0 0 24 24" className="stroke-current h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" >
                    <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                        <path d="M19,12h-14"></path>
                        <path d="M14,17l5,-5"></path>
                        <path d="M14,7l5,5"></path>
                    </g>
                </svg>
            </span>
            <span className="flex text-purple-500 items-center">{moment(leave?.until).format('Do MMM Y')}</span>
        </div>
    )
}

export default LeaveDaysLabel;