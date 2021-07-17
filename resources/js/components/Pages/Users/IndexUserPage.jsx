import moment from 'moment';
import React from 'react';
import api from '../../../api';

const IndexUserPage = class IndexUserPage extends React.Component {


    state = {
        isLoading: false,
        page: 1,
    }

    componentDidMount() {

    }

    getUsersPage(page = 1) {
        api.get('/users')
            .then(success => {

            }).catch(failed => {

            })
    }

    getTableHeadings() {
        const currentDate = moment().format('d-m-Y');
        return [
            '',
            'Name',
            'E-mail',
            `Balance (${currentDate})`,
            'Last leave taken'
        ];
    }

}