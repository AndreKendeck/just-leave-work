import React from 'react';
import { connect } from 'react-redux';
import Card from '../Card';
import Page from '../Page';

const DashboardPage = class DashboardPage extends React.Component {
    render() {
        return (
            <Page>
                <Card></Card>
            </Page>
        )
    }
}

export default connect(null, null)(DashboardPage);