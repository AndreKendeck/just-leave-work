import moment from 'moment';
import React from 'react';
import { connect } from 'react-redux';
import { updateSettingsForm } from '../../actions/forms/settings';
import { setSettings } from '../../actions/settings';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import Field from '../Form/Field';
import Page from '../Page';


const SettingPage = class SettingPage extends React.Component {

    state = {
        message: null
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
        this.props.updateSettingsForm({ ...settingsForm, [key]: parseInt(e.target.value) });
    }

    onSave() {
        const { settingsForm } = this.props;
        const { leaveAddedPerCycle, daysUntilBalanceAdded } = settingsForm;
        this.props.updateSettingForm({ ...settingsForm, loading: true });
        api.put('/settings', {
            leave_added_per_cycle: leaveAddedPerCycle,
            days_until_balance_added: daysUntilBalanceAdded
        }).then(success => {
            const { message, settings } = success.data;
            this.props.setSettings(settings);
            this.setState({ message });
        }).catch(failed => {
            const { status } = this.props;
        });
        this.props.updateSettingForm({ ...settingsForm, loading: false });
    }

    render() {
        const { leaveAddedPerCycle, daysUntilBalanceAdded, excludedDays } = this.props.settingsForm;
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col space-y-4 w-full lg:w-1/2 self-center pointer-cursor">
                    <div className="flex flex-row w-full items-center justify-between">
                        <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs ">Settings</span>
                        <span className="text-white bg-gray-700 px-2 py-1 text-center rounded-full text-xs self-start"> Last balance adjustment : {moment(this.props.settings?.lastLeaveBalanceAddedAt).fromNow()}</span>
                    </div>
                    <Field type="number" name="leaveAddedPerCycle" value={leaveAddedPerCycle}
                        onChange={(e) => this.onSettingsChange(e, 'leaveAddedPerCycle')} label="Leave Added Per Cycle"
                        tip="Eg. Leave Balance added after 10,20 or 30 days" />
                    <Field type="number" name="daysUntilBalanceAdded"
                        onChange={(e) => this.onSettingsChange(e, 'daysUntilBalanceAdded')}
                        value={daysUntilBalanceAdded} label="Days until balance added"
                        tip="Add leave after these days" />
                    <Button type="primary">Save</Button>
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