import React from 'react';

const Card = (props) => {
    return (
        <div className={`${props.className} bg-white p-4 rounded shadow-sm transition-all ease-in-out duration-200`}>
            {props.children}
        </div>
    )
}

export default Card;