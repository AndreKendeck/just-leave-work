import moment from 'moment';
import React from 'react';
import Loader from 'react-loader-spinner';
import { Link } from 'react-router-dom';
import api from '../../../api';
import Card from '../../Card';
import EditButtonLink from '../../EditButtonLink';
import Heading from '../../Heading';
import LeaveStatusBadge from '../../LeaveStatusBadge';
import Page from '../../Page';
import Table from '../../Table';
import ViewButtonLink from '../../ViewButtonLink';

const IndexLeavePage = class IndexLeavePage extends React.Component {

    state = {
        isLoading: false,
        leaves: [],
        filters: {
            status: null,
            reasons: [],
        },
        error: null,
        isLoading: false,
        year: null,
        currentPage: 1,
        from: null,
        perPage: null,
        to: null,
        total: null
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
        const { reasons, status } = this.state.filters;
        let leaves = this.state.leaves;
        if (reasons) {
            leaves?.filter(leave => {
                return reasons.includes(leave.reason.id);
            });
        }
        if (status) {
            leaves?.filter(leave => {
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
                        <div className="flex flex-row space-x-2 items-center w-full justify-center">
                            <img className="h-6 w-6 rounded-full" src={leave.user?.avatarUrl} alt={leave.user?.name} />
                            <span className="text-gray-600 text-sm">{leave.user?.name}</span>
                        </div>
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

    render() {
        return (
            <Page className="flex flex-col space-y-2">
                <Card className="hidden md:flex w-full lg:w-3/4 self-center items-center flex-col space-y-2">
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
            </Page>
        );
    }

};

export default IndexLeavePage;