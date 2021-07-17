import { collect } from 'collect.js';
import moment from 'moment';
import React from 'react';
import { connect } from 'react-redux';
import api from '../../../api';
import Card from '../../Card';
import Page from '../../Page';
import Table from '../../Table';
import UserBadge from '../../UserBadge';
import UserLeaveStatusBadge from '../../UserLeaveStatusBadge';
import EditLeavePage from '../Leave/EditLeavePage';
import Loader from 'react-loader-spinner';

const IndexUserPage = class IndexUserPage extends React.Component {


    state = {
        isLoading: false,
        users: [],
        currentPage: 1,
        from: null,
        perPage: null,
        to: null,
        total: null,
    }

    componentDidMount() {
        setTimeout(() => {
            this.getUsersPage();
        }, 1000);
    }

    getUsersPage(page = 1) {
        const config = {
            params: {
                page
            }
        }
        api.get('/users', config)
            .then(success => {
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
                });
            }).catch(failed => {

            })
    }

    canEditUsersLink = () => {

    }

    renderLinks(user) {
        // if its the same user 
        if (user.id === this.props.user.id) {
            return null;
        }

        const isAdmin = collect(this.props.user?.roles).contains('name', 'team-admin');
        const canDeleteUsers = collect(this.props.user?.permissions).contains('name', 'can-delete-users');
        const canAddUsers = collect(this.props.user?.permissions).contains('name', 'can-add-users');

        if (isAdmin) {
            return (
                <div className="flex flex-row space-x-2 items-center">
                    <ViewButtonLink url={`/user/${user?.id}`} />
                    <EditLeavePage url={`/user/edit/${user?.id}`} />
                </div>
            );
        }

    }

    renderRows() {
        return this.users?.map((user, index) => {
            return (
                <tr key={index}>
                    <td className="text-center text-gray-800">
                        <div className="flex-flex-row space-x-2">
                            <UserBadge user={user} imageSize={6} />
                            <UserLeaveStatusBadge user={user} />
                        </div>
                    </td>
                    <td className="text-center text-gray-600 text-sm"> {user.email} </td>
                    <td className="text-center text-gray-600 text-sm">
                        {user.leaveBalance}
                    </td>
                    <td className="text-center text-gray-600 text-sm">
                        {user.lastLeaveAt ? moment(user.lastLeaveAt).format('ddd Do MMM') : '-'}
                    </td>
                    <td className="text-center text-gray-600 text-sm"> {user.leaveTaken} </td>
                    <td className="text-center relative">
                        {this.renderLinks(user)}
                    </td>
                </tr>
            )
        });
    }

    render() {
        return (
            <Page className="flex flex-col space-y-2">
                <Card className="hidden md:flex w-full lg:w-3/4 self-center items-center flex-col space-y-2">
                    {this.state.isLoading ?
                        <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" /> :
                        <Table headings={['', 'e-mail', 'Balance', 'Last leave taken', 'Leave taken', '']}>
                            {this.renderRows()}
                        </Table>}
                </Card>
            </Page>
        )
    }

}

const mapStateToProps = (state) => {
    const { user } = state;
    return {
        user
    }
}

export default connect(mapStateToProps, null)(IndexUserPage);