import React from 'react';

const Heading = (props) => {
    return (
        <div className={`text-2xl font-bold text-gray-800 text-center items-center`}>
            {props.children}
        </div>
    )
}

export default Heading;