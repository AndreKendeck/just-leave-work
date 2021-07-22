import moment from 'moment';
import React from 'react';
import { connect } from 'react-redux';
import api from '../../../api';
import Card from '../../Card';
import Page from '../../Page';
import Table from '../../Table';
import UserBadge from '../../UserBadge';
import UserLeaveStatusBadge from '../../UserLeaveStatusBadge';
import Loader from 'react-loader-spinner';
import ErrorMessage from '../../ErrorMessage';
import Button from '../../Button';
import Dropdown from '../../Form/Dropdown';
import Modal from '../../Modal';
import Field from '../../Form/Field';
import { updateUserForm } from '../../../actions/forms/user';
import Checkbox from '../../Form/Checkbox';
import EditButtonLink from '../../EditButtonLink';
import ViewButtonLink from '../../ViewButtonLink';
import UserCard from '../../UserCard';

const IndexUserPage = class IndexUserPage extends React.Component {


    state = {
        isLoading: false,
        users: [],
        currentPage: 1,
        from: null,
        perPage: null,
        to: null,
        total: null,
        errors: [],
        roleFilter: null,
        showModal: false,
        search: null,
        userLeaveStatus: 0,
    }

    toggleModalOpenState(show = false) {
        this.setState({ showModal: show });
    }

    componentDidMount() {
        setTimeout(() => {
            this.getUsersPage();
        }, 1000);
    }

    getUsersPage(page = 1, search = null) {
        const config = {
            params: {
                page,
                search
            }
        }
        this.setState({ isLoading: true });
        api.get('/users', config)
            .then(success => {
                this.setState({ isLoading: false });
                const { currentPage, from, perPage, to, total, users } = success.data;
                const updates = { ...this.state, currentPage, from, perPage, to, total, users };
                this.setState(updates);
            }).catch(failed => {
                this.setState({ isLoading: false });
                const { message } = failed.response.data;
                this.setState({ errors: [message, ...this.state.errors] });
            });
    }

    renderLinks(user) {
        // if its the same user 
        if (user.id === this.props.user.id) {
            return null;
        }

        if (this.props.user?.isAdmin) {
            return (
                <div className="flex flex-row space-x-2 items-center">
                    <ViewButtonLink url={`/user/${user?.id}`} />
                    <EditButtonLink url={`/user/edit/${user?.id}`} />
                </div>
            );
        }

    }

    getUserRoleDropDownOptions() {
        return [
            {
                value: 0,
                label: 'All'
            },
            {
                value: 1,
                label: 'Admin'
            }
        ];
    }

    getStatusDropDownOptions() {
        return [
            {
                value: 0,
                label: 'All'
            },
            {
                value: 1,
                label: 'On leave'
            },
            {
                value: 2,
                label: 'At work'
            }
        ];
    }

    filterUsers() {
        let { users, roleFilter, userLeaveStatus } = this.state;
        if (roleFilter) {
            users = users.filter(user => {
                return user.isAdmin;
            })
        }
        if (userLeaveStatus) {

        }
        return users;
    }

    renderRows() {
        return this.filterUsers()?.map((user, index) => {
            return (
                <tr key={index}>
                    <td className="text-center text-gray-800">
                        <div className="flex flex-row space-x-2">
                            <div><UserBadge user={user} imageSize={6} /></div>
                            {user?.isAdmin ? (<div className="bg-purple-500 bg-opacity-25 text-purple-500 text-xs px-2 rounded-full py-1">Admin</div>) : null}
                            <UserLeaveStatusBadge user={user} />
                        </div>
                    </td>
                    <td className="text-center text-gray-600 text-sm"> {user.email} </td>
                    <td className="text-center text-purple-600 text-sm font-bold">
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

    renderErrors(errors = []) {
        return errors?.map((err, key) => {
            return <ErrorMessage text={err} key={key} onDismiss={(e) => { this.setState({ errors: this.state.errors.filter((er, k) => k !== key) }) }} />
        });
    }

    onNewUserInputChange(e, key) {
        e.persist();
        const { userForm } = this.props;
        this.props.updateUserForm({ ...userForm, [key]: e.target.value });
    }

    onToggleIsAdminChange() {
        const { userForm } = this.props;
        const { isAdmin } = userForm;
        this.props.updateUserForm({ ...userForm, isAdmin: !isAdmin });
    }

    renderUserCards() {
        return this.filterUsers()?.map((user, index) => {
            const showLinks = this.props.user?.isAdmin && (user.id != this.props.user?.id);
            return <UserCard user={user} key={index} showLinks={showLinks} />
        });
    }

    render() {
        return (
            <React.Fragment>
                <Page className="flex flex-col space-y-2">
                    <div className="w-full lg:w-3/4 self-center flex-col space-y-1">
                        {this.state.errors.length > 0 ? this.renderErrors(this.state.errors) : null}
                    </div>
                    <Card className="flex flex-col w-full lg:w-3/4 self-center items-center space-y-2">
                        <div className="flex flex-col md:flex-row space-x-2 w-full items-center justify-between">
                            <div className="mb-6 md:mb-0 md:mt-6 w-full">
                                <Button type="secondary" onClick={(e) => this.toggleModalOpenState(true)}>
                                    <div className="flex flex-row space-x-1 items-center justify-center">
                                        <svg version="1.1" className="stroke-current w-6 h-6 text-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                                            <g fill="none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.0052,5.2448c1.65973,1.65973 1.65973,4.35068 0,6.01041c-1.65973,1.65973 -4.35068,1.65973 -6.01041,0c-1.65973,-1.65973 -1.65973,-4.35068 -1.77636e-15,-6.01041c1.65973,-1.65973 4.35068,-1.65973 6.01041,-1.77636e-15"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4,20v0c0,-2.485 2.015,-4.5 4.5,-4.5h2.583"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.5,20.5v-5"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15,18h5"></path>
                                            </g>
                                        </svg>
                                        <span className="text-white">Add</span>
                                    </div>
                                </Button>
                            </div>
                            <div className="w-full flex flex-col space-y-2 md:space-y-0 md:flex-row md:space-x-2 items-center self-end">
                                <Dropdown onChange={(e) => { this.setState({ roleFilter: e.target.value }) }} options={this.getUserRoleDropDownOptions()} label="Role" />
                                <Dropdown onChange={(e) => { this.setState({ roleFilter: e.target.value }) }} options={this.getStatusDropDownOptions()} label="Status" />
                                <div className="flex flex-row space-x-4 items-center">
                                    <Field type="search" name="name" label="Search" placeHolder="Search user" onChange={(e) => { e.persist(); { this.setState({ search: e.target.value }); } }} />
                                    <div className="mt-6">
                                        <Button type="soft" onClick={(e) => this.getUsersPage(this.state.currentPage, this.state.search)}>
                                            <svg viewBox="0 0 24 24" className="stroke-current h-6 w-6 text-gray-600" xmlns="http://www.w3.org/2000/svg">
                                                <g fill="none"><g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                                                    <path d="M11.05 4a7.05 7.05 0 1 0 0 14.11 7.05 7.05 0 1 0 0-14.12Z" />
                                                    <path d="M8.23 8.46l0-.01c1.56-1.57 4.09-1.57 5.65-.01 0 0 0 0 0 0" />
                                                    <path d="M20 20l-3.95-3.95" /></g>
                                                </g>
                                            </svg>
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Card>
                    <Card className="hidden md:flex w-full lg:w-3/4 self-center items-center space-y-2">
                        <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-end">Users</span>
                        {this.state.isLoading ?
                            <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" /> :
                            <Table headings={['', 'E-mail', 'Balance', 'Last leave taken', 'Leave taken', '']}>
                                {this.renderRows()}
                            </Table>}
                    </Card>
                    {this.renderUserCards()}
                </Page>
                <Modal heading="" show={this.state.showModal} onClose={(e) => { this.setState({ showModal: false }) }}>
                    <div className="flex flex-col space-y-4 w-full p-4">
                        <Field name="name" label="Name" value={this.props.userForm.name}
                            onChange={(e) => { this.onNewUserInputChange(e, 'name') }} />
                        <Field name="email" label="E-Mail" value={this.props.userForm.email}
                            onChange={(e) => { this.onNewUserInputChange(e, 'email') }} />
                        <Checkbox label="Make Admin" checked={this.props.userForm.isAdmin}
                            name="isAdmin" onChange={(e) => { this.onToggleIsAdminChange() }} />
                        <Field type="number" name="balance" value={this.props.userForm.balance} label="Starting Leave Balance"
                            onChange={(e) => this.onNewUserInputChange(e, 'balance')} />
                        <Button type="primary">Save</Button>
                    </div>
                </Modal>

            </React.Fragment>
        )
    }

}

const mapStateToProps = (state) => {
    const { user, userForm, permissions } = state;
    return {
        user,
        userForm,
        permissions
    }
}



export default connect(mapStateToProps, { updateUserForm })(IndexUserPage);