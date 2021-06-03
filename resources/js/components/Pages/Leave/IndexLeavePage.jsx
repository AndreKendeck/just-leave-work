import React from 'react';
import api from '../../../api';

const IndexLeavePage = class IndexLeavePage extends React.Component {

    state = {
        isLoading: false,
        leaves: [],
        filters: {
            status: null,
            reasons: [],
        }
    }

    componentDidMount() {

    }

    getLeaves = (pageNumber) => {
        api.get(`/leaves/?page=${pageNumber}`)
            .then(success => {

            })
            .catch(failed => {

            })
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

    render() {
        return (
            <div></div>
        );
    }

};

export default IndexLeavePage;