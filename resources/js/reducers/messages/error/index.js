export default function errorMessageReducer(state = null, { type, payload }) {
    if (type === 'SET_ERROR_MESSAGE') {
        return payload;
    }
    if (type === 'CLEAR_MESSAGES') {
        return null; 
    }
    return state;
}