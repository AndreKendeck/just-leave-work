import React from 'react';
import ReactDOM from 'react-dom';
import { connect, Provider } from 'react-redux';
import { applyMiddleware, compose, createStore } from 'redux';
import api from '../api';
import reducers from '../reducers';
import thunk from 'redux-thunk'
import Navbar from '../components/Navigation/Navbar';
import { setAuthenticated, unsetAuthenticated } from '../actions/auth';
import { setUser } from '../actions/user';
import { BrowserRouter, Route } from 'react-router-dom';
import LoginPage from './Pages/LoginPage';


const App = class App extends React.Component {
    componentDidMount() {
        // we need to get the data we have from the serve
        // api.get('/api/profile/')
        //     .then(successResponse => {
        //         this.props.setUser(successResponse.data);
        //     })
        //     .catch(failedResponse => {
        //         this.props.unsetAuthenticated();
        //     })
    }
    getGuestRoutes = () => {
        return (
            <React.Fragment>
                <Route path="/login">
                    {this.props.auth.authenticated ? null : <LoginPage />}
                </Route>
            </React.Fragment>
        )
    }
    render() {
        return (
            <div className="flex flex-col space-y-4 ">
                <BrowserRouter>
                    <Navbar />
                    {this.getGuestRoutes()}
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

const Application = connect(mapStateToProps, { setAuthenticated, unsetAuthenticated, setUser })(App);
ReactDOM.render(
    <Provider store={store}>
        <Application />
    </Provider>
    , document.getElementById('app'));
