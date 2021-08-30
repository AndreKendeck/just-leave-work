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
import TextArea from '../../Form/Textarea';
import { Link } from 'react-router-dom';
import { clearCommentForm, updateCommentForm } from '../../../actions/forms/comment';
import { DateRange } from 'react-date-range';
import { setUser } from '../../../actions/user';
import { setErrorMessage, setMessage } from '../../../actions/messages';



const ViewLeavePage = (props) => {

    const { id } = useParams();
    const [leave, setLeave] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

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
                const { message } = success.data;
                props.setMessage(message);
                let updatedCommentList = leave.comments.filter((comment) => {
                    return comment.id != id;
                });
                setLeave({ ...leave, comments: updatedCommentList });
            })
            .catch(failed => {
                const { status } = failed.response;
                if (status == 422) {
                    const { errors } = failed.response.data;
                    const { commentForm } = props;
                    props.updateCommentForm({ ...commentForm, errors });
                } else {
                    const { message } = failed.response.data;
                    props.setErrorMessage(message);
                }
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
                props.setMessage(message);
                setLeave(leave);
                const { user } = this.props;

                /**
                 * Update application state if its the same user
                 */
                if (user.id == leave.user.id) {
                    let balance = user.leaveBalance - leave.numberOfDaysOff;
                    let leaveTaken = user.leaveTaken + leave.numberOfDaysOff;
                    this.props.setUser({ ...user, leaveBalance: balance, leaveTaken });
                }

            }).catch(failedResponse => {
                setLoading(false);
                const { message } = failedResponse.response.data;
                props.setErrorMessage(message);
            });
    }


    const onLeaveDeny = () => {
        setLoading(false);
        api.post(`/leaves/deny/${id}`)
            .then(successResponse => {
                setLoading(false);
                const { message, leave } = successResponse.data;
                props.setMessage(message);
                setLeave(leave);
            }).catch(failedResponse => {
                setLoading(false);
                const { message } = failedResponse.response.data;
                props.setErrorMessage(message);
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
                    props.setErrorMessage(message);
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

                    <div className="self-end md:w-1/3">
                        <div className="flex flex-row space-x-1 items-center p-2 self-end justify-end">
                            <span className="text-gray-700">
                                {leave.halfDay ? <div className="bg-gray-700 text-white px-2 py-1 rounded-full text-xs">Half Day</div> : null}
                            </span>
                        </div>
                    </div>
                </div>
                <div className="flex flex-col space-y-2 md:space-y-0 md:flex-row">
                    <DateRange showDateDisplay={false}
                        direction="vertical"
                        editableDateInputs={false}
                        ranges={[{ startDate: new Date(leave.from), endDate: new Date(leave.until), key: 'selection' }]}
                        onChange={(e) => { }}
                        rangeColors={['#9f7aea']}
                        scroll={true}
                        showMonthArrow={false}
                        showSelectionPreview={true} />

                    <div className="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-2  md:items-center w-full">
                        <div>
                            <UserBadge user={leave?.user} imageSize={8} />
                        </div>
                        <div className="text-center">
                            <LeaveDaysLabel leave={leave} />
                        </div>
                        <div>
                            <LeaveStatusBadge leave={leave} />
                        </div>
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
                <TextArea label="Add a comment" name="comment" errors={props.commentForm.errors?.comment}
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


export default connect(mapStateToProps, { updateCommentForm, clearCommentForm, setUser, setMessage, setErrorMessage })(ViewLeavePage);