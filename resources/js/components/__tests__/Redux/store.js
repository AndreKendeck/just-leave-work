import { combineReducers } from "redux";
import { authReducer } from "../../../reducers/auth";

const mockStore = combineReducers({
    auth: authReducer
});

export default mockStore;