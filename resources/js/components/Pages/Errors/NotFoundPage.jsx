import React from 'react';
import Card from '../../Card';
import Heading from '../../Heading';
import Page from '../../Page';

export default class NotFoundPage extends React.Component {
    render() {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col w-full md:w-2/3  self-center space-y-4">
                    <Heading>We could not find this page</Heading>
                </Card>
            </Page>
        )
    }
}