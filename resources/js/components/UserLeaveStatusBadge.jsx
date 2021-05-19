import React from 'react';

const UserLeaveStatusBadge = ({ user }) => {

    if (user?.isOnLeave) {
        return <span className="text-xs bg-yellow-300 rounded-lg text-yellow-600 px-2 flex items-center bg-opacity-25 py-1">On Leave</span>;
    }
    return <span className="text-xs bg-green-300 rounded-lg text-green-600 px-2 flex items-center bg-opacity-25 py-1">At Work</span>;
}

export default UserLeaveStatusBadge; 