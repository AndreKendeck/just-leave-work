export function updateSettingsForm(payload) {
    return {
        type: 'UPDATE_SETTINGS_FORM',
        payload
    }
}

export function clearSettingForm() {
    return {
        type: 'CLEAR_SETTINGS_FORM'
    }
}