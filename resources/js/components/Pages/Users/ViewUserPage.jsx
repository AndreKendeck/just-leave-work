import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router';
import api from '../../../api';
import Card from '../../Card';

const ViewUserPage = (props) => {
    const { id } = useParams();
    const [user, setUser] = useState({});
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        api.get(`/users/${id}`)
            .then(success => {
                
            }).catch(failed => {

            });
    }, []);
    return (
        <Page className="flex flex-col justify-center space-y-2">
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">

            </Card>
        </Page>
    )
}

export default ViewUserPage;