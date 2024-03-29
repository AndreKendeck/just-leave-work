import React from 'react';

const Heading = (props) => {
    return (
        <div className={`text-lg md:text-2xl font-bold text-gray-800 text-center items-center ${props.className}`}>
            {props.children}
        </div>
    )
}

export default Heading;