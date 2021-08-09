import moment from "moment";

/**
 * @param {object} state 
 * @param {*} param1 
 * @returns 
 */
export default function leaveExportForm(state = {
    month: 0,
    year: moment().format('Y'),
    loading: false
}, { type, payload }) {
    if (type === 'UPDATE_EXPORT_LEAVE_FORM') {
        return payload
    }
    if (type === 'CLEAR_EXPORT_LEAVE_FORM') {
        return {
            month: 0,
            year: moment().format('Y'),
            loading: false
        }
    }
    return state;
}