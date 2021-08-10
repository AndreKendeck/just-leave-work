import React from 'react';

const UserRoleBadge = ({ user }) => {
    if (user?.isBanned) {
        return null;
    }
    if (user?.isAdmin) {
        return <div className="bg-purple-500 bg-opacity-25 text-purple-500 text-xs px-2 rounded-full py-1">Admin</div>
    }
    return null;
}

export default UserRoleBadge;