export const settingsReducer = (state = {}, action) => {
    switch (action.type) {
        case 'SET_SETTINGS':
            return action.payload
        case 'UNSET_SETTINGS':
            return null;
        default:
            return state;
    }
}