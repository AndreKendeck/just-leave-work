import React from 'react';
import { Link } from 'react-router-dom';


const UserBadge = ({ user, imageSize }) => {

    return (
        <Link to={`/user/${user?.id}`} className="flex flex-row space-x-2 items-center w-full justify-center hover:bg-gray-200 rounded p-2">
            <img className={`h-${imageSize ? imageSize : '6'} w-${imageSize ? imageSize : '6'} rounded-full`}
                src={user?.avatarUrl} alt={user?.name} />
            <span className="text-gray-600 text-sm">{user?.name}</span>
        </Link>
    )

}

export default UserBadge;