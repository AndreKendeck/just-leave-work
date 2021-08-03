/**
 * Update the login form state in redux
 * @param {object} payload 
 * @returns 
 */
export function updateLoginForm(payload) {
    return {
        type: 'UPDATE_LOGIN_FORM',
        payload
    }
}

/**
 * Clear the login form in state
 * @returns 
 */
export function clearLoginForm() {
    return {
        type: 'CLEAR_LOGIN_FORM'
    }
}