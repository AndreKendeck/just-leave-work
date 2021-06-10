import React from 'react';
import { Link } from 'react-router-dom';


const ViewButtonLink = ({ url }) => {
    return <Link to={url} className="bg-gray-300 rounded p-1 focus:outline-none hover:bg-gray-200">
        <svg version="1.1" className="stroke-current h-6 w-6 text-gray-600" viewBox="0 0 24 24">
            <g strokeLinecap="round" strokeWidth="1.5" fill="none" strokeLinejoin="round">
                <path d="M14.122 9.88c1.171 1.171 1.171 3.072 0 4.245 -1.171 1.171-3.072 1.171-4.245 0 -1.171-1.171-1.171-3.072 0-4.245 1.173-1.173 3.073-1.173 4.245 1.77636e-15"></path>
                <path d="M3 12c0-.659.152-1.311.446-1.912v0c1.515-3.097 4.863-5.088 8.554-5.088 3.691 0 7.039 1.991 8.554 5.088v0c.294.601.446 1.253.446 1.912 0 .659-.152 1.311-.446 1.912v0c-1.515 3.097-4.863 5.088-8.554 5.088 -3.691 0-7.039-1.991-8.554-5.088v0c-.294-.601-.446-1.253-.446-1.912Z">
                </path>
            </g>
        </svg>
    </Link>
}

export default ViewButtonLink;