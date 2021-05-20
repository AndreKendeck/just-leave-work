import React from 'react';
import Card from '../../Card';
import Heading from '../../Heading';
import Page from '../../Page';
import "react-datepicker/dist/react-datepicker.css";
import DatePicker from '../../Form/DatePicker';
import Dropdown from '../../Form/Dropdown';
import { connect } from 'react-redux';
import Field from '../../Form/Field';

const CreateLeavePage = class CreateLeavePage extends React.Component {

    state = {
        error: null,
        message: null,
        reasons: [],
        from: { value: null, errors: [], hasError: false },
        until: { value: null, errors: [], hasError: false },
        description: { value: null, errors: [], hasError: false }
    }

    

    setFromDate = (date) => {
        this.setState(state => {
            return {
                ...state,
                from: {
                    ...state.from,
                    value: date,
                }
            }
        })
    }

    setUntilDate = (date) => {
        this.setState(state => {
            return {
                ...state,
                until: {
                    ...state.until,
                    value: date,
                }
            }
        })
    }

    mapReasons = () => {
        return this.props.reasons?.map(reason => {
            return {
                value: reason.id,
                label: reason.name
            }
        });
    }

    render() {
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <Heading>Apply</Heading>
                    <Dropdown label="Reason" options={this.mapReasons()} />
                    <DatePicker value={this.state.from.value}
                        hasError={this.state.from.hasError} errors={this.state.from.errors} label="Take leave from"
                        className="form-input" onChange={(date) => { this.setFromDate(date); }} />
                    <DatePicker value={this.state.until.value}
                        hasError={this.state.until.hasError} errors={this.state.until.errors} label="Until"
                        className="form-input" onChange={(date) => { this.setUntilDate(date); }} />
                    <Field type="text" label="Description" name="description" />
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