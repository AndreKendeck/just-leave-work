
import React from 'react';
import { connect } from 'react-redux';
import Card from '../Card';
import Field from '../Form/Field';
import Page from '../Page';

const LoginPage = class LoginPage extends React.Component {

    state = {
        errors: [],
        email: { text: null, errors: [], hasError: false },
        password: { text: null, errors: [], hasError: false },
        isSending: false
    }

    render() {
        return (
            <Page>
                <Card>
                    <div className="text-2xl font-bold text-gray-800 text-center">Sign in to your Account.</div>
                    <Field name="email" label="Email Address" type="email" />
                    <Field name="password" label="Password" type="password" />
                </Card>
            </Page>
        )
    }
}

export default connect(null, null)(LoginPage);