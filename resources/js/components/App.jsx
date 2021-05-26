import React from 'react';
import ReactDOM from 'react-dom';
import { connect, Provider } from 'react-redux';
import { compose, createStore } from 'redux';
import api from '../api';
import reducers from '../reducers';
import Navbar from '../components/Navigation/Navbar';
import { setAuthenticated, unsetAuthenticated } from '../actions/auth';
import { setUser } from '../actions/user';
import { setTeam } from '../actions/team';
import { setSettings } from '../actions/settings';
import { BrowserRouter, Redirect, Route } from 'react-router-dom';
import LoginPage from './Pages/LoginPage';
import { setReasons } from '../actions/reasons';
import ForgotPasswordPage from './Pages/ForgotPasswordPage';
import RegisterPage from './Pages/RegisterPage';
import ResetPasswordPage from './Pages/ResetPasswordPage';
import HomePage from './Pages/HomePage';
import { collect } from 'collect.js';
import VerifyEmailPage from './Pages/VerifyEmailPage';
import MyLeavePage from './Pages/Leave/MyLeavePage';
import IndexLeavePage from './Pages/Leave/IndexLeavePage';
import ViewLeavePage from './Pages/Leave/ViewLeavePage';
import CreateLeavePage from './Pages/Leave/CreateLeavePage';
import ProfilePage from './Pages/ProfilePage';


const App = class App extends React.Component {
    componentDidMount() {
        // we need to get the data we have from the serve
        api.get('/profile/')
            .then(successResponse => {
                this.props.setAuthenticated(localStorage.getItem('authToken'));
                const { user, team, settings, reasons } = successResponse.data;
                this.props.setUser(user);
                this.props.setTeam(team);
                this.props.setSettings(settings);
                this.props.setReasons(reasons);
                // this.props.
            })
            .catch(failedResponse => {
                this.props.unsetAuthenticated();
            })
    }
    getGuestRoutes = () => {
        return (
            <React.Fragment>
                <Route path="/password-reset/:token">
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
            </React.Fragment>
        )
    }



    hasVerifiedEmailAddress = () => {
        return this.props.user?.verified;
    }


    currentUserIsAuthenticated = () => {
        return this.props.auth?.authenticated;
    }

    currentUserHasAVerifiedEmailAddress = () => {
        return this.props.user?.verified;
    }

    currentUserHasRole = (roleName) => {
        return collect(this.props.user?.roles).contains('name', roleName);
    }

    currentUserHasPermission = (permissonName) => {
        return collect(this.props.user?.permission).contains('name', permissonName);
    }

    getAuthRoutes = () => {
        if (this.currentUserIsAuthenticated() && !this.currentUserHasAVerifiedEmailAddress()) {
            return (
                <React.Fragment>
                    <Route path="/*">
                        <VerifyEmailPage />
                    </Route>
                </React.Fragment>
            )
        }
        return (
            <React.Fragment>

                <Route path={['/home', '/']} exact={true}>
                    {this.currentUserIsAuthenticated() ? <HomePage /> : <Redirect to="/login" />}
                </Route>
                <Route path="/leaves">
                    {this.currentUserIsAuthenticated() ? <IndexLeavePage /> : <Redirect to="/login" />}
                </Route>
                <Route path="/my-leaves">
                    {this.currentUserIsAuthenticated() ? <MyLeavePage /> : <Redirect to="/login" />}
                </Route>
                <Route path={['/leaves/view/:id', '/leave/view/:id']} exact={true}>
                    {this.currentUserIsAuthenticated() ? <ViewLeavePage /> : <Redirect to="/login" />}
                </Route>
                <Route path="/leave/create">
                    {this.currentUserIsAuthenticated() ? <CreateLeavePage /> : <Redirect to="/login" />}
                </Route>
                <Route path="/profile">
                    {this.currentUserIsAuthenticated() ? <ProfilePage /> : <Redirect to="/login" />}
                </Route>
                <Route path="/settings">

                </Route>
                <Route path="/users">

                </Route>
                <Route path="/">

                </Route>
            </React.Fragment>
        )
    }

    getMiscRoutes = () => {
        return (
            <React.Fragment>
            </React.Fragment>
        )
    }

    render() {
        return (
            <div className="flex flex-col space-y-4">
                <BrowserRouter>
                    <Navbar />
                    {this.getGuestRoutes()}
                    {this.getMiscRoutes()}
                    {this.getAuthRoutes()}
                </BrowserRouter>
            </div>
        )
    }
}


const store = createStore(reducers,
     window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
);


const mapStateToProps = (state) => {
    return {
        auth: state.auth,
        user: state.user
    }
}



const Application = connect(mapStateToProps,
    {
        setAuthenticated,
        unsetAuthenticated,
        setUser,
        setTeam,
        setSettings,
        setReasons
    })(App);

ReactDOM.render(
    <Provider store={store} >
        <Application />
    </Provider >
    , document.getElementById('app'));
