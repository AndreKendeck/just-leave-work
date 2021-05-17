import React from 'react';
import { connect } from 'react-redux';
import Card from '../../Card';
import Page from '../../Page';

const MyLeavePage = class MyLeavePage extends React.Component {

    state = {
        leaves: [],
        error: null,
        isLoading: false,
    }
    
    componentDidMount() {

    }
    render() {
        return (
            <Page>
                <Card>
                </Card>
            </Page>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        user: state.user
    };
}

export default connect(mapStateToProps, null)(MyLeavePage);