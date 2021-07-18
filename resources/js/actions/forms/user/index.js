export const updateUserForm = (user) => {
    return { type: 'UPDATE_USER_FORM', payload: user }
}

export const clearUserForm = () => {
    return { type: 'CLEAR_USER_FORM' };
}