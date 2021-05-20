import moment from 'moment';
import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import api from '../../api';
import Card from '../Card';
import Heading from '../Heading';
import LeaveStatusBadge from '../LeaveStatusBadge';
import Page from '../Page';
import UserLeaveStatusBadge from '../UserLeaveStatusBadge';


const HomePage = class HomePage extends React.Component {

    state = {
        error: null,
        leaves: [],
        isLoading: true
    }

    componentDidMount() {
        setTimeout(() => {
            api.get('/my-leaves')
                .then(success => {
                    const leaves = success.data;
                    this.setState({ leaves: leaves });
                    this.setState({ isLoading: false });
                }).catch(failed => {
                    const message = failed.response.data;
                    this.setState({ isLoading: false });
                    this.setState({ error: message });
                });
        }, 1500);
    }

    getLeavesTableRow = () => {
        return this.state.leaves?.map(leave => {
            return (
                <tr className="hover:shadow rounded cursor-pointer">
                    <td className="text-center"> <LeaveStatusBadge leave={leave} /> </td>
                    <td className="text-center"> {leave.reason?.name} </td>
                    <td className="text-center">{moment(leave.from).format('dddd Do MMM')}</td>
                    <td className="text-center">{moment(leave.until).format('dddd Do MMM')}</td>
                </tr>
            )
        });
    }

    getMyLeavesTable = () => {
        if (this.state.isLoading) {
            return (
                <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
            );
        }
        return (
            <table className="hidden md:table table table-responsive table-borderless">
                <thead>
                    <tr>
                        <td className="font-bold text-center">Status</td>
                        <td className="font-bold text-center">Reason</td>
                        <td className="font-bold text-center">From</td>
                        <td className="font-bold text-center">Until</td>
                    </tr>
                </thead>
                <tbody>
                    {this.getLeavesTableRow()}
                </tbody>
            </table>
        )
    }

    render() {
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="w-full lg:w-3/4 self-center">
                    <div className="flex md:flex-row w-full justify-between items-center">
                        <Heading>
                            <div className="flex flex-row space-x-2 items-center">
                                <span className="text-sm md:text-base">{this.props.user?.name}</span>
                                <UserLeaveStatusBadge user={this.props.user} />
                            </div>
                        </Heading>
                        <Heading>
                            <span className="text-sm md:text-base">
                                {moment().format('dddd Do MMM')}
                            </span>
                        </Heading>
                    </div>
                </Card>
                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-3/4 w-full self-center">
                    <Card className="w-full lg:w-3/4 border-2 border-purple-800 bg-purple-500 bg-opacity-50 transform hover:-translate-y-1 hover:shadow-2xl">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-purple-800">{this.props.user?.leaveBalance}</span>
                                <span className="text-purple-800 text-base">Leave Balance</span>
                            </div>
                        </Heading>
                    </Card>
                    <Card className="w-full lg:w-3/4 bg-gray-600 border-2 border-gray-800 transform hover:-translate-y-1 hover:shadow-2xl ">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-white text-base">{this.props.user?.leaveTaken}</span>
                                <span className="text-white text-base">Leave Taken</span>
                            </div>
                        </Heading>
                    </Card>
                    <Card className="w-full lg:w-3/4 "></Card>
                </div>
                <Card className="w-full lg:w-3/4 self-center items-center flex flex-col space-y-2">
                    <Heading>
                        <span className="text-base md:text-lg text-gray-800">Leave History</span>
                    </Heading>
                    {this.getMyLeavesTable()}
                </Card>
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