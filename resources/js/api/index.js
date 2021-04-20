import Axios from "axios";

const api = Axios.create({
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": `Bearer ${window.localStorage.getItem('authToken')}`
    }
});

export default api;