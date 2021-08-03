import React from 'react';

const UserStatusBadge = ({ user }) => {
    if (user?.isBanned) {
        return <div className="bg-red-500 bg-opacity-25 text-red-500 text-xs px-2 rounded-full py-1">Blocked</div>
    }
    return null;
}

export default UserStatusBadge;