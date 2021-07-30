import React from 'react';
import { connect } from 'react-redux';
import { unsetAuthenticated } from '../../actions/auth';
import Button from '../Button';
import Card from '../Card';
import Page from '../Page';
import UserBadge from '../UserBadge';
import { clearUserForm, updateUserForm } from '../../actions/forms/user';
import Loader from 'react-loader-spinner';
import api from '../../api';
import ErrorMessage from '../ErrorMessage';
import UserLeaveSummary from '../UserLeaveSummary';
import Field from '../Form/Field';
import InfoMessage from '../InfoMessage';
const ProfilePage = class ProfilePage extends React.Component {

    state = {
        loading: false,
        errors: [],
        message: null,
    }

    logout() {
        this.setState({ loading: true });
        setTimeout(() => {
            api.post('/logout')
                .then(success => {
                    this.props.unsetAuthenticated();
                    localStorage.removeItem('authToken');
                    window.location = '/';
                }).catch(failed => {
                    const { message } = failed.response.data;
                    this.setState({ errors: [...message, ...this.state.errors] });
                    this.setState({ loading: false });
                });
        }, 1500);

    }

    componentDidMount() {
        const { user } = this.props;
        const { name, leaveBalance } = this.props.user;
        this.props.updateUserForm({ name, balance: leaveBalance, jobPosition: user.jobPosition });
    }

    isAdmin() {
        const { user } = this.props;
        return user?.isAdmin;
    }

    renderErrors() {
        return this.state.errors?.map((error, key) => {
            return <ErrorMessage text={error} key={key} />
        });
    }

    onLeaveBalanceChange(e) {
        e.persist();
        const { userForm } = this.props;
        let balance = parseInt(e.target.value);
        this.props.updateUserForm({ ...userForm, balance });
    }

    leaveBalanceDiffersFromOriginal() {
        return this.props.user?.leaveBalance != this.props.userForm?.balance;
    }

    renderLeaveAdjustmentSubmitButton() {
        if (this.props.userForm?.loading) {
            return <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
        }
        if (this.leaveBalanceDiffersFromOriginal()) {
            return <Button type="primary" onClick={(e) => this.onBalanceSubmit()} >Save</Button>
        }
        return null;
    }

    onBalanceSubmit() {
        if (!this.isAdmin()) {
            return;
        }
        this.props.updateUserForm({ ...this.props.userForm, loading: true });
        const { user } = this.props;
        const { leaveBalance: currentLeaveBalance } = user;
        const { balance: adjustedBalance } = this.props.userForm;
        if (currentLeaveBalance > adjustedBalance) {
            // deduct request
            api.post('/leaves/deduct', {
                user: user.id,
                amount: adjustedBalance
            }).then(success => {
                const { message, balance } = success.data;
                this.props.updateUserForm({ ...this.props.userForm, loading: false, balance });
                this.setState({ message });
            }).catch(failed => {
                this.props.updateUserForm({ ...this.props.userForm, loading: false });
                this.setState({ errors: [...this.state.errors, failed.response.data.message] });
            });
        } else if (currentLeaveBalance < adjustedBalance) {
            api.post('/leaves/add', {
                user: user.id,
                amount: adjustedBalance
            }).then(success => {
                const { message, balance } = success.data;
                this.props.updateUserForm({ ...this.props.userForm, loading: false, balance });
                this.setState({ message });
            }).catch(failed => {
                this.props.updateUserForm({ ...this.props.userForm, loading: false });
                this.setState({ errors: [...this.state.errors, failed.response.data.message] });
            });
        }
        this.props.updateUserForm({ ...this.props.userForm, loading: false });
    }


    onDetailsChange(e, key) {
        const { userForm } = this.props;
        this.props.updateUserForm({ ...userForm, [key]: e.target.value });
    }

    renderBalanceForm() {
        if (this.isAdmin()) {
            return (
                <div className="flex flex-row space-x-2 items-center">
                    <Field name="balance" type="number" label="Balance" onChange={(e) => this.onLeaveBalanceChange(e)} value={this.props.userForm.balance} />
                    <div className="mt-6">
                        {this.renderLeaveAdjustmentSubmitButton()}
                    </div>
                </div>
            )
        }
    }

    render() {
        if (this.state.loading) {
            return (
                <Page className="flex flex-col justify-center space-y-2">
                    <Card className="w-full lg:w-1/2 self-center pointer-cursor">
                        <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
                    </Card>
                </Page>
            )
        }
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col space-y-4 w-full md:w-2/3 self-center pointer-cursor">
                    {this.renderErrors()}
                    {this.state.message ? <InfoMessage text={this.state.message} /> : null}
                    <div className="flex flex-row justify-between items-center">
                        <div className="flex flex-row space-x-1">
                            <div>
                                <UserBadge user={this.props?.user} />
                            </div>
                            {this.props?.user.isAdmin ? (<div className="bg-purple-500 bg-opacity-25 text-purple-500 text-xs px-2 rounded-full py-1">Admin</div>) : null}
                        </div>
                        <div>
                            <Button type="soft" onClick={(e) => this.logout()}>
                                <div className="flex space-x-1 items-center">
                                    <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-gray-600 h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink">
                                        <g fill="none"><use xlinkHref="#a"></use>
                                            <path strokeLinecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.86 12h10.14"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.864 19.981l-4.168.019c-1.195.006-2.167-.952-2.167-2.135v-11.73c0-1.179.965-2.135 2.157-2.135h4.314"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 16l4-4 -4-4"></path>
                                            <use xlinkHref="#a"></use>
                                        </g>
                                    </svg>
                                    <span className="text-gray-600">Logout</span>
                                </div>
                            </Button>
                        </div>
                    </div>
                </Card>

                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-2/3 w-full self-center">
                    <UserLeaveSummary user={this.props?.user} />
                </div>

                <Card className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-2/3 w-full self-center">
                    <Field name="name" value={this.props.userForm?.name} onChange={(e) => this.onDetailsChange(e, 'name')} label="Your name" errors={this.props.userForm.errors?.name} />
                    <Field name="job_position" value={this.props.userForm?.jobPosition} onChange={(e) => this.onDetailsChange(e, 'jobPosition')} label="Job Position" errors={this.props.userForm.errors?.job_position} />

                </Card>

            </Page>
        );
    }
}

const mapStateToProps = (state) => {
    const { user, userForm } = state;
    return {
        user,
        userForm
    }
}


export default connect(mapStateToProps, { unsetAuthenticated, updateUserForm, clearUserForm })(ProfilePage);