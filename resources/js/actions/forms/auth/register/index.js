
/**
 * Update the register form
 * @param {object} payload 
 * @returns {object}  
 */
export function updateRegisterForm(payload) {
    return {
        type: 'UPDATE_REGISTER_FORM',
        payload
    }
}

/**
 * Clear the register form 
 * @returns {object}
 */
export function clearRegisterForm() {
    return {
        type: 'CLEAR_REGISTER_FORM'
    }
}