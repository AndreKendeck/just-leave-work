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
import Field from '../../Form/Field';
import { collect } from 'collect.js';

const EditLeavePage = () => {
    const { id } = useParams();
    const [leave, setLeave] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [message, setMessage] = useState(null);
    const [isEditing, setIsEditing] = useState(false);

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

    const onDescriptionChange = (e) => {
        e.persist();
        setLeave({ ...leave, description: e.target.value });
    }

    const onSave = () => {
        const { from, until, description, reason: { id: reason } } = leave;
        api.put(`/leaves/${id}`, { from, until, description, reason })
            .then(success => {
                const { message, leave } = success.data;
                setMessage(message);
                setLeave(leave);
                setIsEditing(false);
            }).catch(failed => {
                if (failed.response.code == 422) {
                    const { errors } = failed.response.data;
                    setLeave({ ...leave, errors: [collect(errors).flatten().toArray()] });
                } else {
                    const { message } = failed.response.data;
                    setError({ ...leave, errors: [...message] });
                }
            });
    }

    if (loading) {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
                </Card>
            </Page>
        )
    }

    if (error || !leave) {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <ErrorMessage text={error ? error : 'Could not fetch leave'} />
                </Card>
            </Page>
        );
    }

    return (
        <Page className="flex flex-col justify-center space-y-2">
            <div className="w-2/3 self-center">
                {message ? <InfoMessage text={message} onDismiss={(e) => setMessage(null)} /> : null}
                {leave?.errors?.length > 0 ? error.map((err, key) => (<ErrorMessage text={err} key={key} />)) : null}
            </div>
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
                <div className="text-gray-500 w-full" onClick={(e) => setIsEditing(true)}>
                    {leave?.description}
                </div>
                {isEditing ? (
                    <div className="w-full flex flex-row space-x-2 items-center">
                        <div className="w-full">
                            <Field value={leave?.description} label="Description"
                                errors={leave?.errors} onChange={(e) => { onDescriptionChange(e) }} />
                        </div>
                        <div className="mt-6">
                            <Button type="soft" onClick={(e) => onSave()}>
                                <svg viewBox="0 0 24 24" className="stroke-current text-gray-600 h-6 w-6" xmlns="http://www.w3.org/2000/svg">
                                    <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                                        <path d="M19 21H5.1l0-.001c-1.1 0-2-.89-2-1.99l-.11-14 -.01-.01c-.01-1.11.88-2.01 1.98-2.02 0-.01 0-.01.01-.01h11.17l0-.001c.53-.01 1.03.21 1.41.58l2.82 2.82 -.01-.01c.37.37.58.88.58 1.41v11.17l0 0c0 1.1-.9 1.99-2 1.99 -.01 0-.01-.01-.01-.01Z" />
                                        <path d="M15.993 3v4l0-.01c-.01.55-.45.99-1 1h-6l-.01-.001c-.56-.01-1-.45-1-1v-4" />
                                        <path d="M12 12a2.5 2.5 0 1 0 0 5 2.5 2.5 0 1 0 0-5Z" />
                                    </g>
                                </svg>
                            </Button>
                        </div>
                    </div>
                ) : null}
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