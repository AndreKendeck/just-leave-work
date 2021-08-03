export const commentFormReducer = (state = {}, { type, payload }) => {
    switch (type) {
        case 'UPDATE_COMMENT_FORM':
            return payload;
            break;
        case 'CLEAR_COMMENT_FORM':
            return {
                value: '',
                errors: [],
                loading: false
            }
            break;
        default:
            return state;
            break;
    }
}