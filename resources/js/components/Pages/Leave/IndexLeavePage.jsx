import moment from 'moment';
import React from 'react';
import Loader from 'react-loader-spinner';
import api from '../../../api';
import Card from '../../Card';
import EditButtonLink from '../../EditButtonLink';
import LeaveStatusBadge from '../../LeaveStatusBadge';
import Page from '../../Page';
import Paginator from '../../Paginator';
import Table from '../../Table';
import ViewButtonLink from '../../ViewButtonLink';
import Dropdown from '../../Form/Dropdown';
import { connect } from 'react-redux';
import UserBadge from '../../UserBadge';
import LeaveCard from '../../LeaveCard';
import Button from '../../Button';;
import { clearLeaveExportForm, updateLeaveExportForm } from '../../../actions/forms/export/leave';

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
        messages: []
    }

    componentDidMount() {
        this.setState({ year: moment().format('Y') });
        this.getLeaves(this.state.currentPage, this.state.year);
    }

    getLeaves = (pageNumber, year) => {
        this.toggleLoadingState(true);
        const config = {
            params: {
                page: pageNumber,
                year,
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
        });
    }

    toggleLoadingState(isLoading) {
        this.setState({ isLoading });
    }

    filterLeaves = () => {
        let { reason, status } = this.state.filters;
        reason = parseInt(reason);
        let { leaves } = this.state;
        if (reason) {
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
                        <div className="flex flex-row space-x-2 items-center w-full justify-center">
                            <div>{moment(leave.from).format('Do MMM YYYY')}</div>
                        </div>
                    </td>
                    <td className="text-center text-gray-600 text-sm">{leave.halfDay ? '-' : moment(leave.until).format('Do MMM YYYY')} </td>
                    <td className="text-center text-gray-600 text-sm">{leave.halfDay ? (
                        <div className="bg-gray-700 text-white px-2 py-1 rounded-full text-xs">Half Day</div>
                    ) : leave.numberOfDaysOff}</td>
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

    onYearSelect(year) {
        this.setState({ year });
    }

    updateExportForm(e, key) {
        e.persist();
        const { leaveExportForm } = this.props;
        this.props.updateLeaveExportForm({ ...leaveExportForm, [key]: e.target.value });
    }

    onExport() {
        const { leaveExportForm } = this.props;
        const { month, year } = this.props.leaveExportForm;
        this.props.updateLeaveExportForm({ ...leaveExportForm, loading: true });
        api.get(`/leaves/export/${month}/${year}`)
            .then(success => {
                const { message, file } = success.data;
                window.location = file;
                this.props.updateLeaveExportForm({ ...leaveExportForm, loading: false });
                this.setState({ messages: [...this.state.messages, message] });
            }).catch(failed => {
                const { message } = failed.response.data;
                this.setState({ error: message });
            });
    }

    getMonthCollection() {
        const months = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        return months.map((month, key) => {
            return {
                value: month,
                label: moment().month(month).format('MMM')
            }
        })
    }

    renderMessages() {
        return this.state.message?.map((message, key) => {
            return <InfoMessage text={message} key={key} onDimiss={(e) => {
                const { messages } = this.state;
                let newMessages = messages.filter((m, k) => k !== key);
                this.setState({ messages: newMessages });
            }} />
        })
    }

    render() {
        return (
            <React.Fragment>
                <Page className="flex flex-col space-y-2">
                    {this.renderMessages()}
                    <Card className="flex w-full lg:w-3/4 lg:space-x-2 self-center items-center flex-col lg:flex-row lg:space-y-0 space-y-2">
                        <Dropdown label="Status" options={this.getLeaveStatuses()}
                            onChange={(e) => { e.persist(); this.setState({ filters: { ...this.state.filters, status: e.target.value } }) }} />

                        <Dropdown options={this.props.reasons}
                            label="Reason"
                            onChange={(e) => {
                                e.persist();
                                this.setState({ filters: { ...this.state.filters, reason: e.target.value } })
                            }} />
                        <Dropdown label="Year" options={this.props.years} onChange={(e) => {
                            e.persist(); this.onYearSelect(e.target.value); this.getLeaves(this.state.currentPage, e.target.value);
                        }} />

                    </Card>
                    <Card className="flex w-full lg:w-3/4 lg:space-x-2 self-center items-center flex-col lg:flex-row lg:space-y-0 space-y-2 justify-center">
                        <div className="flex w-full md:w-1/2 flex-col md:flex-row md:space-x-2 space-y-2 md:space-y-0" >
                            <Dropdown options={this.getMonthCollection()} label="Month" name="month" value={this.props.leaveExportForm.month} onChange={(e) => this.updateExportForm(e, 'month')} />
                            <Dropdown options={this.props.years} label="Year" name="year" value={this.props.leaveExportForm.year} onChange={(e) => this.updateExportForm(e, 'year')} />
                            <div className="self-center w-full pt-5">
                                {this.props.leaveExportForm.loading ? <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" /> : (
                                    <Button type="soft" onClick={(e) => this.onExport()} >Export</Button>
                                )}
                            </div>
                        </div>
                    </Card>
                    <Card className="hidden md:flex w-full lg:w-3/4 self-center items-center flex-col space-y-2">
                        <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-end">Leave Requests</span>
                        {this.state.isLoading ?
                            <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" /> :
                            <Table headings={['Requested By', 'Status', 'Type', 'On', 'Until', 'Days off', '']}>
                                {this.renderLeavesRow()}
                            </Table>}
                    </Card>
                    {this.state.isLoading ? (<div className="md:hidden self-center"> <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" /> </div>) :
                        (<div className="w-full overflow-auto space-y-2 flex flex-col md:hidden" style={{ height: '350px' }} >
                            {this.renderLeaveCards()}
                        </div>)}

                    <Paginator onNextPage={() => this.getLeaves((this.state.currentPage + 1), this.state.year)}
                        onPreviousPage={() => this.getLeaves((this.state.currentPage - 1), this.state.year)}
                        onPageSelect={(page) => this.getLeaves(page, this.state.year)}
                        onLastPage={this.state.to === this.state.currentPage}
                        onFirstPage={this.state.currentPage === 1}
                        activePage={this.state.currentPage} numberOfPages={this.state.to} />
                </Page>
            </React.Fragment>
        );
    }

};

const mapStateToProps = (state) => {
    const { reasons, leaveExportForm } = state;
    return {
        leaveExportForm,
        reasons: [{ value: '0', label: 'All' }, ...reasons.map(reason => {
            return {
                value: reason.id,
                label: reason.name
            }
        })],
        years: [0, 1, 2, 3, 4].map(year => {
            const result = moment().subtract(year, 'year').format('Y');
            return {
                value: result,
                label: result,
            }
        })
    }
}



export default connect(mapStateToProps, { updateLeaveExportForm, clearLeaveExportForm })(IndexLeavePage);