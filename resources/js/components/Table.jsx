import React from 'react';

const Table = ({ headings = [], children }) => {
    const renderHeadings = () => {
        return headings?.map((heading, key) => {
            if (key === (headings.length - 1)) {
                return <th key={key} className="text-gray-700 text-sm font-bold text-center text-gray-600 rounded-r">{heading}</th>
            }
            if (key === 0) {
                return <th key={key} className="text-gray-700 text-sm font-bold text-center text-gray-600 rounded-l">{heading}</th>
            }
            return <th key={key} className="text-gray-700 text-sm font-bold text-center text-gray-600 ">{heading}</th>
        });
    }
    return (
        <table className="hidden md:table table table-responsive table-borderless">
            <thead>
                <tr>
                    {renderHeadings()}
                </tr>
            </thead>
            <tbody>
                {children}
            </tbody>
        </table>
    )
}
export default Table;