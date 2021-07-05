import React from 'react';
import { Link } from 'react-router-dom';
import Card from './Card';
import Heading from './Heading';
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
                            {leave.reason.name}
                        </div>
                    </div>
                    <div className="flex flex-row justify-between items-center w-full">
                        <LeaveDaysLabel leave={leave} />
                        <LeaveStatusBadge leave={leave} />
                    </div>
                </div>
            </Card>
        </Link>
    )
}

export default LeaveCard;
