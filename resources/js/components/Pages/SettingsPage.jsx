import moment from 'moment';
import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { updateSettingsForm } from '../../actions/forms/settings';
import { setErrorMessage, setMessage } from '../../actions/messages';
import { setSettings } from '../../actions/settings';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import ErrorMessage from '../ErrorMessage';
import Field from '../Form/Field';
import InfoMessage from '../InfoMessage';
import Page from '../Page';

const SettingPage = class SettingPage extends React.Component {

    state = {
        message: null,
        errors: [],
        day: null,
    }

    componentDidMount() {
        const { leaveAddedPerCycle, daysUntilBalanceAdded, excludedDays } = this.props.settings;
        const { settingsForm } = this.props;
        this.props.updateSettingsForm({
            ...settingsForm,
            leaveAddedPerCycle,
            daysUntilBalanceAdded,
            excludedDays
        });
    }
    onSettingsChange(e, key) {
        e.persist();
        const { settingsForm } = this.props;
        this.props.updateSettingsForm({ ...settingsForm, [key]: e.target.value });
    }

    onSave() {
        const { settingsForm } = this.props;
        const { leaveAddedPerCycle, daysUntilBalanceAdded } = settingsForm;
        this.props.updateSettingsForm({ ...settingsForm, loading: true });
        api.put('/settings', {
            leave_added_per_cycle: leaveAddedPerCycle,
            days_until_balance_added: daysUntilBalanceAdded
        }).then(success => {
            const { message, settings } = success.data;
            this.props.setSettings(settings);
            this.props.setMessage(message);
            this.props.updateSettingsForm({ ...settingsForm, loading: false });
        }).catch(failed => {
            const { message, errors } = failed.response.data;
            if (failed.response.status == 422) {
                this.props.updateSettingsForm({ ...settingsForm, errors });
            } else {
                this.props.setErrorMessage(message);
            }
            this.props.updateSettingsForm({ ...settingsForm, loading: false });
        });
    }

    getSaveButtonState() {
        const { settingsForm } = this.props;
        if (settingsForm?.loading) {
            return <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
        }
        return <Button type="secondary" onClick={(e) => this.onSave()}>Save</Button>;
    }


    onDayChange(e) {
        e.persist();
        const day = e.target.value;
        this.setState({ day });
    }

    onDayAdd() {
        const { settingsForm } = this.props;
        const { excludedDays } = settingsForm;
        const { day } = this.state;
        api.post('/excluded-days', { day })
            .then(success => {

                this.props.updateSettingsForm({ ...settingsForm, excludedDays: [...day, excludedDays] });
            }).catch(failed => {

            });

    }

    render() {
        const { leaveAddedPerCycle, daysUntilBalanceAdded, excludedDays, errors } = this.props.settingsForm;

        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col space-y-4 w-full lg:w-1/2 self-center pointer-cursor">
                    <div className="flex flex-row w-full items-center justify-between">
                        <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs ">Settings</span>
                        <span className="text-white bg-gray-700 px-2 py-1 text-center rounded-full text-xs self-start"> Last balance adjustment : {moment(this.props.settings?.lastLeaveBalanceAddedAt).fromNow()}</span>
                    </div>
                    <Field type="number" name="leaveAddedPerCycle" hasError={errors?.leave_added_per_cycle?.length > 0}
                        errors={errors?.leave_added_per_cycle} step="0.25" value={leaveAddedPerCycle}
                        onChange={(e) => this.onSettingsChange(e, 'leaveAddedPerCycle')} label="Leave Added Per Cycle"
                        tip="Number of leave days added at the end of a cycle" />
                    <Field type="number" name="daysUntilBalanceAdded"
                        hasError={errors?.days_until_balance_added?.length > 0}
                        errors={errors?.days_until_balance_added}
                        onChange={(e) => this.onSettingsChange(e, 'daysUntilBalanceAdded')}
                        value={daysUntilBalanceAdded} label="Days until balance added"
                        tip="Cycle days" />
                    {this.getSaveButtonState()}
                </Card>
                <Card className="flex flex-col space-y-4 w-full lg:w-1/2 self-center pointer-cursor">
                    <div className="flex flex-row w-full items-center justify-between">
                        <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs ">Excluded Days</span>
                    </div>
                    <div className="flex flex-row space-x-2 items-center">
                        <Field name="day" label="Add day" tip="Monday or 01/01/2021" />
                        <div class="w-1/2 md:w-1/4">
                            <Button type="soft" onClick={(e) => this.onDayAdd()} >Add</Button>
                        </div>
                    </div>
                    <div className="w-full overflow-auto space-y-2 flex flex-col" style={{ height: '350px' }}>
                        {this.props.settings.excludedDays.map(day => {
                            return (
                                <div className="flex flex-row p-3 justify-between items-center">
                                    <div className="text-gray-700 text-base">{day}</div>
                                    <div>
                                        <Button type="soft" onClick={(e) => this.onDayDelete(day.id)} >
                                            <svg version="1.1" className="stroke-current h-4 w-4 text-gray-800" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <g fill="none">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 8l8 8"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8l-8 8"></path>
                                                </g>
                                            </svg>
                                        </Button>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </Card>
            </Page>
        )
    }

}

const mapStateToProps = (state) => {
    const { settingsForm, settings } = state;
    return {
        settings,
        settingsForm
    }
}

export default connect(mapStateToProps, { updateSettingsForm, setSettings, setMessage, setErrorMessage })(SettingPage);