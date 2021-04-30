import React from 'react';

const Page = (props) => {
    return (
        <div className="flex flex-col space-y-4 px-4 w-full h-full">
            <div className="w-full flex flex-col space-y-4 self-center items-center w-full">
                <div className={`w-full ${props.size ? props.size : 'w-10/12'} self-center ${props.className}`}>
                    {props.children}
                </div>
            </div>
        </div>
    )
}

export default Page;