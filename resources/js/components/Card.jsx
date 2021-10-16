import React from 'react';

const Card = ({ className, children }) => {
    return (
        <div className={`${className} flex flex-col bg-white p-4 rounded transition-all shadow-lg ease-in-out duration-200`}>
            {children}
        </div>
    )
}

export default Card;