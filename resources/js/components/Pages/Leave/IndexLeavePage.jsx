import React from 'react';
import api from '../../../api';

const IndexLeavePage = class IndexLeavePage extends React.Component {

    state = {
        isLoading: false,
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

    render() {
        return (
            <div></div>
        );
    }

};

export default IndexLeavePage;