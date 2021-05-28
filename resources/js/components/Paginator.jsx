import React from 'react';

const Paginator = ({ onPreviousPage, onNextPage, onFirstPage, onLastPage, numberOfPages , activePage }) => {

    const renderBackButton = () => {
        if (onFirstPage) {
            return (
                <button disabled={true} className="bg-gray-300 focus:outline-none rounded-lg p-2 cursor-not-allowed">
                    <svg version="1.1" className="stroke-current h-8 w-8 text-gray-500" viewBox="0 0 24 24" >
                        <g fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.01 11.98h14.99"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.013 5.988l-6.011 6.012 6.011 6.012"></path>
                        </g>
                    </svg>
                </button>
            )
        }
        return (
            <button className="bg-white focus:outline-none hover:shadow-sm rounded-lg p-2 transform hover:-translate-y-1">
                <svg version="1.1" className="stroke-current h-8 w-8 text-gray-800" viewBox="0 0 24 24" >
                    <g fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.01 11.98h14.99"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.013 5.988l-6.011 6.012 6.011 6.012"></path>
                    </g>
                </svg>
            </button>
        )
    }
    return (
        <div className="w-full p-3 flex flex-row space-x-2">
            {renderBackButton()}
            <button className="bg-white focus:outline-none hover:shadow-sm rounded-lg px-4 transform hover:-translate-y-1" >
                <span className="text-lg w-full text-purple-500">3</span>
            </button>
        </div>
    )
}

export default Paginator;
