import moment from 'moment';
import React from 'react';
import { connect } from 'react-redux';
import Card from '../Card';
import Heading from '../Heading';
import Page from '../Page';
import UserLeaveStatusBadge from '../UserLeaveStatusBadge';


const HomePage = class HomePage extends React.Component {

    componentDidMount() {
    }
    render() {
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="w-full md:w-3/4 self-center">
                    <div className="flex md:flex-row w-full justify-between items-center">
                        <Heading>
                            <div className="flex flex-row space-x-2 items-center">
                                <span>{this.props.user?.name}</span>
                                <UserLeaveStatusBadge user={this.props.user} />
                            </div>
                        </Heading>
                        <Heading>{moment().format('dddd Do MMM')}</Heading>
                    </div>
                </Card>
                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-3/4 w-full self-center">
                    <Card className="w-full border-2 border-purple-800 bg-purple-500 bg-opacity-50 transform hover:-translate-y-1 hover:shadow-2xl">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-purple-800">{this.props.user?.leaveBalance}</span>
                                <span className="text-purple-800 text-base">Leave Balance</span>
                            </div>
                        </Heading>
                    </Card>
                    <Card className="w-full bg-gray-600 border-2 border-gray-800 transform hover:-translate-y-1 hover:shadow-2xl ">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-white text-base">{this.props.user?.leaveBalance}</span>
                                <span className="text-white text-base">Leave Taken</span>
                            </div>
                        </Heading>
                    </Card>
                    <Card className="w-full"></Card>
                </div>
                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-3/4 w-full self-center">
                    <table className="table table-responsive">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                    </table>
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