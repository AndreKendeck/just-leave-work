
const defaultState = {
    loading: false,
    email: '',
    password: '',
    errors: {}
}
export default function loginFormReducer(state = defaultState, { type, payload }) {
    if (type == 'UPDATE_LOGIN_FORM') {
        return payload;
    }
    if (type == 'CLEAR_LOGIN_FORM') {
        return defaultState;
    }
    return defaultState;
}