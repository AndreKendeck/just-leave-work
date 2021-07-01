import moment from 'moment';
import React from 'react';
import Button from './Button';
import TextArea from './Form/Textarea';
import UserBadge from './UserBadge';
import Loader from 'react-loader-spinner';
import api from '../api';


const Comment = class Comment extends React.Component {

    constructor(props) {
        super(props);
        const { comment } = this.props;
        this.state = {
            comment,
            isSending: false,
            isEditing: false,
            errors: [],
            message: null
        }
    }

    onCommentTextChange(e) {
        e.persist();
        this.setState(state => {
            return {
                ...state,
                comment: {
                    ...comment,
                    text: e.target.value
                }
            }
        });
        console.log(this.state);
    }

    onSave() {
        const { id, text } = this.state.comment;
        this.setState({ isSending: true });
        api.put(`/comments/${id}`, text)
        .then( successResponse => {

        }).then( failedResponse =>)
    }


    renderLoading() {

        return (
            <div className="flex flex-col space-y-2 w-full md:w-3/2 lg:w-1/2 self-center space-y-4 bg-white border-2 border-gray-500 rounded p-3">
                <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
            </div>
        );
    }

    renderEditAndDeleteButton() {
        return (
            <div className="flex flex-row space-x-1">
                <Button type="soft" onClick={() => { this.setState({ isEditing: true }) }}>
                    <svg id="Layer_3" className="stroke-current h-6 w-6 text-gray-600" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M21,12v4a5,5,0,0,1-5,5H8a5,5,0,0,1-5-5V8A5,5,0,0,1,8,3h4" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                        <path d="M17.37955,3.62025a2.11953,2.11953,0,0,1,2.99908.00268h0a2.12064,2.12064,0,0,1-.00039,2.99981c-.00064-.00064-4.1761,4.17463-5.62,5.61846a1.99163,1.99163,0,0,1-1.167.56861l-1.4778.18251a.99172.99172,0,0,1-1.10331-1.12443l.21863-1.531a1.9814,1.9814,0,0,1,.56085-1.12662C12.80012,8.19931,15.26954,5.72978,17.37955,3.62025Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                    </svg>
                </Button>
                <Button type="soft" onClick={this.props.onDelete} >
                    <svg version="1.1" className="stroke-current h-6 w-6 text-gray-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                            <path d="M18 6.53h1"></path>
                            <path d="M9 10.47v6.06"></path>
                            <path d="M12 9.31v8.27"></path>
                            <path d="M15 10.47v6.06"></path>
                            <path d="M15.795 20.472h-7.59c-1.218 0-2.205-.987-2.205-2.205v-11.739h12v11.739c0 1.218-.987 2.205-2.205 2.205Z"></path>
                            <path d="M16 6.528l-.738-2.305c-.133-.414-.518-.695-.952-.695h-4.62c-.435 0-.82.281-.952.695l-.738 2.305"></path>
                            <path d="M5 6.53h1"></path>
                        </g>
                    </svg>
                </Button>
            </div>
        );
    }

    renderSaveAndCancelButton() {
        return (
            <div className="flex flex-row space-x-1">
                <Button type="soft">
                    <svg viewBox="0 0 24 24" className="stroke-current h-6 w-6 text-gray-600" xmlns="http://www.w3.org/2000/svg">
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                            <path d="M19 21H5.1l0-.001c-1.1 0-2-.89-2-1.99l-.11-14 -.01-.01c-.01-1.11.88-2.01 1.98-2.02 0-.01 0-.01.01-.01h11.17l0-.001c.53-.01 1.03.21 1.41.58l2.82 2.82 -.01-.01c.37.37.58.88.58 1.41v11.17l0 0c0 1.1-.9 1.99-2 1.99 -.01 0-.01-.01-.01-.01Z" />
                            <path d="M15.993 3v4l0-.01c-.01.55-.45.99-1 1h-6l-.01-.001c-.56-.01-1-.45-1-1v-4" />
                            <path d="M12 12a2.5 2.5 0 1 0 0 5 2.5 2.5 0 1 0 0-5Z" />
                        </g>
                    </svg>
                </Button>
                <Button type="soft">
                    <svg version="1.1" className="stroke-current h-6 w-6 text-gray-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                            <path d="M18 6.53h1"></path>
                            <path d="M9 10.47v6.06"></path>
                            <path d="M12 9.31v8.27"></path>
                            <path d="M15 10.47v6.06"></path>
                            <path d="M15.795 20.472h-7.59c-1.218 0-2.205-.987-2.205-2.205v-11.739h12v11.739c0 1.218-.987 2.205-2.205 2.205Z"></path>
                            <path d="M16 6.528l-.738-2.305c-.133-.414-.518-.695-.952-.695h-4.62c-.435 0-.82.281-.952.695l-.738 2.305"></path>
                            <path d="M5 6.53h1"></path>
                        </g>
                    </svg>
                </Button>
            </div>
        );
    }

    render() {
        if (this.state.isSending) {
            return this.renderLoading()
        }
        return (
            <div className="flex flex-col space-y-2 w-full md:w-3/2 lg:w-1/2 self-center space-y-4 bg-white border-2 border-gray-500 rounded p-3">
                <div className="flex flex-col space-y-2">
                    <div className="flex flex-row w-full justify-between">
                        <UserBadge user={this.state.comment?.user} imageSize={8} />
                        {!this.state.isEditing ? this.renderEditAndDeleteButton() : null}
                        {this.state.isEditing ? this.renderSaveAndCancelButton() : null}
                    </div>
                    <div className="text-gray-600 text-sm w-full">{moment(this.state.comment?.createdAt).fromNow()}</div>
                </div>
                <div className="text-gray-600 text-base">
                    {this.state.comment?.text}
                </div>
                {this.state.isEditing ? <TextArea onChange={(e) => this.onCommentTextChange(e)}
                    name="comment" value={this.state.comment?.text} label="Comment" /> : null}
            </div>
        );
    }
}

export default Comment;