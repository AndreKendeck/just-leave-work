
import React from 'react';
import { connect } from 'react-redux';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import Field from '../Form/Field';
import Page from '../Page';

const LoginPage = class LoginPage extends React.Component {

    state = {
        errors: [],
        email: { value: null, errors: [], hasError: false },
        password: { value: null, errors: [], hasError: false },
        isSending: false
    }

    postLogin = () => {
        const email = this.state.email.value;
        const password = this.state.password.value;
        this.setState({ isSending: true });
        api.post('/login/', { email, password })
            .then(successResponse => {

                this.setState({ isSending: false });

            }).catch(failedResponse => {

                this.setState({ isSending: false });

            })
    }

    onEmailKeyUp = (event) => {
        event.persist();
        this.setState(state => {
            return {
                email: {
                    value: event.target.value
                }
            }
        });
    }

    onPasswordKeyUp = (event) => {
        event.persist();
        this.setState(state => {
            return {
                password: {
                    value: event.target.value
                }
            }
        });
    }



    render() {
        return (
            <Page>
                <Card>
                    <div className="text-2xl font-bold text-gray-800 text-center">Sign in to your Account.</div>
                    <Field name="email" onKeyUp={this.onEmailKeyUp} label="Email Address" type="email" />
                    <Field name="password" onKeyUp={this.onPasswordKeyUp} label="Password" type="password" />
                    <Button onClick={this.postLogin}>Login</Button>
                </Card>
            </Page>
        )
    }
}

export default connect(null, null)(LoginPage);