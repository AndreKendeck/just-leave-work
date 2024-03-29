import moment from 'moment';
import React, { useState, useEffect } from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { useParams } from 'react-router';
import { setErrorMessage } from '../../../actions/messages';
import api from '../../../api';
import Button from '../../Button';
import Card from '../../Card';
import EditButtonLink from '../../EditButtonLink';
import ErrorMessage from '../../ErrorMessage';
import Dropdown from '../../Form/Dropdown';
import Page from '../../Page';
import Paginator from '../../Paginator';
import Table from '../../Table';
import UserBadge from '../../UserBadge';
import UserLeaveStatusBadge from '../../UserLeaveStatusBadge';
import UserLeaveSummary from '../../UserLeaveSummary';
import UserRoleBadge from '../../UserRoleBadge';
import UserStatusBadge from '../../UserStatusBadge';

const ViewUserPage = (props) => {
    const { id } = useParams();
    const [user, setUser] = useState({});
    const [errors, setErrors] = useState([]);
    const [loading, setLoading] = useState(true);
    const [transactions, setTransactions] = useState({ loading: true });
    const [exportForm, setExportForm] = useState({ year: moment().format('YYYY'), month: moment().format('YYYY') });

    useEffect(() => {
        api.get(`/users/${id}`)
            .then(success => {
                setLoading(false);
                setUser(success.data);
                getTransactions();
            }).catch(failed => {
                setLoading(false);
                const { message } = failed.response.data;
                setErrors([...errors, message]);
            });
    }, []);

    const getNumberClass = (number) => {
        if (number == 0) {
            return 'text-gray-600';
        }
        if (number < 0) {
            return 'text-red-600';
        }

        return 'text-green-500';
    }

    const renderTransactions = () => {
        if (transactions?.loading) {
            return <Loader type="Oval" className="self-center" height={30} width={30} color="Gray" />;
        }
        return transactions?.data?.map((transaction, index) => {
            return (
                <tr className="rounded" key={index}>
                    <td className="text-center text-gray-600 text-sm"> {moment(transaction.createdAt).format('l')} </td>
                    <td className="text-center text-gray-600 text-sm"> {transaction.description} </td>
                    <td className="text-center text-gray-600 text-sm">
                        <span className={`${getNumberClass(transaction.amount)}`}>
                            {transaction.amount}
                        </span>
                    </td>

                </tr>
            )
        });
    }

    const getTransactions = (page = 1) => {
        let config = {
            params: {
                page
            }
        }
        api.get(`/transactions/${id}`, config)
            .then(success => {
                const { data } = success;
                setTransactions({ ...data, loading: false });
            }).catch(failed => {
                let { message } = failed.response.data;
                setErrors([message, ...errors]);
                setTransactions({ loading: false });
            });
    }

    const getMonthCollection = () => {
        const months = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        return months.map((month, key) => {
            return {
                value: month,
                label: moment().month(month).format('MMM')
            }
        })
    }

    const getYearCollection = () => {
        const years = [0, 1, 2, 3, 4, 5];
        return years.map(year => {
            return {
                value: moment().subtract('years', year).format('YYYY'),
                label: moment().subtract('years', year).format('YYYY')
            }
        })
    }

    const updateExportForm = (e, key) => {
        setExportForm({ ...exportForm, [key]: e.target.value });
    }

    /**
     * export the transactions for a specific month and year for theuser
     */
    const onExport = () => {
        setExportForm({ ...exportForm, loading: true });
        const { month, year } = exportForm;
        api.get(`/transactions/export/${user?.id}/${month}/${year}`)
            .then(success => {
                const { file } = success.data;
                setExportForm({ ...exportForm, loading: false });
                window.location = file;
            }).catch(failed => {
                const { message } = failed.response.data;
                setExportForm({ ...exportForm, loading: false });
                props.setErrorMessage(message);
            });
    }

    const renderErrors = () => {
        return errors?.map((error, k) => {
            return <ErrorMessage text={error} onDismiss={(e) => {
                let newErrors = errors;
                newErrors.filter((error, ky) => ky !== k);
            }} />
        });
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

    return (
        <Page className="flex flex-col justify-center space-y-2">
            <div className="w-full md:w-1/2 self-center">
                {renderErrors()}
            </div>
            <Card className="flex flex-col w-full md:w-2/3 self-center space-y-4">
                <div className="flex flex-row items-center justify-between w-full">
                    <div className="flex flex-row space-x-2">
                        <div>
                            <UserBadge user={user} />
                        </div>
                        <div>
                            <UserLeaveStatusBadge user={user} />
                        </div>
                        <div>
                            <UserRoleBadge user={user} />
                        </div>
                        <div>
                            <UserStatusBadge user={user} />
                        </div>
                    </div>
                    <div className="flex flex-row space-x-4">
                        <div className="text-gray-700 flex flex-row space-x-1 items-center">
                            <svg id="Layer_3" className="stroke-current h-6 w-6 text-gray-700" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M14.25,10V8a1,1,0,0,0-1-1h-2.5a1,1,0,0,0-1,1v2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                <rect x="7" y="10" width="10" height="7" rx="1.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                                <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                            <span>{user?.jobPosition}</span>
                        </div>
                        <EditButtonLink url={`/user/edit/${id}`} />
                    </div>
                </div>
            </Card>
            <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-2/3 w-full self-center">
                <UserLeaveSummary user={user} />
            </div>
            <Card className="hidden md:flex md:flex-col w-full md:w-2/3 self-center space-y-4">
                <div className="flex flex-row justify-center w-full items-center">
                    <div className="flex w-full md:w-1/2 flex-col md:flex-row md:space-x-2 space-y-2 md:space-y-0" >
                        <Dropdown options={getMonthCollection()} label="Month" name="month" value={exportForm.month} onChange={(e) => updateExportForm(e, 'month')} />
                        <Dropdown options={getYearCollection()} label="Year" name="year" value={exportForm.year} onChange={(e) => updateExportForm(e, 'year')} />
                        <div className="self-center w-full pt-5">
                            {exportForm?.loading ? <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" /> : (
                                <Button type="soft" onClick={(e) => onExport()} >Export</Button>
                            )}
                        </div>
                    </div>
                </div>
                <Table headings={['Date', 'Description', 'Amount']} >
                    {renderTransactions()}
                </Table>
                <Paginator onNextPage={() => getTransactions((transactions.currentPage + 1))}
                    onPreviousPage={() => getTransactions((transactions.currentPage - 1))}
                    onPageSelect={(page) => getTransactions(page)}
                    onLastPage={transactions.to === transactions.currentPage}
                    onFirstPage={transactions.currentPage === 1}
                    activePage={transactions.currentPage}
                    numberOfPages={transactions.to} />
            </Card>
        </Page>
    )
}


export default connect(null, { setErrorMessage })(ViewUserPage);