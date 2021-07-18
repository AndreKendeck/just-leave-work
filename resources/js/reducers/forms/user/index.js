
const defaultState = {
    name: null,
    nameErrors: [],
    email: null,
    emailErrors: [],
    isAdmin: false,
    balance: 0,
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
            return state;
        default:
            return state;
    }
}