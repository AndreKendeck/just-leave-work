
const defaultState = {
    name: '',
    email: '',
    isAdmin: false,
    balance: 0,
    errors: [],
    messages: [],
}

/**
 * 
 * @param {object} defaultState 
 * @param {object} action 
 * @returns 
 */
export const userFormReducer = (state = defaultState, action) => {
    switch (action.type) {
        case 'UPDATE_USER_FORM':
            return action.payload;
        case 'CLEAR_USER_FORM':
            return {
                name: '',
                email: '',
                isAdmin: false,
                balance: 0,
                errors: [],
                messages: [],
            }
        default:
            return state;
    }
}