import React from 'react';

const Card = (props) => {
    return (
        <div className={`${props.className} flex flex-col bg-white p-4 rounded-lg border-2 transition-all ease-in-out duration-200`}>
            {props.children}
        </div>
    )
}

export default Card;