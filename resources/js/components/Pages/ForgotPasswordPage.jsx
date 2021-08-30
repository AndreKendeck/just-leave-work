import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import { setErrorMessage, setMessage } from '../../actions/messages';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import Field from '../Form/Field';
import Page from '../Page';

const ForgotPasswordPage = class ForgotPasswordPage extends React.Component {

    state = {
        error: null,
        message: null,
        isSending: false,
        email: { value: '', errors: [], hasError: false },
    }

    onSend = () => {
        this.setState({ isSending: true });
        const { email: { value: email } } = this.state;
        api.post('/password-email', { email })
            .then(successResponse => {
                this.setState({ isSending: false });
                const { message } = successResponse.data;
                this.setState({ message });
                this.setState(state => {
                    return {
                        email: {
                            ...state.email,
                            value: ''
                        }
                    }
                });
            }).catch(failedResponse => {
                this.setState({ isSending: false });
                if (failedResponse.response.status == 422) {
                    const { errors } = failedResponse.response.data;
                    for (const key in errors) {
                        this.setState(state => {
                            return {
                                ...state,
                                [key]: {
                                    hasError: true,
                                    errors: errors[key]
                                }
                            }
                        });
                    }
                }
                if (failedResponse.response.status == 500) {
                    const { message } = failedResponse.response.data;
                    this.props.setErrorMessage(message);
                }
            });
    }

    /**
     * @param {Event} event 
     */
    onEmailKeyUp = (event) => {
        event.persist();
        this.setState((state) => {
            return {
                email: {
                    value: event.target.value
                }
            }
        });
    }
    getSendButton = () => {
        if (this.state.isSending) {
            return <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
        }
        return (
            <div className="w-full lg:w-2/3 self-center">
                <Button onClick={(e) => this.onSend()} type="secondary">Send</Button>
            </div>
        )
    }

    render() {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <div className="text-2xl font-bold text-gray-800 text-center items-center">Request a Password Reset Link</div>
                    <Field name="email" value={this.state.email.value}
                        errors={this.state.email.errors}
                        hasError={this.state.email.hasError}
                        onChange={(e) => this.onEmailKeyUp(e)} label="Email Address" type="email" />
                    {this.getSendButton()}
                    <Link to="/login" className="w-full lg:w-2/3 self-center">
                        <Button type="outlined-secondary">
                            <div className="flex flex-row space-x-1 justify-center">
                                <svg version="1.1" viewBox="0 0 24 24" className="stroke-current h-6 w-6 transform " xmlns="http://www.w3.org/2000/svg">
                                    <g strokeLinecap="round" strokeWidth="1.5" fill="none" strokeLinejoin="round">
                                        <path d="M5,12h14"></path><path d="M10,7l-5,5"></path><path d="M10,17l-5,-5"></path>
                                    </g>
                                </svg>
                                <span> Back to Login </span>
                            </div>
                        </Button>
                    </Link>
                </Card>
            </Page>
        )
    }

}


export default connect(null, { setMessage, setErrorMessage })(ForgotPasswordPage);