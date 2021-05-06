import Axios from "axios";

const api = Axios.create({
    baseURL: process.env.MIX_REACT_APP_API_URL,
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": `Bearer ${window.localStorage.getItem('authToken')}`
    }
});


export default api;