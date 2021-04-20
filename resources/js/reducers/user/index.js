/**
 * User reducer that gets and sets the user of the application
 * @param {object} state 
 * @param {object} action 
 */
export const userReducer = (state = {}, action) => {
    if (action.type === 'USER_SET') {
        return action.payload;
    }
    if (action.type === 'USER_UNSET') {
        return null;
    }
    return state;
}