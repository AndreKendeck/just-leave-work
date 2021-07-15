import moment from 'moment';
import React, { useEffect, useState } from 'react';
import Loader from 'react-loader-spinner';
import { useParams } from 'react-router';
import { Link } from 'react-router-dom';
import api from '../../../api';
import Button from '../../Button';
import Card from '../../Card';
import ErrorMessage from '../../ErrorMessage';
import Heading from '../../Heading';
import InfoMessage from '../../InfoMessage';
import LeaveDaysLabel from '../../LeaveDaysLabel';
import LeaveStatusBadge from '../../LeaveStatusBadge';
import Page from '../../Page';
import UserBadge from '../../UserBadge';

const EditLeavePage = () => {
    const { id } = useParams();
    const [leave, setLeave] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [message, setMessage] = useState(null);

    useEffect(() => {
        setTimeout(() => {
            api.get(`/leaves/${id}`)
                .then(successResponse => {
                    setLoading(false);
                    setLeave(successResponse.data);
                }).catch(failedResponse => {
                    setLoading(false);
                    const { message } = failedResponse.response.data;
                    setError(message);
                });

        }, 1500);
    }, []);

    const onDelete = () => {
        setLoading(true);
        api.delete(`/leaves/${id}`)
            .then(success => {
                setLoading(false);
                setMessage(success.data.message);
                setTimeout(() => {
                    window.location = '/leaves';
                }, 1500);
            }).catch(failed => {
                setLoading(false);
                setError(failed.response.data.message);
            });
    }

    if (loading) {
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
                </Card>
            </Page>
        )
    }

    if (error || !leave) {
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <ErrorMessage text={error ? error : 'Could not fetch leave'} />
                </Card>
            </Page>
        );
    }

    return (
        <Page className="flex flex-col justify-center justify-center space-y-2">
            {message ? <InfoMessage text={message} onDismiss={(e) => setMessage(null)} /> : null}
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                <Link to="/leaves/" className="p-2 text-gray-600 bg-gray-300 hover:bg-gray-200 rounded flex items-center space-x-1 w-full justify-center">
                    <svg version="1.1" className="stroke-current h-6 w-6 text-gray-500" viewBox="0 0 24 24" >
                        <g fill="none">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4.01 11.98h14.99"></path>
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.013 5.988l-6.011 6.012 6.011 6.012"></path>
                        </g>
                    </svg>
                    <span className="text-sm text-gray-600">Back to leave page</span>
                </Link>
                <div className="flex flex-col md:flex-row space-y-2 md:space-y-0 justify-between items-center">
                    <Heading>{leave?.reason.name}</Heading>
                    <div className="flex flex-row space-x-2 items-center justify-between">
                        <div>
                            <LeaveDaysLabel leave={leave} />
                        </div>
                        <div>
                            <LeaveStatusBadge leave={leave} />
                        </div>
                    </div>
                </div>
                <div className="flex flex-row space-x-2 items-center">
                    <div className="w-full md:w-1/2">
                        <UserBadge user={leave?.user} imageSize={8} />
                    </div>
                    <div className="text-gray-600 text-sm w-full text-right">{moment(leave?.createdAt).fromNow()}</div>
                </div>
                <div className="text-gray-500">
                    {leave?.description}
                </div>
                {leave?.pending ? (
                    <div className="flex flex-row space-x-2 items-center justify-between w-full">
                        <Button type="danger" onClick={() => onDelete()}>Delete</Button>
                    </div>
                ) : null}
            </Card>
        </Page>
    );
}

export default EditLeavePage;