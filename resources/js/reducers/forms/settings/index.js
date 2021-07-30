
export default function settingsFormReducer(state = {
    leaveAddedPerCycle: 0,
    daysUntilLeaveAdded: 30,
    excludeds: []
}, { type, payload }) {
    if (type === 'UPDATE_SETTINGS_FORM') {
        return payload;
    }
    return state;
}