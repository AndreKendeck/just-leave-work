import React from 'react';
import Card from '../../Card';
import Heading from '../../Heading';
import Page from '../../Page';

export default class ForbiddenPage extends React.Component {

    render() {
        return (
            <Page>
                <Card>
                    <Heading>You are not allowed to view this page</Heading>
                </Card>
            </Page>
        )
    }

}