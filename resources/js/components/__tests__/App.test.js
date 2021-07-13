import ReactDOM from 'react';
import App from '../App';

it('Renders the app successfully', () => {
    const div = document.createElement('div');

    ReactDOM.render(App, div);

    console.log(div);

    ReactDOM.unmountComponentAtNode();

});