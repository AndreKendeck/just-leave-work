import moment from 'moment';
import React from 'react';
import Button from './Button';
import TextArea from './Form/Textarea';
import UserBadge from './UserBadge';
import Loader from 'react-loader-spinner';
import api from '../api';


const Comment = class Comment extends React.Component {

    state = {
        errors: [],
        message: null,
        text: this.props.comment?.text
    }

    renderDeleteButton() {
        return (
            <div className="flex flex-row space-x-1">
                <button className="items-center focus:outline-none bg-gray-300 text-gray-800 p-1 w-full font-bold rounded text-center hover:bg-gray-200 tranform" onClick={(e) => this.props.onDelete(this.props.comment?.id)}>
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
                </button>
            </div>
        );
    }

    render() {
        return (
            <div className="flex flex-col space-y-2 w-full md:w-3/2 lg:w-1/2 self-center space-y-4 bg-white border-2 border-gray-500 rounded p-3">
                <div className="flex flex-col space-y-2">
                    <div className="flex flex-row w-full justify-between">
                        <div className="w-1/4">
                            <UserBadge user={this.props.comment?.user} imageSize={8} />
                        </div>
                        {this.props.comment?.canDelete ? this.renderDeleteButton() : null}
                    </div>
                    <div className="text-gray-600 text-sm w-full">{moment(this.props.comment?.createdAt).fromNow()}</div>
                </div>
                <div className="text-gray-600 text-base">
                    {this.props.comment?.text}
                </div>
                {this.props.isEditing ? <TextArea onChange={(e) => this.onCommentTextChange(e)}
                    name="comment" value={this.props.comment?.text} label="Comment" /> : null}
            </div>
        );
    }
}

export default Comment;