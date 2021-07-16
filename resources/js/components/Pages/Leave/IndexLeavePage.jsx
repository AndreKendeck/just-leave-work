import moment from 'moment';
import React from 'react';
import Loader from 'react-loader-spinner';
import api from '../../../api';
import Card from '../../Card';
import EditButtonLink from '../../EditButtonLink';
import Heading from '../../Heading';
import LeaveStatusBadge from '../../LeaveStatusBadge';
import Page from '../../Page';
import Paginator from '../../Paginator';
import Table from '../../Table';
import ViewButtonLink from '../../ViewButtonLink';
import Dropdown from '../../Form/Dropdown';
import { connect } from 'react-redux';
import UserBadge from '../../UserBadge';
import LeaveCard from '../../LeaveCard';

const IndexLeavePage = class IndexLeavePage extends React.Component {

    state = {
        isLoading: false,
        leaves: [],
        filters: {
            status: null,
            reason: null,
        },
        error: null,
        isLoading: false,
        year: null,
        currentPage: 1,
        from: null,
        perPage: null,
        to: null,
        total: null,
    }

    componentDidMount() {
        this.getLeaves(this.state.currentPage);
    }

    getLeaves = (pageNumber) => {
        this.toggleLoadingState(true);
        const config = {
            params: {
                page: pageNumber,
                year: this.state.year,
            }
        }
        setTimeout(() => {
            api.get(`/leaves/`, config)
                .then(success => {
                    this.toggleLoadingState(false);
                    const { leaves, currentPage, from, perPage, to, total } = success.data;
                    this.setState(state => {
                        return {
                            ...state,
                            leaves,
                            currentPage,
                            from,
                            perPage,
                            to,
                            total
                        }
                    })
                })
                .catch(failed => {
                    this.toggleLoadingState(false);
                    this.setState({ error: failed.response.data.message });
                })
        }, 1500);
    }

    toggleLoadingState(isLoading) {
        this.setState({ isLoading });
    }

    filterLeaves = () => {
        const { reason, status } = this.state.filters;
        let { leaves } = this.state;
        if (reason && reason != 0) {
            leaves = leaves?.filter(leave => {
                return parseInt(reason) === leave.reason.id;
            });
        }
        if (status) {
            leaves = leaves?.filter(leave => {
                if (status === 'approved') {
                    return leave.approved;
                }
                if (status === 'denied') {
                    return leave.denied;
                }
                return leave.pending;
            });
        }
        return leaves;
    }

    renderLeavesRow = () => {
        return this.filterLeaves().map((leave, key) => {
            return (
                <tr key={key}>
                    <td className="text-center text-gray-800">
                        <UserBadge user={leave.user} imageSize={6} />
                    </td>
                    <td className="text-center text-gray-600 text-sm"><LeaveStatusBadge leave={leave} /> </td>
                    <td className="text-center text-gray-600 text-sm"> {leave.reason?.name} </td>
                    <td className="text-center text-gray-600 text-sm">
                        {moment(leave.from).format('Do MMM YYYY')}
                    </td>
                    <td className="text-center text-gray-600 text-sm">
                        {moment(leave.until).format('Do MMM YYYY')}
                    </td>
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

    renderLeaveCards = () => {
        return this.filterLeaves().map((leave, key) => {
            return (
                <LeaveCard leave={leave} key={key} />
            )
        });
    }

    getLeaveStatuses = () => {
        return [
            {
                value: '',
                label: 'All'
            },
            {
                value: 'pending',
                label: 'Pending'
            },
            {
                value: 'approved',
                label: 'Approved'
            },
            {
                value: 'denied',
                label: 'Denied'
            }
        ];
    }

    render() {
        return (
            <Page className="flex flex-col space-y-2">
                <Card className="flex flex-col w-full lg:w-3/4 lg:space-x-2 self-center items-center flex-col lg:flex-row lg:space-y-0 space-y-2">
                    <Dropdown label="Status" options={this.getLeaveStatuses()}
                        onChange={(e) => { e.persist(); this.setState({ filters: { ...this.state.filters, status: e.target.value } }) }} />

                    <Dropdown options={this.props.reasons}
                        label="Reason"
                        onChange={(e) => { e.persist(); console.log(e.target.value); this.setState({ filters: { ...this.state.filters, reason: e.target.value } }) }} />
                </Card>
                <Card className="hidden md:flex w-full lg:w-3/4 self-center items-center flex-col space-y-2">
                    <div className="flex flex-row justify-between items-center">
                        <Heading>
                            <span className="text-base md:text-lg text-gray-800">All leaves</span>
                        </Heading>
                    </div>
                    {this.state.isLoading ?
                        <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" /> :
                        <Table headings={['Requested By', 'Status', 'Type', 'On', 'Until', '']}>
                            {this.renderLeavesRow()}
                        </Table>}
                </Card>
                {this.state.isLoading ? (<div className="md:hidden self-center"> <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" /> </div>) :
                    (<div className="w-full overflow-auto space-y-2 flex flex-col md:hidden" style={{ height: '350px' }} >
                        {this.renderLeaveCards()}
                    </div>)}

                <Paginator onNextPage={() => this.getLeaves((this.state.currentPage + 1))}
                    onPreviousPage={() => this.getLeaves((this.state.currentPage - 1))}
                    onPageSelect={(page) => this.getLeaves(page)}
                    onLastPage={this.state.to === this.state.currentPage}
                    onFirstPage={this.state.currentPage === 1}
                    activePage={this.state.currentPage} numberOfPages={this.state.to} />
            </Page>
        );
    }

};

const mapStateToProps = (state) => {
    return {
        reasons: [{ value: 0, label: 'All' }, ...state.reasons.map(reason => {
            return {
                value: reason.id,
                label: reason.name
            }
        })]
    }
}

export default connect(mapStateToProps)(IndexLeavePage);