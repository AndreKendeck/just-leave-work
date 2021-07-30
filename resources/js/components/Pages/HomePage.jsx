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
                    <td className="text-center text-gray-600 text-sm">{moment(leave.from).format('Do MMM YYYY')}</td>
                    <td className="text-center text-gray-600 text-sm">{moment(leave.until).format('Do MMM YYYY')}</td>
                    <td className="text-center text-gray-600 text-sm">{leave.numberOfDaysOff}</td>
                    <td className="text-center relative">
                        <div className="flex flex-row space-x-2 items-center">
                            <ViewButtonLink url={`/leave/view/${leave.id}`} />
                            {leave.canEdit ? <EditButtonLink url={`/leave/edit/${leave.id}`} /> : null}
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
            <Table headings={['Status', 'Type', 'On', 'Until', 'Days off', '']}>
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
                <Card className="hidden md:flex w-full lg:w-3/4 self-center items-center flex-col space-y-2">
                    <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-end">Your leave history</span>
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

export default connect(mapStateToProps, null)(HomePage);