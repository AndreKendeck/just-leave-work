import React from 'react';
import { useEffect } from 'react';
import { useState } from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { useParams } from 'react-router';
import { updateUserForm } from '../../../actions/forms/user';
import { setErrorMessage, setMessage } from '../../../actions/messages';
import api from '../../../api';
import Button from '../../Button';
import Card from '../../Card';
import Checkbox from '../../Form/Checkbox';
import Field from '../../Form/Field';
import Page from '../../Page';
import UserBadge from '../../UserBadge';
import UserStatusBadge from '../../UserStatusBadge';

const EditUserPage = (props) => {
    const { id } = useParams();
    const [user, setUser] = useState({});
    const [loading, setLoading] = useState(true);
    useEffect(() => {
        if (props.currentUser.id == id) {
            window.location = '/profile';
        }
        api.get(`/users/${id}`)
            .then(success => {
                let user = success.data;
                setUser(user);
                setLoading(false);
                props.updateUserForm({ name: user.name, isAdmin: user.isAdmin, balance: user.leaveBalance, email: user.email })
            }).catch(failed => {
                setLoading(false);
                const { message } = failed.response.data;
                props.setErrorMessage(message);
            });
    }, []);

    const onBalanceAdjusment = () => {
        const { balance: adjustedBalance } = props.userForm;
        const { leaveBalance } = user;
        props.updateUserForm({ ...props.userForm, loading: true });
        let url = null;
        if (leaveBalance > adjustedBalance) {
            url = '/leaves/deduct';
        } else if (leaveBalance < adjustedBalance) {
            url = '/leaves/add';
        }
        api.post(url, {
            user: id,
            amount: adjustedBalance
        }).then(success => {
            const { message, balance } = success.data;
            props.updateUserForm({ ...props.userForm, loading: false });
            props.updateUserForm({ ...props.userForm, balance });
            props.setMessage(message);
        }).catch(failed => {
            const { message } = failed.response.data;
            props.updateUserForm({ ...props.userForm, loading: false });
            props.setErrorMessage(message);
        });
    }

    const renderSaveBalanceButton = () => {
        const { balance: adjustedBalance } = props.userForm;
        const { leaveBalance } = user;
        if (leaveBalance !== adjustedBalance) {
            if (props.userForm.loading) {
                return <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
            }
            return <Button type="soft" onClick={(e) => onBalanceAdjusment()}>Update</Button>
        }
        return null;
    }

    if (loading) {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col w-full md:w-2/3  self-center space-y-4">
                    <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
                </Card>
            </Page>
        )
    }

    const toggleBlock = () => {
        const { userForm } = props;
        props.updateUserForm({ ...userForm, loading: true });
        let url = null;
        if (!user.isBanned) {
            url = `/user/ban/${id}`;
        } else {
            url = `/user/unban/${id}`;
        }
        api.post(url).then(success => {
            const { message, user } = success.data;
            props.setMessage(message);
            setUser(user);
            props.updateUserForm({ ...userForm, loading: false });
        }).catch(failed => {
            const { message } = failed.response.data;
            props.setErrorMessage(message);
        })
    }

    const renderBlockButton = () => {
        const { currentUser, userForm } = props;
        if (!currentUser.isAdmin) {
            return null;
        }

        if (userForm.loading) {
            return <Loader type="Oval" className="self-center" height={40} width={40} color="Gray" />
        }

        if (user.isBanned) {
            return <Button onClick={(e) => toggleBlock()} type="secondary-outlined">Unblock</Button>
        }

        return (
            <Button type="outlined-danger" onClick={(e) => toggleBlock()} >
                <div className="flex flex-row space-x-2 items-center text-red-500 hover:text-white">
                    <svg version="1.1" className="stroke-current h-6 w-6 " viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                        <g fill="none">
                            <circle cx="12" cy="8.25" r="4.25" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 20v0c0-2.485 2.015-4.5 4.5-4.5h2.583"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 18c0 1.66-1.34 3-3 3 -1.66 0-3-1.34-3-3 0-1.66 1.34-3 3-3 1.66 0 3 1.34 3 3Z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.879 20.121l4.241-4.241"></path>
                        </g>
                    </svg>
                    <span>Block</span>
                </div>
            </Button>
        )

    }

    const toggleAdmin = (isAdmin) => {
        api.put(`/users/${id}`, { is_admin: isAdmin })
            .then(success => {
                const { message, user } = success.data;
                props.setMessage(message);
                setUser(user);
            }).catch(failed => {
                const { message } = failed.response.data;
                props.setErrorMessage(message);
            });
    }

    return (
        <Page className="flex flex-col justify-center space-y-2">
            <Card className="flex flex-col w-full md:w-2/3  self-center space-y-4">
                <div className="flex flex-row justify-between items-center">
                    <div className="flex flex-row space-x-2 items-center">
                        <UserBadge user={user} />
                        <div> <UserStatusBadge user={user} /> </div>
                    </div>
                    <div>
                        {renderBlockButton()}
                    </div>
                </div>
                <Field disabled={true} value={user.name} name="name" label="Name" />
                <Field disabled={true} type="email" value={user.email} name="email" label="E-mail Address" />
                <Field disabled={true} type="text" value={user.jobPosition} name="job_position" label="Job Position" />
                <div className="flex flex-row space-x-2 items-center">
                    <Field type="number" disabled={user.isBanned} name="balance" step="0.25" label="Balance" value={props.userForm.balance} onChange={(e) => {
                        e.persist();
                        const { userForm } = props;
                        props.updateUserForm({ ...userForm, balance: e.target.value });
                    }} />
                    <div className="mt-6">
                        {renderSaveBalanceButton()}
                    </div>
                </div>
                <Checkbox name="is_admin" disabled={user.isBanned} onChange={(e) => {
                    const { userForm } = props;
                    props.updateUserForm({ ...userForm, isAdmin: !userForm.isAdmin });
                    toggleAdmin(!userForm.isAdmin);
                }} label="Is Admin" checked={props.userForm.isAdmin} />
            </Card>
        </Page>
    );
}

const mapStateToProps = (state) => {
    const { user, userForm } = state;
    return {
        currentUser: user,
        userForm
    };
}

export default connect(mapStateToProps, { updateUserForm, setMessage, setErrorMessage })(EditUserPage);