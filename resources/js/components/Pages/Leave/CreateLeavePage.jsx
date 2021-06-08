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
import Checkbox from '../../Form/Checkbox';

const CreateLeavePage = class CreateLeavePage extends React.Component {

    state = {
        error: null,
        message: null,
        isSending: false,
        reasons: [],
        from: { value: null, errors: [], hasError: false },
        until: { value: null, errors: [], hasError: false },
        description: { value: null, errors: [], hasError: false },
        reason: { value: null, errors: [], hasError: false },
        users: [],
        notifyUser: { value: null, errors: [], hasError: false },
        onlyOneDay: false,
    }


    componentDidMount() {
        api.get('/team/approvers-and-deniers').
            then(success => {
                this.setState({ users: success.data });
            }).catch(failed => {
                this.setState({ error: failed.response.data.error });
            });
    }


    setFromDate = (value) => {
        
        this.setState(state => {
            return {
                ...state,
                from: {
                    value: value
                }
            }
        });

        if (this.state.onlyOneDay) {
            this.setUntilDate(value);
        }

    }

    setUntilDate = (value) => {
        this.setState(state => {
            return {
                ...state,
                until: {
                    value: value
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
        console.log(e);
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
        const {
            from: { value: from },
            reason: { value: reason },
            until: { value: until },
            description: { value: description } } = this.state;

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

    getJavascriptDateForCalendar = (date) => {
        const result = moment(date);
        if (result.isValid()) {
            return result.toDate();
        }
        return moment().toDate();
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
        console.log(this.state);
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <Heading>Apply for leave.</Heading>
                    <Dropdown errors={this.state.reason.errors} onChange={(e) => this.onReasonChange(e)} label="Reason" options={this.mapReasons()} />
                    <div className="flex flex-col lg:flex-row w-full space-y-2 lg:space-y-0 lg:space-x-4">

                        <div className="flex flex-col space-y-2 ">
                            <DatePicker value={this.getJavascriptDateForCalendar(this.state.from.value)}
                                errors={this.state.from.errors}
                                label="First day of leave"
                                className="form-input"
                                onChange={(date) => { this.setFromDate(date) }} />

                            <Checkbox name="onlyOneDay" label="Only for the day"
                                onChange={(e) => {
                                    this.setState({ onlyOneDay: !this.state.onlyOneDay });
                                    if (this.state.onlyOneDay) {
                                        this.setUntilDate(this.state.from.value);
                                    }
                                }} />
                        </div>

                        {this.state.onlyOneDay ? null : (<DatePicker value={this.getJavascriptDateForCalendar(this.state.until.value)}
                            errors={this.state.until.errors}
                            label="Last day of leave"
                            className="form-input"
                            onChange={(date) => { this.setUntilDate(date) }} />)}
                    </div>
                    <Field type="text" label="Description" name="description" errors={this.state.description.errors} onKeyUp={(e) => this.setDescription(e)} />
                    <Dropdown errors={this.state.notifyUser.errors}
                        label="Notify - Optional"
                        name="notifyUser"
                        errors={this.state.notifyUser.errors}
                        options={this.mapNotifiableUsers()}
                        onChange={(e) => { this.onNotifyUserChange(e) }} />
                    {this.state.isSending ? <Loader type="Oval" className="self-center" height={50} width={50} color="Gray" /> : (
                        <Button onClick={e => this.storeLeavePost()} >Send</Button>
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