import React from 'react';
import { useEffect } from 'react';
import { useState } from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { useParams } from 'react-router';
import { updateUserForm } from '../../../actions/forms/user';
import api from '../../../api';
import Button from '../../Button';
import Card from '../../Card';
import Checkbox from '../../Form/Checkbox';
import Field from '../../Form/Field';
import InfoMessage from '../../InfoMessage';
import Page from '../../Page';
import UserBadge from '../../UserBadge';
import UserStatusBadge from '../../UserStatusBadge';

const EditUserPage = (props) => {
    const { id } = useParams();
    const [user, setUser] = useState({});
    const [errors, setErrors] = useState([]);
    const [loading, setLoading] = useState(true);
    const [message, setMessage] = useState(null);
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
                setErrors([errors, ...failed.response.data]);
            });
    }, []);

    const renderMessage = () => {
        return message ? (<InfoMessage text={message} onDismiss={(e) => {
            setMessage(null);
        }} />) : null;
    }

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
            setMessage(message);
        }).catch(failed => {
            const { message } = failed.response.data;
            props.updateUserForm({ ...props.userForm, loading: false });
            setErrors([message, ...errors]);
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
        let url = null;
        if (user?.isBanned) {
            url = `/user/ban/${id}`;
        } else {
            url = `/user/unban/${id}`;
        }
        api.post(url).then(success => {
            const { message } = success.data;
            setMessage(message);
        }).catch(failed => {
            const { message } = failed.response.data;
            setErrors([message, ...errors]);
        })
    }

    return (
        <Page className="flex flex-col justify-center space-y-2">
            <div className="w-2/3 self-center">
                {renderMessage()}
            </div>
            <Card className="flex flex-col w-full md:w-2/3  self-center space-y-4">
                <div className="flex flex-row justify-between items-center">
                    <div className="flex flex-row space-x-2 items-center">
                        <UserBadge user={user} />
                        <div> <UserStatusBadge user={user} /> </div>
                    </div>
                    <div>
                        {user?.isBanned && currentUser.isAdmin ? <Button type="secondary-outlined">Unblock</Button> : <Button type="outlined-danger">Block</Button>}
                    </div>
                </div>
                <Field disabled={true} value={props.userForm.name} name="name" label="Name" />
                <Field disabled={true} type="email" value={props.userForm.email} name="email" label="E-mail Address" />
                <div className="flex flex-row space-x-2 items-center">
                    <Field type="number" name="balance" label="Balance" value={props.userForm.balance} onChange={(e) => {
                        e.persist();
                        const { userForm } = props;
                        props.updateUserForm({ ...userForm, balance: e.target.value });
                    }} />
                    <div>
                        {renderSaveBalanceButton()}
                    </div>
                </div>
                <Checkbox name="is_admin" label="Is Admin" checked={props.userForm.isAdmin} />
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

export default connect(mapStateToProps, { updateUserForm })(EditUserPage);