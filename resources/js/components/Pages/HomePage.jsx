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
import Table from '../Table';
import ViewButtonLink from '../ViewButtonLink';
import EditButtonLink from '../EditButtonLink';
import Paginator from '../Paginator';
import LeaveCard from '../LeaveCard';
import Dropdown from '../Form/Dropdown';
import UserLeaveSummary from '../UserLeaveSummary';
import Modal from '../Modal';
import Field from '../Form/Field';
import Button from '../Button';
import { setErrorMessage, setMessage } from '../../actions/messages';

const HomePage = class HomePage extends React.Component {

    state = {
        error: null,
        leaves: [],
        paginator: null,
        isLoading: true,
        selectedLeave: null,
        currentPage: 1,
        from: null,
        perPage: null,
        to: null,
        total: null,
        year: null,
        email: null,
        selectedLeaveId: null,
        showModal: false,
        isSending: false,
        emailErrors: [],
    }

    componentDidMount() {
        setTimeout(() => {
            this.getLeaves(this.state.currentPage);
        }, 1000);
    }

    getLeaves(page, year = null) {
        this.setState({ isLoading: true });
        api.get('/my-leaves', {
            params: {
                page,
                year
            }
        }).then(success => {
            this.setState({ isLoading: false });
            const { leaves, currentPage, from, perPage, to, total } = success.data;
            this.setState({ leaves: leaves });
            this.setState(state => {
                return {
                    ...state,
                    from,
                    currentPage,
                    perPage,
                    to,
                    total
                }
            });
            this.setState({ isLoading: false });
        }).catch(failed => {
            this.setState({ isLoading: false });
            const { message } = failed.response.data;
            this.setState({ isLoading: false });
            this.setState({ error: message });
        })
    }





    getLeavesTableRow = () => {
        return this.state.leaves?.map((leave, key) => {
            return (
                <tr className="rounded" key={key}>
                    <td className="text-center text-gray-600 text-sm"> <LeaveStatusBadge leave={leave} /> </td>
                    <td className="text-center text-gray-600 text-sm"> {leave.reason?.name} </td>
                    <td className="text-center text-gray-600 text-sm">
                        <div className="flex flex-row space-x-2 items-center w-full justify-center">
                            <div>{moment(leave.from).format('Do MMM YYYY')}</div>
                        </div>
                    </td>
                    <td className="text-center text-gray-600 text-sm">{leave.halfDay ? '-' : moment(leave.until).format('Do MMM YYYY')} </td>
                    <td className="text-center text-gray-600 text-sm">{leave.numberOfDaysOff} </td>
                    <td className="text-center text-gray-600 text-sm">{leave?.lastSentAt ? moment(leave.lastSentAt).format('ll') : (
                        <span className="px-2 py-1 bg-red-300 bg-opacity-75 text-red-600 text-xs rounded-full">Leave not Emailed</span>
                    )} </td>
                    <td className="text-center relative">
                        <div className="flex flex-row space-x-2 items-center">
                            <ViewButtonLink url={`/leave/view/${leave.id}`} />
                            {leave.canEdit ? <EditButtonLink url={`/leave/edit/${leave.id}`} /> : null}
                            <div>
                                <button onClick={(e) => this.setState({ showModal: true, selectedLeaveId: leave?.id })} className="items-center focus:outline-none bg-gray-300 text-gray-800 p-1 w-full rounded text-center hover:bg-gray-200 tranform" type="soft">
                                    <svg version="1.1" viewBox="0 0 24 24" className="stroke-current h-6 w-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" >
                                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round"><path d="M20,6.039v6.989"></path>
                                            <path d="M21,19.028h-6"></path>
                                            <path d="M19,17.028l2,2l-2,2"></path>
                                            <path d="M11,17.028h-6c-1.105,0 -2,-0.895 -2,-2v-8.989"></path>
                                            <path d="M5.011,4.028h12.979c1.11,0 2.011,0.9 2.011,2.011v0c0,0.667 -0.331,1.29 -0.883,1.664l-5.357,3.631c-1.365,0.925 -3.157,0.925 -4.522,0l-5.356,-3.63c-0.552,-0.374 -0.883,-0.998 -0.883,-1.664v-0.001c0,-1.111 0.9,-2.011 2.011,-2.011Z"></path>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>
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
            <Table headings={['Status', 'Type', 'On', 'Until', 'Days off', 'Last Sent', '']}>
                {this.getLeavesTableRow()}
            </Table>
        )
    }

    renderMobileLeaveCards = () => {
        return this.state.leaves?.map((leave, key) => {
            return (
                <LeaveCard leave={leave} key={key} />
            )
        });
    }

    onPageSelect = (page) => {
        this.getLeaves(page);
    }

    sendLeaveRequest() {
        this.setState({ emailErrors: [] });
        const { selectedLeaveId, email } = this.state;
        this.setState({ isSending: true });
        api.post(`/leaves/email/${selectedLeaveId}`, { email })
            .then(success => {
                const { message, leave: newLeave } = success.data;
                this.setState(state => {
                    return {
                        ...state,
                        email: null,
                        selectedLeaveId: null,
                        showModal: false,
                        isSending: false,
                        emailErrors: [],
                    }
                });
                const { leaves } = this.state;
                leaves = leaves.map(leave => {
                    if (leave.id == newLeave.id) {
                        leave = newLeave;
                    }
                    return leave;
                });
                this.setState({ leaves });
                this.props.setMessage(message);
            }).catch(failed => {
                this.setState({ isSending: false });
                if (failed.response.status === 422) {
                    this.setState({ emailErrors: failed.response.data.errors.email });
                    // I like returning early
                    return;
                }
                const { message } = failed.response.data;
                this.props.setErrorMessage(message);
            })
    }

    renderSendEmailButton() {
        const { email, isSending } = this.state;
        if (!email) {
            return null;
        }
        if (isSending) {
            return <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
        }
        return <Button type="soft" onClick={(e) => this.sendLeaveRequest()} >Send</Button>
    }

    render() {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="w-full lg:w-3/4 self-center pointer-cursor">
                    <div className="flex md:flex-row w-full justify-between items-center">
                        <Heading>
                            <div className="flex flex-row space-x-2 items-center">
                                <span className="text-sm md:text-base text-gray-800">{this.props.user?.name}</span>
                                <UserLeaveStatusBadge user={this.props.user} />
                            </div>
                        </Heading>
                        <Heading>
                            <span className="text-sm md:text-base">
                                {moment().format('ddd Do MMM')}
                            </span>
                        </Heading>
                    </div>
                </Card>
                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-3/4 w-full self-center">
                    <UserLeaveSummary user={this.props?.user} />
                </div>
                <div className="flex flex-row w-full lg:w-3/4 self-center justify-between items-center space-x-2 ">
                    <span className="w-full md:w-1/4 text-white text-sm bg-gray-700 p-2 rounded-full text-center mt-6 lg:self-center">Your leave history</span>
                    <div className="w-full md:w-1/4">
                        <Dropdown label="Year" options={this.props.years} onChange={(e) => {
                            e.persist();
                            this.setState({ year: e.target.value });
                            this.getLeaves(this.state.currentPage, e.target.value);
                        }} />
                    </div>
                </div>
                <Card className="hidden md:flex w-full lg:w-3/4 self-center items-center flex-col space-y-2 overflow-auto" style={{ height: '400px' }}>
                    {this.getMyLeavesTable()}
                </Card>
                {this.state.isLoading ? <Loader type="Oval" className="md:hidden self-center" height={80} width={80} color="Gray" /> :
                    (<div className="w-full overflow-auto space-y-2 flex flex-col md:hidden" style={{ height: '300px' }} > {this.renderMobileLeaveCards()} </div>)}
                <Paginator onNextPage={() => this.onPageSelect((this.state.currentPage + 1))}
                    onPreviousPage={() => this.onPageSelect((this.state.currentPage - 1))}
                    onPageSelect={(page) => this.onPageSelect(page)}
                    onLastPage={this.state.to === this.state.currentPage}
                    onFirstPage={this.state.currentPage === 1}
                    activePage={this.state.currentPage} numberOfPages={this.state.to} />
                <Modal show={this.state.showModal} onClose={(e) => this.setState({ showModal: false })} >
                    <Heading>Send Leave Request</Heading>
                    <div className="flex flex-row items-center space-x-2">
                        <Field label="Email Address" errors={this.state.emailErrors} onChange={(e) => this.setState({ email: e.target.value })} name="email" />
                        <div className="mt-6">
                            {this.renderSendEmailButton()}
                        </div>
                    </div>
                </Modal>
            </Page>
        )
    }
}


const mapStateToProps = (state) => {
    return {
        user: state.user,
        settings: state.settings,
        years: [0, 1, 2, 3, 4].map(year => {
            const result = moment().subtract(year, 'year').format('Y');
            return {
                value: result,
                label: result,
            }
        })
    }
}


export default connect(mapStateToProps, { setErrorMessage, setMessage })(HomePage);