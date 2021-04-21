import React from 'react';
import ReactDOM from 'react-dom';
import { connect, Provider } from 'react-redux';
import { applyMiddleware, createStore } from 'redux';
import api from '../api';
import reducers from '../reducers';
import thunk from 'redux-thunk'
import { setAuthenticated, unsetAuthenticated } from '../actions/auth';


const App = class App extends React.Component {
    componentDidMount() {
        // we need to get the data we have from the serve
        // api.get('/api/profile/')
        //     .then(successResponse => {
        //         console.log(successResponse);
                
        //     })
        //     .catch(failedResponse => {
        //         this.props.unsetAuthenticated();
        //     })
    }
    render() {
        return (
            <div className="text-xl bg-green-500 text-green-500">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque placeat hic rem reprehenderit amet necessitatibus adipisci. Iste provident, dolor molestias eligendi sint quasi placeat, asperiores nostrum quo eum natus reprehenderit.
            </div>
        )
    }
}

const store = createStore(reducers, applyMiddleware(thunk));
const Application = connect(null, { setAuthenticated, unsetAuthenticated })(App);
ReactDOM.render(
    <Provider store={store}>
        <Application />
    </Provider>
    , document.getElementById('app'));
