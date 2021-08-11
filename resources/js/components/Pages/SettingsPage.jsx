import moment from 'moment';
import React from 'react';
import { connect } from 'react-redux';
import { updateSettingsForm } from '../../actions/forms/settings';
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
            this.setState({ message });
        }).catch(failed => {
            const { message, errors } = failed.response.data;
            if (failed.response.status == 422) {
                this.props.updateSettingsForm({ ...settingsForm, errors });
            } else {
                this.setState({ errors: [...this.state.errors, message] });
            }
        });
        this.props.updateSettingsForm({ ...settingsForm, loading: false });
    }

    renderMessage() {
        const { message } = this.state;
        if (message) {
            return <InfoMessage text={message} onDismiss={(e) => this.setState({ message: null })} />
        }
    }

    renderErrorMessages() {
        return this.state.errors?.map((error, index) => {
            return <ErrorMessage text={error} key={index} onDismiss={(e) => {
                let { errors } = this.state;
                errors.filter((err, idx) => idx !== index);
            }} />
        });
    }

    getSaveButtonState() {
        const { settingsForm } = this.state;
        if (settingsForm?.loading) {
            return <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
        }
        return <Button type="secondary" onClick={(e) => this.onSave()}>Save</Button>;
    }

    render() {
        const { leaveAddedPerCycle, daysUntilBalanceAdded, excludedDays, errors } = this.props.settingsForm;

        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col space-y-4 w-full lg:w-1/2 self-center pointer-cursor">
                    {this.renderMessage()}
                    {this.renderErrorMessages()}
                    <div className="flex flex-row w-full items-center justify-between">
                        <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs ">Settings</span>
                        <span className="text-white bg-gray-700 px-2 py-1 text-center rounded-full text-xs self-start"> Last balance adjustment : {moment(this.props.settings?.lastLeaveBalanceAddedAt).fromNow()}</span>
                    </div>
                    <Field type="number" name="leaveAddedPerCycle" hasError={errors?.leave_added_per_cycle?.length > 0}
                        errors={errors?.leave_added_per_cycle} step="0.25" value={leaveAddedPerCycle}
                        onChange={(e) => this.onSettingsChange(e, 'leaveAddedPerCycle')} label="Leave Added Per Cycle"
                        tip="Eg. Leave Balance added after 10,20 or 30 days" />
                    <Field type="number" name="daysUntilBalanceAdded"
                        hasError={errors?.days_until_balance_added?.length > 0}
                        errors={errors?.days_until_balance_added}
                        onChange={(e) => this.onSettingsChange(e, 'daysUntilBalanceAdded')}
                        value={daysUntilBalanceAdded} label="Days until balance added"
                        tip="Add leave after these days" />
                    {this.getSaveButtonState()}
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

export default connect(mapStateToProps, { updateSettingsForm, setSettings })(SettingPage);