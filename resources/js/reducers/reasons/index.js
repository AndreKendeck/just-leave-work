export const reasonsReducer = (state = [], action) => {
    switch (action.type) {
        case 'SET_REASONS':
            return action.payload;
        case 'UNAUTHENTICATED':
            return []
        default:
            return state
    }
}