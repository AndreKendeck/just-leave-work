export const setUser = (user) => {
    return { type: 'USER_SET', payload: user }
}

export const unsetUser = () => {
    return { type: 'USER_UNSET' }
}