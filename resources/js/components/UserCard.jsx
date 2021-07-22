import React from 'react';
import Card from './Card';
import UserBadge from './UserBadge';
import UserLeaveStatusBadge from './UserLeaveStatusBadge';
import EditButtonLink from '../components/EditButtonLink';
import ViewButtonLink from '../components/ViewButtonLink';
import moment from 'moment';

const UserCard = ({ user, showLinks = false }) => {
    return (
        <Card className="md:hidden space-y-4">
            <div className="flex flex-row justify-between w-full">
                <div className="flex flex-row space-x-2">
                    <div>
                        <UserBadge user={user} />
                    </div>
                    <div>
                        {user?.isAdmin ? (<div className="bg-purple-500 bg-opacity-25 text-purple-500 text-xs px-2 rounded-full py-1">Admin</div>) : null}
                    </div>
                </div>
                <div>
                    <UserLeaveStatusBadge user={user} />
                </div>
            </div>
            <div className="flex flex-col space-y-4 w-full">
                <span className="text-gray-600">Balance : <span className="text-purple-500">{user?.leaveBalance}</span> </span>
                <span className="text-gray-600">Last leave taken: <span className="text-gray-400">{user?.lastLeaveAt ? moment(user?.lastLeaveAt).format('l') : '-'}</span> </span>
            </div>
            {showLinks ? (<div className="flex flex-row space-x-2 items-center self-end">
                <ViewButtonLink url={`/user/${user?.id}`} />
                <EditButtonLink url={`/user/edit/${user?.id}`} />
            </div>) : null}
        </Card>
    );
}

export default UserCard;