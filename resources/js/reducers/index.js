import { combineReducers } from "redux";
import { authReducer } from "./auth";
import { teamReducer } from "./team";
import { userReducer } from "./user";


export default combineReducers({
    user: userReducer,
    team: teamReducer,
    auth: authReducer
})