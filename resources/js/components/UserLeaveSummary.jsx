import moment from 'moment';
import React from 'react';
import Card from './Card';
import Heading from './Heading';


const UserLeaveSummary = ({ user = null }) => {
    return (
        <React.Fragment>
            <Card className="pointer-cursor w-full border-2 border-purple-800 bg-purple-500 bg-opacity-50 transform hover:-translate-y-1 hover:shadow-2xl">
                <Heading>
                    <div className="flex flex-col space-y-2">
                        <span className="text-2xl text-purple-800">{user?.leaveBalance}</span>
                        <span className="text-purple-800 text-base">Leave Balance</span>
                    </div>
                </Heading>
            </Card>
            <Card className="pointer-cursor w-full bg-gray-600 border-2 border-gray-800 transform hover:-translate-y-1 hover:shadow-2xl ">
                <Heading>
                    <div className="flex flex-col space-y-2">
                        <span className="text-2xl text-white">{user?.leaveTaken}</span>
                        <span className="text-white text-base">Leave Taken</span>
                    </div>
                </Heading>
            </Card>
            <Card className="pointer-cursor w-full  border-gray-800 border-2 transform hover:-translate-y-1 hover:shadow-2xl ">
                <Heading>
                    <div className="flex flex-col space-y-2">
                        <span className="text-2xl text-gray-800">{user?.lastLeaveAt ? moment(user?.lastLeaveAt).format('ddd Do MMM') : '-'}</span>
                        <span className="text-gray-800 text-base">Last Leave Taken</span>
                    </div>
                </Heading>
            </Card>
        </React.Fragment>
    )
}

export default UserLeaveSummary;