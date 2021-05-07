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
import { BrowserRouter, Redirect, Route } from 'react-router-dom';
import LoginPage from './Pages/LoginPage';
import ForgotPasswordPage from './Pages/ForgotPasswordPage';
import DashboardPage from './Pages/DashboardPage';
import RegisterPage from './Pages/RegisterPage';


const App = class App extends React.Component {
    componentDidMount() {
        // we need to get the data we have from the serve
        api.get('/profile/')
            .then(successResponse => {
                this.props.setAuthenticated(localStorage.getItem('authToken'));
                this.props.setUser(successResponse.data);
            })
            .catch(failedResponse => {
                this.props.unsetAuthenticated();
                this.props.unsetUser();
            })
    }
    getGuestRoutes = () => {
        return (
            <React.Fragment>
                <Route path="/reset-password">
                    {this.props.auth.authenticated ? <Redirect to="/dashboard" /> : <LoginPage />}
                </Route>
                <Route path="/login">
                    {this.props.auth.authenticated ? <Redirect to="/dashboard" /> : <LoginPage />}
                </Route>
                <Route path="/register">
                    {this.props.auth.authenticated ? <Redirect to="/dashboard" /> : <RegisterPage />}
                </Route>
                <Route path="/password-email">
                    {this.props.auth.authenticated ? <Redirect to="/dashboard" /> : <ForgotPasswordPage />}
                </Route>
            </React.Fragment>
        )
    }

    getAuthRoutes = () => {
        return (
            <React.Fragment>
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

const Application = connect(mapStateToProps, { setAuthenticated, unsetAuthenticated, setUser, unsetUser })(App);

ReactDOM.render(
    <Provider store={store}>
        <Application />
    </Provider>
    , document.getElementById('app'));
