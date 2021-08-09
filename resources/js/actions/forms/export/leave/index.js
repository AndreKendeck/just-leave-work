export function updateLeaveExportForm(payload) {
    return {
        type: 'UPDATE_EXPORT_LEAVE_FORM',
        payload
    }
}
export function clearLeaveExportForm() {
    return {
        type: 'CLEAR_EXPORT_LEAVE_FORM'
    }
}