export const settingsReducer = (state = {}, action) => {
    switch (action.type) {
        case 'SET_SETTINGS':
            return action.payload
        case 'UNAUTHENTICATED':
            return null;
        default:
            return state;
    }
}