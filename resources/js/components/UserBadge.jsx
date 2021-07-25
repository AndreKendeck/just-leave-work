import React from 'react';



const UserBadge = ({ user, imageSize, }) => {

    return (
        <div className="flex flex-row space-x-2 items-center w-full">
            <img className={`h-${imageSize ? imageSize : '6'} w-${imageSize ? imageSize : '6'} rounded-full`}
                src={user?.avatarUrl} alt={user?.name} />
            <span className="text-gray-600 text-sm">{user?.name}</span>
        </div>
    )

}

export default UserBadge;