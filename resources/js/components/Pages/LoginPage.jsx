
import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import ErrorMessage from '../ErrorMessage';
import Field from '../Form/Field';
import Page from '../Page';
import { setUser } from '../../actions/user';
import { setAuthenticated } from '../../actions/auth';


const LoginPage = class LoginPage extends React.Component {

    state = {
        error: null,
        email: { value: null, errors: [], hasError: false },
        password: { value: null, errors: [], hasError: false },
        isSending: false
    }

    componentDidMount() {
        if (this.props.state.auth.authenticated) {
            window.location = '/dashboard';
        }
    }

    postLogin = () => {
        const email = this.state.email.value;
        const password = this.state.password.value;
        this.setState({ isSending: true });
        // allow the page to set a timeout
        api.post('/login/', { email, password })
            .then(successResponse => {

                this.setState({ isSending: false });
                const { user, token } = successResponse.data;

                window.localStorage.setItem('authToken', token);

                api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                window.location = '/dashboard';

            }).catch(failedResponse => {

                this.setState({ isSending: false });

                const { errors } = failedResponse.response.data;

                if (failedResponse.response.status === 429) {
                    const tooManyAttemps = ['You tried login in too many time, please try again later'];
                    this.setState({ errors: tooManyAttemps });
                }

                for (const key in errors) {
                    this.setState(state => {
                        return {
                            [key]: {
                                ...state[key],
                                errors: errors[key],
                                hasError: true
                            }
                        }
                    });
                }

            });
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
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <div className="text-2xl font-bold text-gray-800 text-center items-center">Sign in to your Account.</div>
                    <Field name="email" errors={this.state.email.errors} hasError={this.state.email.hasError} onKeyUp={this.onEmailKeyUp} label="Email Address" type="email" />
                    <Field name="password" errors={this.state.password.errors} hasError={this.state.password.hasError} onKeyUp={this.onPasswordKeyUp} label="Password" type="password" />
                    {this.state.isSending ? <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" /> : <Button onClick={this.postLogin}>Login</Button>}
                    <div className="flex flex-row items-center w-full jutsify-between space-x-2">
                        <Link to="/password-email" className="w-full">
                            <Button type="soft"> Reset password </Button>
                        </Link>
                        <Link to="/register" className="w-full">
                            <Button type="secondary"> Register </Button>
                        </Link>
                    </div>
                    {this.state.error ? <ErrorMessage text={this.state.error} /> : null}
                </Card>
            </Page>
        )
    }
}

const mapStateToProps = (state, ownProps) => {
    return {
        state
    }
}

export default connect(mapStateToProps,{ setUser })(LoginPage);