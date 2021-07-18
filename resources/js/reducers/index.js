import { combineReducers } from "redux";
import { authReducer } from "./auth";
import { reasonsReducer } from "./reasons";
import { settingsReducer } from "./settings";
import { teamReducer } from "./team";
import { userReducer } from "./user";
import { userFormReducer } from "./forms/user";
import { permissionsReducer } from "./permissions";

export default combineReducers({
    user: userReducer,
    team: teamReducer,
    auth: authReducer,
    settings: settingsReducer,
    reasons: reasonsReducer,
    userForm: userFormReducer,
})