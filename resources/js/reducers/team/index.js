export const teamReducer = (state = {}, action) => {
    switch (action.type) {
        case 'TEAM_SET':
            return action.payload;
        case 'UNAUTHENTICATED':
            return null;
        default:
            return state;
    }
}
