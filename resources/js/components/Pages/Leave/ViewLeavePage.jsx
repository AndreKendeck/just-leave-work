import React, { useEffect, useState } from 'react';
import { connect } from 'react-redux';
import { useParams } from 'react-router';
import api from '../../../api';
import ErrorMessage from '../../ErrorMessage';
import Page from '../../Page';
import Loader from 'react-loader-spinner';
import Card from '../../Card';
import Heading from '../../Heading';
import LeaveDaysLabel from '../../LeaveDaysLabel';
import LeaveStatusBadge from '../../LeaveStatusBadge';
import UserBadge from '../../UserBadge';
import moment from 'moment';
import Comment from '../../Comment';


const renderComments = (comments = []) => {
    return comments.map((comment, index) => {
        return <Comment comment={comment} key={index} />
    })
}

const ViewLeavePage = () => {

    const { id } = useParams();
    const [leave, setLeave] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

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

    if (loading) {
        return (<Page className="flex flex-col justify-center justify-center space-y-2">
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
            </Card>
        </Page>)
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
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
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
            </Card>
            <Comment />
        </Page>
    )

}

const mapStateToProps = (state) => {
    return state;
}

export default connect(mapStateToProps, null)(ViewLeavePage);