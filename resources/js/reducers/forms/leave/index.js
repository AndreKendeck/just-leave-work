const defaultState = {
    reason: 0,
    dates: { startDate: null, endDate: null, key: 'selection' },
    notifyUser: 0,
    loading: false,
    halfDay: false,
}

export default function leaveFormReducer(state = defaultState, { type, payload }) {
    if (type === 'UPDATE_LEAVE_FORM') {
        return payload;
    }
    if (type === 'CLEAR_LEAVE_FROM') {
        return {
            reason: 0,
            dates: { startDate: null, endDate: null, key: 'selection' },
            notifyUser: 0,
            loading: false,
            halfDay: false
        }
    }
    return state;
}