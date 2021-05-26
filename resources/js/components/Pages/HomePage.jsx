import { collect } from 'collect.js';
import moment from 'moment';
import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import Heading from '../Heading';
import LeaveDaysLabel from '../LeaveDaysLabel';
import LeaveStatusBadge from '../LeaveStatusBadge';
import Modal from '../Modal';
import Page from '../Page';
import UserLeaveStatusBadge from '../UserLeaveStatusBadge';


const HomePage = class HomePage extends React.Component {

    state = {
        error: null,
        leaves: [],
        isLoading: true,
        isLoadingStatus: false,
        selectedLeave: null,
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
        }, 1000);
    }

    onLeaveApprove = (leaveId) => {
        if (!this.canApproveOwnLeave()) {
            return;
        }
        this.isLoadingStatus({ isLoadingStatus: true });
    }

    onDenyLeave = (leaveId) => {
        if (!this.canApproveOwnLeave()) {
            return;
        }
    }

    onLeaveSelect = (leave) => {
        this.setState({ selectedLeave: leave });
    }

    getLeavesTableRow = () => {
        return this.state.leaves?.map((leave, key) => {
            return (
                <tr onClick={(e) => this.onLeaveSelect(leave)} className="hover:shadow rounded cursor-pointer" key={key}>
                    <td className="text-center text-gray-800"> <LeaveStatusBadge leave={leave} /> </td>
                    <td className="text-center text-gray-800"> {leave.reason?.name} </td>
                    <td className="text-center text-gray-800">{moment(leave.from).format('ddd Do MMM')}</td>
                    <td className="text-center text-gray-800">{moment(leave.until).format('ddd Do MMM')}</td>
                </tr>
            )
        });
    }

    canApproveOwnLeave = () => {
        return this.props.settings?.canApproveOwnLeave && collect(this.props.user?.permissions).contains('name', 'can-approve-leave');
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
                        <th className="font-bold text-center">Status</th>
                        <th className="font-bold text-center">Reason</th>
                        <th className="font-bold text-center">From</th>
                        <th className="font-bold text-center">Until</th>
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
                <Modal onClose={(e) => { this.setState({ selectedLeave: null }) }} show={this.state.selectedLeave ? true : false} heading={this.state.selectedLeave?.reason.name} >
                    <div className="flex flex-col mt-4 space-y-4">
                        <div className="w-full flex justify-between">
                            <LeaveStatusBadge leave={this.state.selectedLeave} />
                            <LeaveDaysLabel leave={this.state.selectedLeave} />
                        </div>
                        <div className="flex space-x-2">
                            <div className="text-gray-600 text-sm">Description:</div>
                            <div className="text-gray-800 text-sm">{this.state.selectedLeave?.description}</div>
                        </div>
                    </div>

                </Modal>
                <Card className="w-full lg:w-3/4 self-center pointer-cursor">
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
                    <Card className="pointer-cursor w-full lg:w-3/4 border-2 border-purple-800 bg-purple-500 bg-opacity-50 transform hover:-translate-y-1 hover:shadow-2xl">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-purple-800">{this.props.user?.leaveBalance}</span>
                                <span className="text-purple-800 text-base">Leave Balance</span>
                            </div>
                        </Heading>
                    </Card>
                    <Card className=" pointer-cursor w-full lg:w-3/4 bg-gray-600 border-2 border-gray-800 transform hover:-translate-y-1 hover:shadow-2xl ">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-white text-base">{this.props.user?.leaveTaken}</span>
                                <span className="text-white text-base">Leave Taken</span>
                            </div>
                        </Heading>
                    </Card>
                    <Card className="pointer-cursor w-full lg:w-3/4 border-gray-800 border-2 transform hover:-translate-y-1 hover:shadow-2xl ">
                        <Heading>
                            <div className="flex flex-col space-y-2">
                                <span className="text-2xl text-gray-800 text-base">{this.props.user?.lastLeaveAt ? moment(this.props.user?.lastLeaveAt).format('dddd Do MMM') : 'Not Applicable'}</span>
                                <span className="text-gray-800 text-base">Last Leave Taken</span>
                            </div>
                        </Heading>
                    </Card>
                </div>
                <Card className="w-full lg:w-3/4 self-center items-center flex flex-col space-y-2">
                    <Heading>
                        <span className="text-base md:text-lg text-gray-800">Leave History</span>
                    </Heading>
                    {this.getMyLeavesTable()}
                </Card>

            </Page >
        )
    }
}


const mapStateToProps = (state) => {
    return {
        user: state.user,
        settings: state.settings
    }
}

export default connect(mapStateToProps, null)(HomePage);