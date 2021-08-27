import React from 'react';
import ReactDOM from 'react-dom';
import { connect, Provider } from 'react-redux';
import { createStore } from 'redux';
import api from '../api';
import reducers from '../reducers';
import Navbar from '../components/Navigation/Navbar';
import { setAuthenticated, unsetAuthenticated } from '../actions/auth';
import { setUser } from '../actions/user';
import { setTeam } from '../actions/team';
import { setSettings } from '../actions/settings';
import { BrowserRouter, Redirect, Route, Switch } from 'react-router-dom';
import LoginPage from './Pages/LoginPage';
import { setReasons } from '../actions/reasons';
import ForgotPasswordPage from './Pages/ForgotPasswordPage';
import RegisterPage from './Pages/RegisterPage';
import ResetPasswordPage from './Pages/ResetPasswordPage';
import HomePage from './Pages/HomePage';
import VerifyEmailPage from './Pages/VerifyEmailPage';
import IndexLeavePage from './Pages/Leave/IndexLeavePage';
import ViewLeavePage from './Pages/Leave/ViewLeavePage';
import CreateLeavePage from './Pages/Leave/CreateLeavePage';
import ProfilePage from './Pages/ProfilePage';
import Loader from 'react-loader-spinner';
import EditLeavePage from './Pages/Leave/EditLeavePage';
import SettingsPage from './Pages/SettingsPage';
import IndexUserPage from './Pages/Users/IndexUserPage';
import UploadUsersPage from './Pages/Users/UploadUsersPage';
import ViewUserPage from './Pages/Users/ViewUserPage';
import EditUserPage from './Pages/Users/EditUserPage';
import TermsPage from './Pages/TermsPage';
import MessageModal from './MessageModal';
import { setErrorMessage } from '../actions/messages';


const App = class App extends React.Component {

    state = {
        initializing: true
    }

    componentDidMount() {
        api.get('/profile/')
            .then(successResponse => {
                this.props.setAuthenticated(localStorage.getItem('authToken'));
                const { user, team, settings, reasons } = successResponse.data;
                this.props.setUser(user);
                this.props.setTeam(team);
                this.props.setSettings(settings);
                this.props.setReasons(reasons);
                this.setState({ initializing: false });
            })
            .catch(failedResponse => {
                const { message } = failedResponse.response.data;
                this.props.unsetAuthenticated();
                this.props.setErrorMessage(message);
                this.setState({ initializing: false });
            })
    }

    getGuestRoutes = () => {
        if (this.state.initializing) {
            return null;
        }
        return (
            <React.Fragment>
                <Switch>
                    <Route path="/password-reset/:token" >
                        {this.currentUserIsAuthenticated() ? <Redirect to="/home" /> : <ResetPasswordPage />}
                    </Route>
                    <Route path="/login">
                        {this.currentUserIsAuthenticated() ? <Redirect to="/home" /> : <LoginPage />}
                    </Route>
                    <Route path="/register">
                        {this.currentUserIsAuthenticated() ? <Redirect to="/home" /> : <RegisterPage />}
                    </Route>
                    <Route path="/password-email">
                        {this.currentUserIsAuthenticated() ? <Redirect to="/home" /> : <ForgotPasswordPage />}
                    </Route>
                </Switch>
            </React.Fragment>
        )
    }

    currentUserIsAuthenticated = () => {
        return this.props.auth?.authenticated;
    }

    currentUserHasAVerifiedEmailAddress = () => {
        return this.props.user?.verified;
    }

    userIsAdmin() {
        const { user } = this.props;
        return user?.isAdmin;
    }

    getAuthRoutes = () => {
        if (this.state.initializing) {
            return null;
        }
        if (this.currentUserIsAuthenticated() && !this.currentUserHasAVerifiedEmailAddress()) {
            return (
                <React.Fragment>
                    <Switch>
                        <Route path="/profile">
                            <ProfilePage />
                        </Route>
                        <Route>
                            <VerifyEmailPage />
                        </Route>
                    </Switch>
                </React.Fragment>
            )
        }
        return (
            <React.Fragment>
                <Switch>
                    <Route path={['/home', '/']} exact={true}>
                        {this.currentUserIsAuthenticated() ? <HomePage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/leaves">
                        {this.currentUserIsAuthenticated() ? <IndexLeavePage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/leave/view/:id" exact={true}>
                        {this.currentUserIsAuthenticated() ? <ViewLeavePage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/leave/edit/:id" exact={true}>
                        {this.currentUserIsAuthenticated() ? <EditLeavePage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/leave/create" exact={true}>
                        {this.currentUserIsAuthenticated() ? <CreateLeavePage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/profile" exact={true}>
                        {this.currentUserIsAuthenticated() ? <ProfilePage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/settings" exact={true}>
                        {this.currentUserIsAuthenticated() ? <SettingsPage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/users" exact={true}>
                        {this.currentUserIsAuthenticated() ? <IndexUserPage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/user/:id" exact={true}>
                        {this.currentUserIsAuthenticated() ? <ViewUserPage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/users/create" exact={true}>
                        {this.currentUserIsAuthenticated() ? <UploadUsersPage /> : <Redirect to="/login" />}
                    </Route>
                    <Route path="/user/edit/:id" exact={true}>
                        {this.currentUserIsAuthenticated() ? <EditUserPage /> : <Redirect to="/login" />}
                    </Route>
                </Switch>
            </React.Fragment>
        )
    }

    render() {
        if (this.state.initializing) {
            return (
                <div className="flex flex-col self-center w-full justify-center h-screen">
                    <Loader type="Oval" className="self-center" height={120} width={120} color="Gray" />
                </div>
            );
        }

        return (
            <div className="flex flex-col space-y-4 z-10 bg-gray-100 h-full">
                <MessageModal />
                <BrowserRouter>
                    <Navbar />
                    <Route path="/terms-and-conditions" exact={true} >
                        <TermsPage />
                    </Route>
                    {this.getGuestRoutes()}
                    {this.getAuthRoutes()}
                </BrowserRouter>
            </div>
        )
    }
}

const appState = process.env.MIX_REACT_APP_API_URL;
const tools = appState === 'production' ? null : window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__();
const store = createStore(reducers, tools);


const mapStateToProps = (state) => {
    const { auth, user } = state;
    return {
        auth,
        user
    }
}



const Application = connect(mapStateToProps,
    {
        setAuthenticated,
        unsetAuthenticated,
        setUser,
        setTeam,
        setSettings,
        setReasons,
        setErrorMessage
    })(App);

ReactDOM.render(
    <Provider store={store} >
        <Application />
    </Provider >
    , document.getElementById('app'));
