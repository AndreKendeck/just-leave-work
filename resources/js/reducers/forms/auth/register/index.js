const initialState = {
    loading: false,
    email: '',
    password: '',
    name: '',
    team_name: '',
    terms: false,
    recaptcha: '',
    errors: {}
}
/**
 * 
 * @param {object} state 
 * @param {object} param1 
 * @returns 
 */
export default function registerFormReducer(state = initialState, { type, payload }) {
    if (type === 'UPDATE_REGISTER_FORM') {
        return payload;
    }
    if (type === 'CLEAR_REGISTER_FORM') {
        return initialState;
    }
    return state;
}