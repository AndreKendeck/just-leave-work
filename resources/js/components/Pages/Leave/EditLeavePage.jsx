import moment from 'moment';
import React, { useEffect, useState } from 'react';
import Loader from 'react-loader-spinner';
import { useParams } from 'react-router';
import { Link } from 'react-router-dom';
import api from '../../../api';
import Button from '../../Button';
import Card from '../../Card';
import Heading from '../../Heading';
import LeaveDaysLabel from '../../LeaveDaysLabel';
import LeaveStatusBadge from '../../LeaveStatusBadge';
import Page from '../../Page';
import UserBadge from '../../UserBadge';
import { connect } from 'react-redux';
import { setErrorMessage, setMessage } from '../../../actions/messages';

const EditLeavePage = (props) => {
    const { user } = props;
    const { id } = useParams();
    const [leave, setLeave] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        setTimeout(() => {
            api.get(`/leaves/${id}`)
                .then(successResponse => {
                    setLoading(false);
                    const { data } = successResponse;
                    setLeave(data);
                }).catch(failedResponse => {
                    setLoading(false);
                    const { message } = failedResponse.response.data;
                    props.setErrorMessage(message);
                });

        }, 1000);
    }, []);

    const onDelete = () => {
        setLoading(true);
        api.delete(`/leaves/${id}`)
            .then(success => {
                setLoading(false);
                const { message } = success.data;
                props.setMessage(message);
                setTimeout(() => {
                    window.location = '/leaves';
                }, 1500);
            }).catch(failed => {
                setLoading(false);
                const { message } = failed.response.data;
                props.setErrorMessage(message);
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


    function renderBackButton() {
        if (user?.isAdmin) {
            return (
                <Link to="/leaves/" className="p-2 text-gray-600 bg-gray-300 hover:bg-gray-200 rounded flex items-center space-x-1 w-full justify-center">
                    <svg version="1.1" className="stroke-current h-6 w-6 text-gray-500" viewBox="0 0 24 24" >
                        <g fill="none">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4.01 11.98h14.99"></path>
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.013 5.988l-6.011 6.012 6.011 6.012"></path>
                        </g>
                    </svg>
                    <span className="text-sm text-gray-600">Back to leave page</span>
                </Link>
            )
        }
    }

    return (
        <Page className="flex flex-col justify-center space-y-2">
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                {renderBackButton()}
                <div className="flex flex-col md:flex-row space-y-2 md:space-y-0 justify-between items-center">
                    <Heading>{leave?.reason.name}</Heading>
                    <div className="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 items-center justify-between">
                        <div>
                            <LeaveDaysLabel leave={leave} />
                        </div>
                        <div>
                            <LeaveStatusBadge leave={leave} />
                        </div>
                        <div>
                            <div className="flex flex-row space-x-1 items-center p-2 self-end justify-end">
                                <span>
                                    <svg viewBox="0 0 24 24" className="stroke-current h-6 w-6 text-gray-700" xmlns="http://www.w3.org/2000/svg" >
                                        <defs><path d="M16.5 3l0 3" id="b" /><path d="M7.5 3l0 3" id="a" /></defs>
                                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                                            <use xlinkHref="#a" /><use /><use xlinkHref="#a" /><use />
                                            <path d="M10 21H6l-.01-.001c-1.66-.01-3-1.35-3-3 0 0 0-.001 0-.001V7.49l0 0c-.01-1.66 1.34-3.01 2.99-3.01h12l-.01 0c1.65-.01 3 1.34 3 3v2.5" />
                                            <path d="M16.5 12a4.5 4.5 0 1 0 0 9 4.5 4.5 0 1 0 0-9Z" /><path d="M16.199 14.51l0 2.28 1.89 0" />
                                        </g>
                                    </svg>
                                </span>
                                <span className="text-gray-700">
                                    {leave?.halfDay ? <div className="bg-gray-700 text-white px-2 py-1 rounded-full text-xs">Half Day</div> : leave?.numberOfDaysOff + 'Day(s)'}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="flex flex-row space-x-2 items-center">
                    <div className="w-full md:w-1/2">
                        <UserBadge user={leave?.user} imageSize={8} />
                    </div>
                    <div className="text-gray-600 text-sm w-full text-right">{moment(leave?.createdAt).fromNow()}</div>
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

const mapStateToProps = (state) => {
    const { user } = state;
    return {
        user
    };
}
export default connect(mapStateToProps, { setMessage, setErrorMessage })(EditLeavePage);