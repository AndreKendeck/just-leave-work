import React from 'react';
import { connect } from 'react-redux';
import Card from '../Card';
import Heading from '../Heading';
import Page from '../Page';


const HomePage = class HomePage extends React.Component {

    componentDidMount() {
    }
    render() {
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="w-full md:w-3/4 self-center">
                    <div className="flex flex-row w-full justify-between items-center">
                        <Heading>{this.props.user?.name}</Heading>
                        <Heading></Heading>
                    </div>
                </Card>
                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-3/4 w-full self-center">
                    <Card className="w-full bg-purple-500 bg-opacity-50 transform hover:-translate-y-1 hover:shadow-2xl">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-purple-800">{this.props.user?.leaveBalance}</span>
                                <span className="text-purple-800 text-base">Leave Balance</span>
                            </div>
                        </Heading>
                    </Card>
                    <Card className="w-full"></Card>
                    <Card className="w-full"></Card>
                </div>
            </Page>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        user: state.user
    }
}

export default connect(mapStateToProps, null)(HomePage);