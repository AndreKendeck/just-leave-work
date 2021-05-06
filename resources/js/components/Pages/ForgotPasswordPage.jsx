import React from 'react';
import Loader from 'react-loader-spinner';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import Field from '../Form/Field';
import Page from '../Page';

export default class ForgotPasswordPage extends React.Component {

    state = {
        message: null,
        isSending: false,
        email: { value: null, errors: [], hasError: false },
    }

    onSend = () => {
        this.setState({ isSending: true });
        api.post('/password-email')
            .then(successResponse => {
                this.setState({ isSending: false });
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

    render() {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <div className="text-2xl font-bold text-gray-800 text-center items-center">Send Password Reset Email</div>
                    <Field name="email" errors={this.state.email.errors} hasError={this.state.email.hasError} onKeyUp={this.onEmailKeyUp} label="Email Address" type="email" />
                    <Button onClick={this.onSend} type="outlined">Send</Button>
                    {<Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />}
                </Card>
            </Page>
        )
    }

}