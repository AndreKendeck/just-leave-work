export const updateCommentForm = (form) => {
    return { type: 'UPDATE_COMMENT_FORM', payload: form }
}

export const clearCommentForm = () => {
    return {
        type: 'CLEAR_COMMENT_FORM',
    }
}