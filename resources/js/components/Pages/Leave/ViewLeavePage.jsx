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
import Comment from '../../Comment';
import Button from '../../Button';
import { collect } from 'collect.js';
import InfoMessage from '../../InfoMessage';
import TextArea from '../../Form/Textarea';
import { Link } from 'react-router-dom';
import { clearCommentForm, updateCommentForm } from '../../../actions/forms/comment';
import { Calendar, DateRange, DateRangePicker } from 'react-date-range';
import moment from 'moment';



const ViewLeavePage = (props) => {

    const { id } = useParams();
    const [leave, setLeave] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [message, setMessage] = useState(null);

    const onCommentAdd = () => {
        const { commentForm } = props;
        props.updateCommentForm({ ...commentForm, loading: true });
        const { value } = props.commentForm;
        api.post('/comments', { text: value, leave_id: id })
            .then(success => {
                const { comment: newComment } = success.data;
                props.clearCommentForm();
                setLeave({ ...leave, comments: [newComment, ...leave.comments] });
            }).catch(failed => {
                const { errors } = failed.response.data;
                props.updateCommentForm({ ...commentForm, loading: false, errors: collect(errors).flatten() });
            });
    }

    /**
     * Render the leave comments
     * @return {JSX}
     */
    const renderComments = (comments = []) => {
        return comments.map((comment, index) => {
            return <Comment comment={comment} key={index} onDelete={(id) => onCommentDelete(id)} />
        });
    }


    const onCommentDelete = (id) => {
        api.delete(`/comments/${id}`)
            .then(success => {
                setMessage(success.data.message);
                let updatedCommentList = leave.comments.filter((comment) => {
                    return comment.id != id;
                });
                setLeave({ ...leave, comments: updatedCommentList });
            })
            .catch(failed => {
                setError(failed.response.data.message);
            });
    }

    const userIsAdmin = () => {
        return props.user?.isAdmin;
    }

    const onLeaveApprove = () => {
        setLoading(true);
        api.post(`/leaves/approve/${id}`)
            .then(successResponse => {
                setLoading(false);
                const { message, leave } = successResponse.data;
                setMessage(message);
                setLeave(leave);
            }).catch(failedResponse => {
                setLoading(false);
                const { message } = failedResponse.response.data;
                setError(message);
            });
    }


    const onLeaveDeny = () => {
        setLoading(false);
        api.post(`/leaves/deny/${id}`)
            .then(successResponse => {
                setLoading(false);
                const { message, leave } = successResponse.data;
                setMessage(message);
                setLeave(leave);
            }).catch(failedResponse => {
                setLoading(false);
                const { message } = failedResponse.response.data;
                setError(message);
            });
    }


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
        return (<Page className="flex flex-col justify-center  space-y-2">
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
            </Card>
        </Page>)
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
            <div className="md:w-1/2 w-full self-center">
                {message ? <InfoMessage text={message} onDismiss={(e) => setMessage(null)} /> : null}
            </div>
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                <div className="flex flex-row justify-between items-center space-x-2 w-full">
                    <Heading>{leave?.reason.name}</Heading>
                    <div className="flex flex-row space-x-2 items-center">
                        <div>
                            <Link to="/leaves/" className="p-2 text-gray-600 bg-gray-300 hover:bg-gray-200 rounded flex items-center space-x-1 w-full justify-center">
                                <svg version="1.1" className="stroke-current h-6 w-6 text-gray-600" viewBox="0 0 24 24" >
                                    <g fill="none">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4.01 11.98h14.99"></path>
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.013 5.988l-6.011 6.012 6.011 6.012"></path>
                                    </g>
                                </svg>
                                <span className="text-sm text-gray-600">Back</span>
                            </Link>
                        </div>
                        <div>
                            <Link className="p-2 text-gray-600 bg-gray-300 hover:bg-gray-200 rounded flex items-center space-x-1 w-full justify-center" to={`/leave/edit/${id}`}>
                                <svg id="Layer_3" className="stroke-current h-6 w-6 text-gray-600" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M21,12v4a5,5,0,0,1-5,5H8a5,5,0,0,1-5-5V8A5,5,0,0,1,8,3h4" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                    <path d="M17.37955,3.62025a2.11953,2.11953,0,0,1,2.99908.00268h0a2.12064,2.12064,0,0,1-.00039,2.99981c-.00064-.00064-4.1761,4.17463-5.62,5.61846a1.99163,1.99163,0,0,1-1.167.56861l-1.4778.18251a.99172.99172,0,0,1-1.10331-1.12443l.21863-1.531a1.9814,1.9814,0,0,1,.56085-1.12662C12.80012,8.19931,15.26954,5.72978,17.37955,3.62025Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                </svg>
                                <span className="text-sm text-gray-600">edit</span>
                            </Link>
                        </div>
                    </div>
                </div>
                <div className="flex flex-col md:flex-row space-y-2 md:space-y-0 justify-between md:items-center">
                    <div className="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-2  md:items-center w-full">
                        <div className="text-center">
                            <LeaveDaysLabel leave={leave} />
                        </div>
                        <div>
                            <LeaveStatusBadge leave={leave} />
                        </div>
                    </div>
                </div>
                <div className="w-full">
                    <DateRange showDateDisplay={false}
                        className="w-full shadow rounded"
                        direction="vertical"
                        editableDateInputs={false}
                        ranges={[{ startDate: new Date(leave.from), endDate: new Date(leave.until), key: 'selection' }]}
                        onChange={(e) => { }}
                        rangeColors={['#9f7aea']}
                        scroll={true}
                        showMonthArrow={false}
                        showSelectionPreview={true} />
                </div>
                <div className="w-1/2 md:w-1/6">
                    <div className="flex flex-row space-x-1 items-center p-2 ">
                        <span>
                            <svg viewBox="0 0 24 24" className="stroke-current h-6 w-6 text-gray-700" xmlns="http://www.w3.org/2000/svg" >
                                <defs><path d="M16.5 3l0 3" id="b" /><path d="M7.5 3l0 3" id="a" /></defs>
                                <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                                    <use xlinkHref="#a" /><use /><use xlinkHref="#a" /><use />
                                    <path d="M10 21H6l-.01-.001c-1.66-.01-3-1.35-3-3 0 0 0-.001 0-.001V7.49l0 0c-.01-1.66 1.34-3.01 2.99-3.01h12l-.01 0c1.65-.01 3 1.34 3 3v2.5" />
                                    <path d="M16.5 12a4.5 4.5 0 1 0 0 9 4.5 4.5 0 1 0 0-9Z" /><path d="M16.199 14.51l0 2.28 1.89 0" /></g>
                            </svg>
                        </span>
                        <span className="text-gray-700">{leave.numberOfDaysOff}{leave.numberOfDaysOff > 1 ? ' Days' : ' Day'}</span>
                    </div>
                </div>
                <div className="flex flex-row space-x-2 items-center">
                    <div className="w-full md:w-1/2 self-start">
                        <UserBadge user={leave?.user} imageSize={8} />
                    </div>
                </div>
                <div className="text-gray-700">
                    {leave?.description}
                </div>
                {/* There was no better way to write this unless I store  */}
                <div className="flex flex-row space-x-2">
                    {userIsAdmin() && leave?.pending ? <React.Fragment>
                        <Button onClick={(e) => onLeaveApprove()}>Approve</Button>
                        <Button onClick={(e) => onLeaveDeny()} type="danger">Deny</Button>
                    </React.Fragment> : null}
                </div>
                {error ? <ErrorMessage onDismiss={(e) => setError(null)} /> : null}
            </Card>
            <div className="flex flex-col space-y-2 overflow-auto" style={{ maxHeight: '300px' }}>
                {renderComments(leave.comments)}
            </div>
            <Card className="flex flex-col w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                <TextArea label="Add a comment" name="comment" errors={props.commentForm.errors}
                    onChange={(e) => { e.persist(); props.updateCommentForm({ ...props.commentForm, value: e.target.value }) }}>
                    {props.commentForm.value}
                </TextArea>

                {props.commentForm.loading ? (<Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />) :
                    <Button onClick={(e) => onCommentAdd()}>Add Comment</Button>}
            </Card>
        </Page >
    )

}

const mapStateToProps = (state) => {
    const { user, commentForm } = state;
    return {
        user,
        commentForm
    };
}


export default connect(mapStateToProps, { updateCommentForm, clearCommentForm })(ViewLeavePage);