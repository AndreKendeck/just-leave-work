import { combineReducers } from "redux";
import { authReducer } from "./auth";
import { reasonsReducer } from "./reasons";
import { settingsReducer } from "./settings";
import { teamReducer } from "./team";
import { userReducer } from "./user";
import { userFormReducer } from "./forms/user";
import { commentFormReducer } from "./forms/comment";
import loginFormReducer from "./forms/auth/login";
import settingsFormReducer from "./forms/settings";
import leaveFormReducer from "./forms/leave";
import leaveExportForm from "./forms/export/leave";
import infoMessageReducer from "./messages/info";
import errorMessageReducer from "./messages/error";

export default combineReducers({
    user: userReducer,
    team: teamReducer,
    auth: authReducer,
    settings: settingsReducer,
    reasons: reasonsReducer,
    userForm: userFormReducer,
    commentForm: commentFormReducer,
    loginForm: loginFormReducer,
    settingsForm: settingsFormReducer,
    leaveForm: leaveFormReducer,
    leaveExportForm: leaveExportForm,
    messages: infoMessageReducer,
    errorMessages: errorMessageReducer
})