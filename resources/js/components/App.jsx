import React from 'react';
import ReactDOM from 'react-dom';
import { connect, Provider } from 'react-redux';
import { applyMiddleware, compose, createStore } from 'redux';
import api from '../api';
import reducers from '../reducers';
import thunk from 'redux-thunk'
import Navbar from '../components/Navigation/Navbar';
import { setAuthenticated, unsetAuthenticated } from '../actions/auth';
import { setUser, unsetUser } from '../actions/user';
import { setTeam, unsetTeam } from '../actions/team';
import { BrowserRouter, Redirect, Route } from 'react-router-dom';
import LoginPage from './Pages/LoginPage';
import ForgotPasswordPage from './Pages/ForgotPasswordPage';
import RegisterPage from './Pages/RegisterPage';
import ResetPasswordPage from './Pages/ResetPasswordPage';
import HomePage from './Pages/HomePage';


const App = class App extends React.Component {
    componentDidMount() {
        // we need to get the data we have from the serve
        api.get('/profile/')
            .then(successResponse => {
                this.props.setAuthenticated(localStorage.getItem('authToken'));
                const { user, team } = successResponse.data;
                this.props.setUser(user);
                this.props.setTeam(team);
            })
            .catch(failedResponse => {
                this.props.unsetAuthenticated();
                this.props.unsetUser();
                this.props.unsetTeam();
            })
    }
    getGuestRoutes = () => {
        return (
            <React.Fragment>
                <Route path="/password-reset/:token">
                    {this.props.auth.authenticated ? <Redirect to="/home" /> : <ResetPasswordPage />}
                </Route>
                <Route path="/login">
                    {this.props.auth.authenticated ? <Redirect to="/home" /> : <LoginPage />}
                </Route>
                <Route path="/register">
                    {this.props.auth.authenticated ? <Redirect to="/home" /> : <RegisterPage />}
                </Route>
                <Route path="/password-email">
                    {this.props.auth.authenticated ? <Redirect to="/home" /> : <ForgotPasswordPage />}
                </Route>
            </React.Fragment>
        )
    }

    getAuthRoutes = () => {
        return (
            <React.Fragment>
                <Route path="/home">
                    {this.props.auth.authenticated ? <HomePage /> : <Redirect to="/login" />}
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
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const store = createStore(reducers, composeEnhancers(
    applyMiddleware(thunk)
));

const mapStateToProps = (state, ownProps) => {
    return {
        auth: state.auth
    }
}



const Application = connect(mapStateToProps, { setAuthenticated, unsetAuthenticated, setUser, unsetUser, setTeam, unsetTeam })(App);

ReactDOM.render(
    <Provider store={store}>
        <Application />
    </Provider>
    , document.getElementById('app'));
