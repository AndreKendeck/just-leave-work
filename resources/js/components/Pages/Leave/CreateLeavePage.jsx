import React from 'react';
import Card from '../../Card';
import Page from '../../Page';
import DatePicker from '../../Form/DatePicker';
import Dropdown from '../../Form/Dropdown';
import { connect } from 'react-redux';
import Button from '../../Button';
import Loader from 'react-loader-spinner';
import api from '../../../api';
import ErrorMessage from '../../ErrorMessage';
import InfoMessage from '../../InfoMessage';
import moment from 'moment';
import { clearLeaveForm, updateLeaveForm } from '../../../actions/forms/leave';

const CreateLeavePage = class CreateLeavePage extends React.Component {

    state = {
        error: null,
        message: null,
        reasons: [],
        users: [],
    }


    componentDidMount() {
        api.get('/team/admins').
            then(success => {
                this.setState({ users: success.data });
            }).catch(failed => {
                const { message } = failed.response.data.message;
                this.setState({ error: message });
            });
    }

    onFormChange(e, key) {
        e.persist();
        const { leaveForm } = this.props;
        this.props.updateLeaveForm({ ...leaveForm, [key]: e.target.value });
    }

    onDateChange(ranges) {
        const { leaveForm } = this.props;
        this.props.updateLeaveForm({ ...leaveForm, dates: ranges });
    }

    mapReasons = () => {
        const reasons = [{ id: 0, name: 'Select a reason' }, ...this.props.reasons];
        return reasons?.map(reason => {
            return {
                value: reason.id,
                label: reason.name
            }
        });
    }

    storeLeavePost = () => {
        this.setState({ isSending: true });
        const { reason: { value: reason },
            description: { value: description }, notifyUser: { value: notifyUser } } = this.state;

        const from = moment(this.state.dates.startDate).format('l');
        const until = moment(this.state.dates.endDate).format('l');

        api.post('/leaves', { from, until, description, reason, notifyUser })
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

    mapNotifiableUsers() {
        let users = [{ id: 0, name: 'Select a user' }, ...this.state.users,];
        return users?.map(user => {
            return {
                value: user.id,
                label: user.name
            }
        });
    }

    renderHalfDayCheckbox() {

    }

    render() {
        const { notifyUser } = this.props.leaveForm;
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-end">Leave application</span>
                    <Dropdown errors={this.state.reason.errors} onChange={(e) => this.onFormChange(e, 'reason')} label="Reason" options={this.mapReasons()} />
                    <DatePicker
                        errors={[this.state.from.errors, this.state.until.errors]}
                        label="Starting Date"
                        className="form-input"
                        months={2}
                        onChange={(ranges) => { this.onDateChange(ranges) }} />
                    <Dropdown errors={this.state.notifyUser.errors}
                        label="Notify - Optional"
                        name="notifyUser"
                        errors={this.state.notifyUser.errors}
                        value={this.prop}
                        options={this.mapNotifiableUsers()}
                        onChange={(e) => { this.onFormChange(e, 'notifyUser') }} />
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
    const { reasons, leaveForm } = state;
    return {
        reasons
    }
}

export default connect(mapStateToProps, { updateLeaveForm, clearLeaveForm })(CreateLeavePage);