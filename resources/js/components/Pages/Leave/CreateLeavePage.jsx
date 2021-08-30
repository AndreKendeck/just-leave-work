import React from 'react';
import Card from '../../Card';
import Page from '../../Page';
import DatePicker from '../../Form/DatePicker';
import Dropdown from '../../Form/Dropdown';
import { connect } from 'react-redux';
import Button from '../../Button';
import Loader from 'react-loader-spinner';
import api from '../../../api';
import moment from 'moment';
import { clearLeaveForm, updateLeaveForm } from '../../../actions/forms/leave';
import Checkbox from '../../Form/Checkbox';
import { setErrorMessage, setMessage } from '../../../actions/messages';

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
                this.props.setErrorMessage(message);
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

    mapReasons() {
        const reasons = [{ id: 0, name: 'Select a reason' }, ...this.props.reasons];
        return reasons?.map(reason => {
            return {
                value: reason.id,
                label: reason.name
            }
        });
    }

    storeLeavePost() {

        const { reason, dates, notifyUser, halfDay } = this.props.leaveForm;
        moment().locale('en-gb');
        const from = moment(dates.startDate).format();
        const until = moment(dates.endDate).format();
        let halfDayOff = halfDay;
        if ((dates.startDate !== dates.endDate) && halfDay) {
            halfDayOff = false;
        }
        this.props.updateLeaveForm({ ...this.props.leaveForm, loading: true });
        api.post('/leaves', { from, until, reason, notifyUser, halfDay: halfDayOff })
            .then(success => {
                const { message } = success.data;
                this.props.setMessage(message);
                this.props.updateLeaveForm({ ...this.props.leaveForm, loading: false });
                this.props.clearLeaveForm();
            }).catch(failed => {
                const { status } = failed.response;
                const { errors, message } = failed.response.data;
                if (status === 422) {
                    this.props.updateLeaveForm({ ...this.props.leaveForm, errors });
                } else {
                    this.props.setErrorMessage(message);
                }
                this.props.updateLeaveForm({ ...this.props.leaveForm, loading: false });
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


    render() {
        const { notifyUser, dates, loading, halfDay, errors } = this.props.leaveForm;
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-end">Leave application</span>
                    <Dropdown errors={errors?.reason} onChange={(e) => this.onFormChange(e, 'reason')} label="Reason" options={this.mapReasons()} />
                    <DatePicker
                        errors={[errors?.from, errors?.until]}
                        label="Starting Date"
                        className="form-input"
                        months={2}
                        value
                        onChange={(ranges) => { this.onDateChange(ranges) }} />
                    {(dates.startDate === dates.endDate) ? <Checkbox checked={halfDay} onChange={(e) => {
                        let { leaveForm } = this.props;
                        this.props.updateLeaveForm({ ...leaveForm, halfDay: !leaveForm.halfDay });
                    }} label="Taking a half day" name="halfDay" /> : null}
                    <Dropdown errors={errors?.notifyUser}
                        label="Notify - Optional"
                        name="notifyUser"
                        errors={errors?.notifyUser}
                        value={notifyUser}
                        options={this.mapNotifiableUsers()}
                        onChange={(e) => { this.onFormChange(e, 'notifyUser') }} />
                    {loading ? <Loader type="Oval" className="self-center" height={50} width={50} color="Gray" /> : (
                        <Button onClick={e => this.storeLeavePost()} >Send</Button>
                    )}
                </Card>
            </Page>
        );
    }
}

const mapStateToProps = (state) => {
    const { reasons, leaveForm } = state;
    return {
        reasons,
        leaveForm
    }
}




export default connect(mapStateToProps, { updateLeaveForm, clearLeaveForm, setMessage, setErrorMessage })(CreateLeavePage);