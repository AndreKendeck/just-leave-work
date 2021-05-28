import React from 'react';

const Table = ({ headings = [], children }) => {
    const renderHeadings = () => {
        return headings?.map((heading, key) => {
            return <th key={key} className="font-bold text-center">{heading}</th>
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