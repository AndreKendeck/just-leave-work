export function updateLeaveForm(payload) {
    return {
        type: 'UPDATE_LEAVE_FORM',
        payload
    }
}

export function clearLeaveForm() {
    return {
        type: 'CLEAR_LEAVE_FORM'
    }
}