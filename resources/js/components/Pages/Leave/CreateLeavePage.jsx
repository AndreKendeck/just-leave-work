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

    setDescription = (e) => {
        e.persist();
        this.setState(state => {
            return {
                ...state,
                description: {
                    ...state.description,
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
            until: { value: until },
            reason: { value: reason },
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
                this.setState({ error: failed.response.message });
            });
    }

    render() {
        return (
            <Page className="flex flex-col justify-center justify-center space-y-2">
                <Card className="w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <Heading>Apply</Heading>
                    <Dropdown errors={this.state.reason.errors} onChange={(e) => this.onReasonChange(e)} label="Reason" options={this.mapReasons()} />
                    <DatePicker value={this.state.from.value}
                        hasError={this.state.from.hasError} errors={this.state.from.errors} label="Take leave from"
                        className="form-input" onChange={(date) => { this.setFromDate(date); }} />
                    <DatePicker value={this.state.until.value}
                        hasError={this.state.until.hasError} errors={this.state.until.errors} label="Until"
                        className="form-input" onChange={(date) => { this.setUntilDate(date); }} />
                    <Field type="text" label="Description" name="description" errors={this.state.description.errors} onKeyUp={(e) => this.setDescription(e)} />
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