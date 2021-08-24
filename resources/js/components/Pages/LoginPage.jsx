
import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import Field from '../Form/Field';
import Page from '../Page';
import { setUser } from '../../actions/user';
import { setAuthenticated } from '../../actions/auth';
import { setTeam } from '../../actions/team';
import { setSettings } from '../../actions/settings';
import { clearLoginForm, updateLoginForm } from '../../actions/forms/auth/login';
import { setErrorMessage, setMessage } from '../../actions/messages';


const LoginPage = class LoginPage extends React.Component {

    componentDidMount() {
        const { auth } = this.props;
        if (auth?.authenticated) {
            window.location = '/dashboard';
        }
        this.props.clearLoginForm();
    }

    postLogin = () => {
        const { loginForm } = this.props;
        const { email = null, password = null } = this.props.loginForm;
        this.props.updateLoginForm({ ...loginForm, loading: true });
        // allow the page to set a timeout
        api.post('/login/', { email, password })
            .then(successResponse => {

                this.props.updateLoginForm({ ...loginForm, loading: false });
                const { user, token, team, settings } = successResponse.data;

                window.localStorage.setItem('authToken', token);

                api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                this.props.setUser(user);
                this.props.setAuthenticated(token);
                this.props.setTeam(team);
                this.props.setSettings(settings);
                this.props.clearLoginForm();

                window.location = '/home/';

            }).catch(failedResponse => {

                this.props.updateLoginForm({ ...loginForm, loading: false });

                const { status } = failedResponse.response;
                const { errors, message } = failedResponse.response.data;

                if (status == 422) {
                    this.props.updateLoginForm({ ...loginForm, errors });
                } else {
                    this.props.setErrorMessage(message);
                    this.props.updateLoginForm({ ...loginForm, errors: { email: [message] } });
                }

            });
    }

    onFormChange(e, key) {
        e.persist();
        const { loginForm } = this.props;
        this.props.updateLoginForm({ ...loginForm, [key]: e.target.value, errors: {} });
    }


    render() {
        /** lets initialize the form variables first  */
        const { email, password, loading, errors } = this.props?.loginForm;
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <div className="text-2xl font-bold text-gray-800 text-center items-center">Sign in to your Account.</div>
                    <Field name="email" value={email} errors={errors?.email} hasError={errors?.email?.length > 0} onChange={(e) => this.onFormChange(e, 'email')} label="Email Address" type="email" />
                    <Field name="password" value={password} errors={errors?.password} hasError={errors?.password?.length > 0} onChange={(e) => this.onFormChange(e, 'password')} label="Password" type="password" />
                    {loading ? <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" /> : <Button onClick={(e) => this.postLogin()}>Login</Button>}
                    <div className="flex flex-row items-center w-full jutsify-between space-x-2">
                        <Link to="/password-email" className="w-full">
                            <Button type="soft"> Reset password </Button>
                        </Link>
                        <Link to="/register" className="w-full">
                            <Button type="secondary"> Register </Button>
                        </Link>
                    </div>
                </Card>
            </Page>
        )
    }
}

const mapStateToProps = (state) => {
    const { auth, loginForm } = state;
    return {
        auth,
        loginForm
    }
}

export default connect(mapStateToProps, { setUser, setTeam, setAuthenticated, setSettings, updateLoginForm, clearLoginForm, setMessage, setErrorMessage })(LoginPage);