export const setSettings = (settings = {}) => {
    return { type: 'SET_SETTINGS', payload: settings };
}

export const unsetSettings = () => {
    return { type: 'UNSET_SETTINGS' }
}