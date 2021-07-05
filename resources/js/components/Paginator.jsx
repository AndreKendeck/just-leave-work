import React from 'react';

const Paginator = ({ onPreviousPage, onNextPage, onFirstPage, onLastPage, numberOfPages, activePage, onPageSelect }) => {

    const renderPageButtons = (numberOfPages) => {
        let result = [];
        for (let i = 0; i < numberOfPages; i++) {
            const isActivePage = ((i + 1) == activePage);
            result = [...result, (
                <button disabled={isActivePage} key={i} onClick={(e) => onPageSelect((i + 1))} className={`hidden md:inline-block border-2 bg-white focus:outline-none hover:shadow-sm rounded-lg px-4 ${isActivePage ? null : 'transform hover:-translate-y-1'} `} >
                    <span className={`text-sm w-full ${isActivePage ? 'text-purple-500' : 'text-gray-800'} `}>{i + 1}</span>
                </button>
            )];
        }
        return result;
    }

    const renderBackButton = () => {
        if (onFirstPage) {
            return (
                <button disabled={true} className="bg-gray-300 focus:outline-none rounded-lg p-2 cursor-not-allowed">
                    <svg version="1.1" className="stroke-current h-6 w-6 text-gray-500" viewBox="0 0 24 24" >
                        <g fill="none">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4.01 11.98h14.99"></path>
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.013 5.988l-6.011 6.012 6.011 6.012"></path>
                        </g>
                    </svg>
                </button>
            )
        }
        return (
            <button onClick={(e) => onPreviousPage((activePage - 1))} className="bg-white focus:outline-none hover:shadow-sm rounded-lg p-2 transform hover:-translate-y-1">
                <svg version="1.1" className="stroke-current h-6 w-6 text-gray-800" viewBox="0 0 24 24" >
                    <g fill="none">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4.01 11.98h14.99"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.013 5.988l-6.011 6.012 6.011 6.012"></path>
                    </g>
                </svg>
            </button>
        )
    }

    const renderNextButton = () => {
        if (onLastPage || (numberOfPages === 1)) {
            return (
                <button disabled={true} className="bg-gray-300 focus:outline-none rounded-lg p-2 cursor-not-allowed">
                    <svg version="1.1" className="stroke-current h-6 w-6 text-gray-500" viewBox="0 0 24 24" >
                        <g strokeLinecap="round" strokeWidth="1.5" fill="none" strokeLinejoin="round">
                            <path d="M19,12h-14"></path>
                            <path d="M14,17l5,-5"></path>
                            <path d="M14,7l5,5"></path>
                        </g>
                    </svg>
                </button>
            )
        }

        return (
            <button onClick={(e) => onNextPage(activePage + 1)} className="bg-white focus:outline-none hover:shadow-sm rounded-lg p-2 transform hover:-translate-y-1">
                <svg version="1.1" className="stroke-current h-6 w-6 text-gray-800" viewBox="0 0 24 24" >
                    <g strokeLinecap="round" strokeWidth="1.5" fill="none" strokeLinejoin="round">
                        <path d="M19,12h-14"></path>
                        <path d="M14,17l5,-5"></path>
                        <path d="M14,7l5,5"></path>
                    </g>
                </svg>
            </button>
        )
    }

    const renderMobileCurrentPage = (currentPage, numberOfPages) => {
        return (
            <div className="border md:hidden bg-white rounded flex justify-center space-x-2 p-2 w-1/2 items-center">
                <span className="text-gray-600">{currentPage}</span>
                <span className="text-gray-600">of</span>
                <span className="text-gray-600">{numberOfPages}</span>
            </div>
        )
    }

    return (
        <div className="w-full p-2 flex flex-row space-x-2 justify-center">
            {renderBackButton()}
            {renderPageButtons(numberOfPages)}
            {renderMobileCurrentPage(activePage, numberOfPages)}
            {renderNextButton()}
        </div>
    )
}

export default Paginator;
