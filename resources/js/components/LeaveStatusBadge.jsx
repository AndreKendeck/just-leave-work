import React from 'react';

const LeaveStatusBadge = ({ leave }) => {
    if (leave.approved) {
        return (
            <span className="text-xs bg-green-300 rounded-lg text-green-600 px-2 flex space-x-1 items-center bg-opacity-25 py-1 justify-center">
                <span>
                    <svg id="Layer_3" data-name="Layer 3" className="stroke-current text-green-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <rect x="3" y="4.5" width="18" height="16.5" rx="3" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" fill="none" />
                        <line x1="7.5" y1="3" x2="7.5" y2="6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <line x1="16.5" y1="3" x2="16.5" y2="6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <path d="M10.4,11.8,11.60107,13,13.6,11" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <line x1="17" y1="16.98624" x2="7" y2="16.98624" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                    </svg>
                </span>
                <span className="text-sm">Approved</span>
            </span>
        )
    }
    if (leave.denied) {
        return (
            <span className="text-xs bg-red-300 rounded-lg text-red-800 px-2 flex space-x-1 items-center bg-opacity-25 py-1 justify-center">
                <span>
                    <svg id="Layer_3" data-name="Layer 3" className="stroke-current text-red-800 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="7.5" y1="3" x2="7.5" y2="6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <line x1="16.5" y1="3" x2="16.5" y2="6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <rect x="3" y="4.5" width="18" height="16.5" rx="3" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" fill="none" />
                        <line x1="17" y1="17" x2="7" y2="17" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <path d="M13.5,10.5l-3,3" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <path d="M10.5,10.5l3,3" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                    </svg>
                </span>
                <span className="text-sm">Denied</span>
            </span>
        )
    }
    return (
        <span className="text-xs bg-yellow-300 rounded-lg text-yellow-600 px-2 flex space-x-1 items-center bg-opacity-25 py-1 justify-center">
            <span>
                <svg version="1.1" className="text-yellow-600 stroke-current h-4 w-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                    <g fill="none">
                        <line x1="21" x2="3" y1="8" y2="8" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M17.5 13l-1.96701e-07 3.55271e-15c2.48528-1.08635e-07 4.5 2.01472 4.5 4.5 1.08635e-07 2.48528-2.01472 4.5-4.5 4.5 -2.48528 1.08635e-07-4.5-2.01472-4.5-4.5l4.79616e-14 4.8278e-07c-3.75267e-07-2.48528 2.01472-4.5 4.5-4.5 6.09575e-08-8.88178e-15 1.35744e-07-1.95399e-14 1.96701e-07-2.66454e-14"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M14.673 21h-8.673l-1.31134e-07-3.55271e-15c-1.65685-7.24234e-08-3-1.34315-3-3 0 0 0-3.55271e-15 0-3.55271e-15v-12l3.37508e-14 4.52987e-07c-2.50178e-07-1.65685 1.34315-3 3-3h12l-1.31134e-07 2.66454e-15c1.65685-7.24234e-08 3 1.34315 3 3v8.673"></path>
                        <line x1="17.72" x2="17.72" y1="15.29" y2="17.68" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                        <line x1="15.77" x2="17.72" y1="17.68" y2="17.68" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.799 11.5v0c0 .0276142-.0223858.05-.05.05 -.0276142 0-.05-.0223858-.05-.05 0-.0276142.0223858-.05.05-.05"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.749 11.45h-2.18557e-09c.0276142-1.20706e-09.05.0223858.05.05 0 0 0 0 0 0"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.3 11.5v0c0 .0276142-.0223858.05-.05.05 -.0276142 0-.05-.0223858-.05-.05 0-.0276142.0223858-.05.05-.05"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.25 11.45h-2.18557e-09c.0276142-1.20706e-09.05.0223858.05.05 0 0 0 1.77636e-15 0 1.77636e-15"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.799 14.5v0c0 .0276142-.0223858.05-.05.05 -.0276142 0-.05-.0223858-.05-.05 0-.0276142.0223858-.05.05-.05"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.749 14.45h-2.18557e-09c.0276142-1.20706e-09.05.0223858.05.05 0 0 0 0 0 0"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.3 14.5v0c0 .0276142-.0223858.05-.05.05 -.0276142 0-.05-.0223858-.05-.05 0-.0276142.0223858-.05.05-.05"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.25 14.45h-2.18557e-09c.0276142-1.20706e-09.05.0223858.05.05 0 0 0 1.77636e-15 0 1.77636e-15"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M13.799 11.5v0c0 .0276142-.0223858.05-.05.05 -.0276142 0-.05-.0223858-.05-.05 0-.0276142.0223858-.05.05-.05"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M13.749 11.45h-2.18557e-09c.0276142-1.20706e-09.05.0223858.05.05 0 0 0 1.77636e-15 0 1.77636e-15"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.799 17.5v0c0 .0276142-.0223858.05-.05.05 -.0276142 0-.05-.0223858-.05-.05 0-.0276142.0223858-.05.05-.05"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.749 17.45h-2.18557e-09c.0276142-1.20706e-09.05.0223858.05.05 0 0 0 0 0 0"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.3 17.5v0c0 .0276142-.0223858.05-.05.05 -.0276142 0-.05-.0223858-.05-.05 0-.0276142.0223858-.05.05-.05"></path>
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.25 17.45h-2.18557e-09c.0276142-1.20706e-09.05.0223858.05.05 0 0 0 0 0 0"></path>
                    </g></svg>
            </span>
            <span className="text-sm">Pending</span>
        </span>
    )
};

export default LeaveStatusBadge;