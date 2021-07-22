import React from 'react';
import Card from '../../Card';
import Heading from '../../Heading';
import Page from '../../Page';
import DatePicker from '../../Form/DatePicker';
import Dropdown from '../../Form/Dropdown';
import { connect } from 'react-redux';
import Field from '../../Form/Field';
import Button from '../../Button';
import Loader from 'react-loader-spinner';
import api from '../../../api';
import ErrorMessage from '../../ErrorMessage';
import InfoMessage from '../../InfoMessage';
import moment from 'moment';

const CreateLeavePage = class CreateLeavePage extends React.Component {

    state = {
        error: null,
        message: null,
        isSending: false,
        reasons: [],
        dates: { startDate: null, endDate: null, key: 'selection' },
        description: { value: null, errors: [], hasError: false },
        reason: { value: null, errors: [], hasError: false },
        users: [],
        notifyUser: { value: null, errors: [], hasError: false },
        from: { errors: [] },
        until: { errors: [] }
    }


    componentDidMount() {
        api.get('/team/admins').
            then(success => {
                this.setState({ users: success.data });
            }).catch(failed => {
                this.setState({ error: failed.response.data.error });
            });
    }


    setFromDate = (value) => {
        console.log(value);
        this.setState(state => {
            return {
                ...state,
                from: {
                    value: moment(value).format('L')
                }
            }
        });

    }


    setDescription = (e) => {
        e.persist();
        this.setState(state => {
            return {
                ...state,
                description: {
                    value: e.target.value
                }
            }
        });
    }

    mapReasons = () => {
        const reasons = [{ id: 0, name: '' }, ...this.props.reasons];
        return reasons?.map(reason => {
            return {
                value: reason.id,
                label: reason.name
            }
        });
    }

    onReasonChange = (e) => {
        e.persist();
        this.setState(state => {
            return {
                ...state,
                reason: {
                    value: e.target.value
                }
            }
        })
    }

    storeLeavePost = () => {
        this.setState({ isSending: true });
        const { reason: { value: reason },
            description: { value: description } } = this.state;

        const from = moment(this.state.dates.startDate).format('l');
        const until = moment(this.state.dates.endDate).format('l');

        api.post('/leaves', { from, until, description, reason })
            .then(success => {
                this.setState({ isSending: false });
                const { message } = success.data;
                this.setState({ message: message });

            }).catch(failed => {
                this.setState({ isSending: false });
                if (failed.response.status == 422) {
                    const { errors } = failed.response.data;
                    for (const key in errors) {
                        this.setState(state => {
                            return {
                                ...state,
                                [key]: {
                                    ...state[key],
                                    errors: errors[key]
                                }
                            }
                        })
                    }
                    return;
                }
                this.setState({ error: failed.response.data.message });
            });
    }

    onNotifyUserChange = (e) => {
        e.persist();
        this.setState(state => {
            return {
                ...state,
                notifyUser: {
                    value: e.target.value
                }
            }
        });
    }

    mapNotifiableUsers() {
        let users = [...this.state.users, { value: null, label: '' }];
        return users?.map(user => {
            return {
                value: user.id,
                label: user.name
            }
        });
    }

    render() {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-end">Leave application</span>
                    <Dropdown errors={this.state.reason.errors} onChange={(e) => this.onReasonChange(e)} label="Reason" options={this.mapReasons()} />
                    <DatePicker
                        errors={[this.state.from.errors, this.state.until.errors]}
                        label="Starting Date"
                        className="form-input"
                        months={2}
                        onChange={(ranges) => { this.setState({ dates: ranges }) }} />

                    <Field type="text" label="Description" name="description" errors={this.state.description.errors} onKeyUp={(e) => this.setDescription(e)} />
                    <Dropdown errors={this.state.notifyUser.errors}
                        label="Notify - Optional"
                        name="notifyUser"
                        errors={this.state.notifyUser.errors}
                        options={this.mapNotifiableUsers()}
                        onChange={(e) => { this.onNotifyUserChange(e) }} />
                    {this.state.isSending ? <Loader type="Oval" className="self-center" height={50} width={50} color="Gray" /> : (
                        <Button type="secondary" onClick={e => this.storeLeavePost()} >Send</Button>
                    )}
                    {this.state.error ? <ErrorMessage text={this.state.error} onDismiss={e => this.setState({ error: null })} /> : null}
                    {this.state.message ? <InfoMessage text={this.state.message} onDismiss={e => this.setState({ message: false })} /> : null}
                </Card>
            </Page>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        reasons: state.reasons
    }
}

export default connect(mapStateToProps, null)(CreateLeavePage);