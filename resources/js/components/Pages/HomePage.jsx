import React from 'react';
import { connect } from 'react-redux';
import Card from '../Card';
import Page from '../Page';

const HomePage = class HomePage extends React.Component {
    render() {
        return (
            <Page>
                <Card>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat sed neque sit omnis eos cupiditate, quo iste soluta. Magni nobis quam nemo provident similique quisquam! Laudantium mollitia officia aspernatur! Perspiciatis?
                </Card>
            </Page>
        )
    }
}

export default connect(null, null)(HomePage);