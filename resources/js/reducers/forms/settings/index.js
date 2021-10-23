
export default function settingsFormReducer(state = {
    leaveAddedPerCycle: 0,
    daysUntilLeaveAdded: 30,
    loading: false,
    errors: {},
    country: null, 
    usePublicHolidays: false
}, { type, payload }) {
    if (type === 'UPDATE_SETTINGS_FORM') {
        return payload;
    }
    return state;
}