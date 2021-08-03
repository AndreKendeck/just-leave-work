/**
 * @jest-environment jsdom
 */

import React from 'react';
import ReactDOM from 'react-dom';
import Checkbox from '../../Form/Checkbox';

test('renders without fail', () => {
    const div = document.createElement('div');

    ReactDOM.render(<Checkbox />, div);

    expect(div.innerHTML).toBeTruthy();
});