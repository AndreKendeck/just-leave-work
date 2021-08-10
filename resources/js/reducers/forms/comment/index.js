export const commentFormReducer = (state = {}, { type, payload }) => {
    switch (type) {
        case 'UPDATE_COMMENT_FORM':
            return payload;
        case 'CLEAR_COMMENT_FORM':
            return {
                value: '',
                errors: null,
                loading: false
            }
        default:
            return state;
    }
}