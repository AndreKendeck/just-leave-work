import moment from 'moment';
import React, { useState } from 'react';
import { connect } from 'react-redux';
import { updateCommentForm } from '../actions/forms/comment';
import TextArea from './Form/Textarea';
import UserBadge from './UserBadge';



const Comment = ({ comment }) => {

    const [editing, setEditing] = useState(false);

    const renderDeleteButton = () => {
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


    return (
        <div className="flex flex-col space-y-2 w-full md:w-3/2 lg:w-1/2 self-center space-y-4 bg-white border-2 border-gray-500 rounded p-3">
            <div className="flex flex-col space-y-2">
                <div className="flex flex-row w-full justify-between">
                    <div className="w-1/4">
                        <UserBadge user={comment?.user} imageSize={8} />
                    </div>
                    {comment?.canDelete ? renderDeleteButton() : null}
                </div>
                <div className="text-gray-600 text-sm w-full">{moment(comment?.createdAt).fromNow()}</div>
            </div>
            <div className="text-gray-600 text-base" onClick={(e) => {
                if (comment.canEdit) {
                    setEditing(!editing);
                }
            }} >
                {comment?.text}
            </div>
            {editing ? <TextArea onChange={(e) => onCommentTextChange(e)}
                name="comment" value={comment?.text} label="Comment" /> : null}
        </div>
    );

}
const mapStateToProps = (state) => {
    const { commentForm } = state;
    return {
        commentForm
    };
}
export default connect(null, {})(Comment);