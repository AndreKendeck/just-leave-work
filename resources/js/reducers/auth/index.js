export const authReducer = (state = { authenticated: false, token: null }, action) => {
    switch (action.type) {
        case 'AUTHENTICATED':
            return action.payload;
        case 'UNAUTHENTICATED':
            return { authenticated: false, token: null };
        case 'LOGOUT':
            return { authenticated: false, token: null };
        default:
            return state;
    }
}