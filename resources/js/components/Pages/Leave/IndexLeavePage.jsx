import React from 'react';
import api from '../../../api';
import Card from '../../Card';
import Page from '../../Page';
import Table from '../../Table';

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
    }

    componentDidMount() {
        this.getLeaves(1);
    }

    getLeaves = (pageNumber) => {
        this.toggleLoadingState(true);
        api.get(`/leaves/?page=${pageNumber}`)
            .then(success => {
                this.toggleLoadingState(false);
                const { leaves } = success.data;
            })
            .catch(failed => {
                this.toggleLoadingState(false);
                this.setState({ error: failed.response.data.message });
            })
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
                <tr onClick={(e) => this.setState({ selectedLeave: leave })} className="hover:shadow rounded cursor-pointer" key={key}>
                    <td className="text-center text-gray-800"> <LeaveStatusBadge leave={leave} /> </td>
                    <td className="text-center text-gray-800"> {leave.reason?.name} </td>
                    <td className="text-center text-gray-800">{moment(leave.from).format('ddd Do MMM')}</td>
                    <td className="text-center text-gray-800">{moment(leave.until).format('ddd Do MMM')}</td>
                </tr>
            )
        });
    }

    render() {
        return (
            <Page className="flex flex-col space-y-2">
                <Card>
                </Card>
                <Card>
                    <Table headings={['Status', 'Type', 'On', 'Until']}>
                        {this.renderLeavesRow()}
                    </Table>
                </Card>
            </Page>
        );
    }

};

export default IndexLeavePage;