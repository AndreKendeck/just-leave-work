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

        const { reason, dates, halfDay } = this.props.leaveForm;
        moment().locale('en-gb');
        const from = moment(dates.startDate).format();
        const until = moment(dates.endDate).format();
        let halfDayOff = halfDay;
        if ((dates.startDate !== dates.endDate) && halfDay) {
            halfDayOff = false;
        }
        this.props.updateLeaveForm({ ...this.props.leaveForm, loading: true });
        api.post('/leaves', { from, until, reason, halfDay: halfDayOff })
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

    render() {
        const { dates, loading, halfDay, errors } = this.props.leaveForm;
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-center">Leave application</span>
                    <DatePicker
                        errors={[errors?.from, errors?.until]}
                        className="form-input"
                        months={2}
                        onChange={(ranges) => { this.onDateChange(ranges) }} />
                    <div>
                        <Dropdown errors={errors?.reason} onChange={(e) => this.onFormChange(e, 'reason')} options={this.mapReasons()} />
                    </div>
                    {loading ? <Loader type="Oval" className="self-center" height={50} width={50} color="Gray" /> : (
                        <div className="w-full md:w-1/4 self-start">
                            <Button onClick={e => this.storeLeavePost()} >Save Application</Button>
                        </div>
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