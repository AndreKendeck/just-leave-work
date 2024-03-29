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
import UserLeaveSummary from '../UserLeaveSummary';
import Field from '../Form/Field';
import Table from '../Table';
import moment from 'moment';
import Paginator from '../Paginator';
import UserRoleBadge from '../UserRoleBadge';
import { setUser } from '../../actions/user';
import { setErrorMessage, setMessage } from '../../actions/messages';
import Dropdown from '../Form/Dropdown';

const ProfilePage = class ProfilePage extends React.Component {

    state = {
        loading: false,
        errors: [],
        message: null,
        transactions: {},
        export: {
            year: moment().year(),
            month: moment().month()
        }
    }


    getMonthCollection() {
        const months = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        const currentMonth = moment().month();
        return months.map((month, key) => {
            return {
                value: month,
                label: moment().month(month).format('MMM'),
                selected : currentMonth == month ? true : false
            }
        })
    }

    getYearCollection() {
        const years = [0, 1, 2, 3, 4, 5];
        return years.map(year => {
            return {
                value: moment().subtract('years', year).format('YYYY'),
                label: moment().subtract('years', year).format('YYYY'),
            }
        })
    }

    updateExportForm(e, key) {
        const { value } = e.target;
        this.setState(state => {
            return {
                ...state,
                export: {
                    ...state.export,
                    [key]: value
                }
            }
        })
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
                    this.props.setErrorMessage(message);
                    this.setState({ loading: false });
                });
        }, 1500);

    }

    getNumberClass(number) {
        if (number == 0) {
            return 'text-gray-600';
        }
        if (number < 0) {
            return 'text-red-600';
        }

        return 'text-green-500';
    }

    renderTransactions() {
        return this.state.transactions?.data?.map((transaction, index) => {
            return (
                <tr className="rounded" key={index}>
                    <td className="text-center text-gray-600 text-sm"> {moment(transaction.createdAt).format('l')} </td>
                    <td className="text-center text-gray-600 text-sm"> {transaction.description} </td>
                    <td className="text-center text-gray-600 text-sm">
                        <span className={`${this.getNumberClass(transaction.amount)}`}>
                            {transaction.amount}
                        </span>
                    </td>
                </tr>
            )
        });
    }

    componentDidMount() {
        const { user } = this.props;
        const { name, leaveBalance } = this.props.user;
        this.props.updateUserForm({ name, balance: leaveBalance, jobPosition: user.jobPosition });
        this.getTransactions(1);
    }

    getTransactions(page = 1) {
        const { user } = this.props;
        const config = {
            params: {
                page
            }
        }
        api.get(`/transactions/${user.id}`, config)
            .then(success => {
                const data = success.data;
                this.setState({ transactions: data });
            }).catch(failed => {
                const { message } = failed.response.data;
                this.props.setErrorMessage(message);
            })
    }

    isAdmin() {
        const { user } = this.props;
        return user?.isAdmin;
    }


    onLeaveBalanceChange(e) {
        e.persist();
        const { userForm } = this.props;
        let balance = Number(e.target.value);
        if (isNaN(balance)) {
            balance = 0;
        }
        this.props.updateUserForm({ ...userForm, balance });
    }

    leaveBalanceDiffersFromOriginal() {
        return this.props.user?.leaveBalance != this.props.userForm?.balance;
    }

    onBalanceSubmit() {
        if (!this.isAdmin()) {
            return;
        }
        if (!this.leaveBalanceDiffersFromOriginal) {
            return;
        }
        this.props.updateUserForm({ ...this.props.userForm, loading: true });
        const { user } = this.props;
        const { leaveBalance: currentLeaveBalance } = user;
        const { balance: adjustedBalance } = this.props.userForm;
        let url = null;
        if (currentLeaveBalance > adjustedBalance) {
            // deduct request
            url = '/leaves/deduct';
        } else if (currentLeaveBalance < adjustedBalance) {
            // add request
            url = '/leaves/add';
        }

        api.post(url, {
            user: user.id,
            amount: adjustedBalance
        }).then(success => {
            const { message, balance, transaction } = success.data;
            this.props.updateUserForm({ ...this.props.userForm, loading: false, balance });
            this.props.setMessage(message);
            this.setState(state => {
                return {
                    transactions: {
                        ...state.transactions,
                        data: [transaction, ...state.transactions.data]
                    }
                }
            })
        }).catch(failed => {
            const { message } = failed.response.data;
            this.props.updateUserForm({ ...this.props.userForm, loading: false });
            this.props.setErrorMessage(message);
        });

        this.props.updateUserForm({ ...this.props.userForm, loading: false });
    }


    onDetailsChange(e, key) {
        const { userForm } = this.props;
        this.props.updateUserForm({ ...userForm, [key]: e.target.value });
    }

    renderBalanceForm() {
        if (this.isAdmin()) {
            return (
                <div className="flex flex-row space-x-2 items-center w-full">
                    <Field name="balance" type="number" step=".25" label="Balance" onChange={(e) => this.onLeaveBalanceChange(e)} value={this.props.userForm.balance} />
                </div>
            )
        }
    }

    onProfileUpdate() {
        this.setState({ message: null });
        const { name, jobPosition } = this.props.userForm;
        this.props.updateUserForm({ ...this.props.userForm, loading: true });
        api.put('/profile', { name, job_position: jobPosition })
            .then(success => {
                const { message } = success.data;
                this.props.setMessage(message);
            }).catch(failed => {
                // const { status } = failed?.response;
                // const { errors, message } = failed?.response.data;
                // if (status === 422) {
                //     this.props.updateUserForm({ ...this.props.userForm, errors });
                // } else {
                //     this.props.setErrorMessage(message);
                // }
            });
        if (this.leaveBalanceDiffersFromOriginal()) {
            this.onBalanceSubmit();
        }
        this.props.updateUserForm({ ...this.props.userForm, loading: false });
    }

    onTransactionsExport() {
        const { user } = this.props;
        const { month, year } = this.state.export;
        this.setState({ loading: true });
        api.get(`/transactions/export/${user.id}/${month}/${year}`)
            .then(success => {
                this.setState({ loading: false });
                const { file } = success.data;
                window.location = file;
            }).catch(failed => {
                this.setState({ loading: false });
                const { message } = failed.response.data;
                this.props.setErrorMessage(message);
            });
    }

    renderExportForm() {
        if (this.isAdmin()) {
            return (
                <div className="flex flex-row space-x-2 items-center">
                    <Dropdown options={this.getMonthCollection()} label="Month" name="month"  onChange={(e) => this.updateExportForm(e, 'month')} />
                    <Dropdown options={this.getYearCollection()} label="Year" name="year" onChange={(e) => this.updateExportForm(e, 'year')} />
                    <div className="mt-6"><Button type="soft" onClick={(e) => this.onTransactionsExport()} >Export</Button></div>
                </div>
            )
        }
        return null;
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
                    <div className="flex flex-row justify-between items-center">
                        <div className="flex flex-row space-x-2">
                            <div>
                                <UserBadge user={this.props?.user} />
                            </div>
                            <div>
                                <UserRoleBadge user={this.props?.user} />
                            </div>
                        </div>
                        <div>
                            <Button type="soft" onClick={(e) => this.logout()}>
                                <div className="flex space-x-1 items-center">
                                    <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-gray-700 h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink">
                                        <g fill="none"><use xlinkHref="#a"></use>
                                            <path strokeLinecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.86 12h10.14"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.864 19.981l-4.168.019c-1.195.006-2.167-.952-2.167-2.135v-11.73c0-1.179.965-2.135 2.157-2.135h4.314"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 16l4-4 -4-4"></path>
                                            <use xlinkHref="#a"></use>
                                        </g>
                                    </svg>
                                    <span className="text-gray-700">Logout</span>
                                </div>
                            </Button>
                        </div>
                    </div>
                </Card>
                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-2/3 w-full self-center">
                    <UserLeaveSummary user={this.props?.user} />
                </div>

                <Card className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-2/3 w-full self-center items-center">
                    <Field name="name" value={this.props.userForm?.name} onChange={(e) => this.onDetailsChange(e, 'name')} label="Your name" errors={this.props.userForm.errors?.name} />
                    <Field name="job_position" value={this.props.userForm?.jobPosition} onChange={(e) => this.onDetailsChange(e, 'jobPosition')} label="Job position" errors={this.props.userForm.errors?.job_position} />
                    {this.renderBalanceForm()}
                    <div className="w-full p-2 flex flex-col self-end">
                        {this.props.userForm?.loading ? <Loader type="Oval" className="self-center" height={30} width={30} color="Gray" /> : <Button type="soft" onClick={(e) => this.onProfileUpdate()} >Update</Button>}
                    </div>
                </Card>

                <Card className="hidden md:flex w-full md:w-2/3 self-center items-center flex-col space-y-2">
                    <div className="flex flex-row w-full items-center justify-between">
                        <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs self-start">Transactions</span>
                        {this.renderExportForm()}
                    </div>
                    <Table headings={['Date', 'Description', 'Amount']} >
                        {this.renderTransactions()}
                    </Table>
                    <Paginator onNextPage={() => this.getTransactions((this.state.transactions.currentPage + 1))}
                        onPreviousPage={() => this.getTransactions((this.state.transactions.currentPage - 1))}
                        onPageSelect={(page) => this.getTransactions(page)}
                        onLastPage={this.state.transactions.to === this.state.transactions.currentPage}
                        onFirstPage={this.state.transactions.currentPage === 1}
                        activePage={this.state.transactions.currentPage}
                        numberOfPages={this.state.transactions.to} />
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


export default connect(mapStateToProps, { unsetAuthenticated, updateUserForm, clearUserForm, setUser, setErrorMessage, setMessage })(ProfilePage);