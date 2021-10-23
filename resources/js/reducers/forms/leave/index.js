const defaultState = {
    reason: 0,
    dates: { startDate: null, endDate: null, key: 'selection' },
    loading: false,
    halfDay: false,
    errors: null,
}

export default function leaveFormReducer(state = defaultState, { type, payload }) {
    if (type === 'UPDATE_LEAVE_FORM') {
        return payload;
    }
    if (type === 'CLEAR_LEAVE_FORM') {
        return {
            reason: 0,
            dates: { startDate: null, endDate: null, key: 'selection' },
            loading: false,
            halfDay: false
        }
    }
    return state;
}