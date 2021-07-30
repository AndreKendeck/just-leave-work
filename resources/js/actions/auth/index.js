export const setAuthenticated = (token) => {
    return { type: 'AUTHENTICATED', payload: { authenticated: true, token } }
}

export const unsetAuthenticated = () => {
    return { type: 'UNAUTHENTICATED' }
}
