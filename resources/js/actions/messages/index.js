export function addMessage(message = null) {
    return {
        type: 'SET_MESSAGE',
        payload: message
    }
}

/**
 * Add an error message in the message
 * @param {string} message 
 * @returns {object}
 */
export function addErrorMessage(message = null) {
    return {
        type: 'SET_ERROR_MESSAGE',
        payload: message
    }
}

/**
 * action type to clear application messages in 
 * state
 * @returns {object}
 */
export function clearMessages() {
    return {
        type: 'CLEAR_MESSAGES'
    }
}

