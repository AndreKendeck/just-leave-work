import moment from 'moment';
import React from 'react';


const LeaveDaysLabel = ({ leave }) => {
    if (leave?.isForOneDay) {
        return (<div className="flex flex-row space-x-4">
            <span className="flex text-sm text-gray-800"><span className="text-gray-500 text-sm">On &nbsp;</span> {moment(leave?.from).format('ddd Do MMM')}</span>
        </div>)
    }
    return (
        <div className="flex flex-row space-x-4">
            <span className="flex text-sm text-gray-800"><span className="text-gray-500 text-sm">On:&nbsp;</span> {moment(leave?.from).format('ddd Do MMM')}</span>
            <span className="flex text-sm text-gray-800"><span className="text-gray-500 text-sm">Until:&nbsp;</span> {moment(leave?.until).format('ddd Do MMM')}</span>
        </div>
    )
}

export default LeaveDaysLabel;