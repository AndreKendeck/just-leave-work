export default function infoMessageReducer(state = null, { type, paylod }) {
    if (type === 'SET_MESSAGE') {
        return payload;
    }
    if (type === 'CLEAR_MESSAGES') {
        return null;
    }
    return state;
}