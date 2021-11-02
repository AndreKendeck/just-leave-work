import React from 'react';
import { Link } from 'react-router-dom';
import Card from './Card';
import LeaveDaysLabel from './LeaveDaysLabel';
import LeaveStatusBadge from './LeaveStatusBadge';
import UserBadge from './UserBadge';

const LeaveCard = ({ leave }) => {
    return (
        <Link to={`/leave/view/${leave.id}`} className="md:hidden">
            <Card>
                <div className="flex flex-col space-y-3 items-center w-full">
                    <div className="flex flex-row justify-between w-full items-center">
                        <UserBadge user={leave?.user} />
                        <div className="w-full text-sm text-purple-500 text-right">
                            {leave?.reason.name}
                        </div>
                    </div>
                    <div className="flex flex-col justify-between w-full space-y-4">
                        <div className="w-full flex items-center flex-row justify-between">
                            <div><LeaveDaysLabel leave={leave} /></div>
                        </div>
                        <div className="w-full flex flex-row items-center space-x-2 justify-between">
                            <span className="text-xs text-gray-500">{leave.numberOfDaysOff} Days</span>
                            {leave?.lastSentAt ? (<span className="px-2 py-1 bg-blue-300 bg-opacity-75 text-blue-600 text-xs rounded-full">Email last sent on {moment(leave.lastSentAt).format('ll')}</span>) : (
                                <span className="px-2 py-1 bg-red-300 bg-opacity-75 text-red-600 text-xs rounded-full">Leave not emailed</span>
                            )}
                        </div>
                        <div className="w-full">
                            <LeaveStatusBadge leave={leave} />
                        </div>
                    </div>
                </div>
            </Card>
        </Link>
    )
}

export default LeaveCard;
