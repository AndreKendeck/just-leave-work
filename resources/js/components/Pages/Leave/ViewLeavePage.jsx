import React, { useEffect } from 'react';
import { useParams } from 'react-router';


const ViewLeavePage = () => {

    const { id } = useParams();

    useEffect(() => {
        console.log('You are viewing this leave ', id);
    }, []);

    return (
        <div></div>
    )

}

export default ViewLeavePage;