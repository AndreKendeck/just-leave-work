import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import Checkbox from '../Form/Checkbox';
import Field from '../Form/Field';
import Page from '../Page';
import { setUser } from '../../actions/user';
import { setTeam } from '../../actions/team';
import { setAuthenticated } from '../../actions/auth';
import ErrorMessage from '../ErrorMessage';


const RegisterPage = class RegisterPage extends React.Component {

    state = {
        isSending: false,
        error: null,
        email: { value: null, hasError: false, errors: [] },
        password: { value: null, hasError: false, errors: [] },
        name: { value: null, hasError: false, errors: [] },
        team_name: { value: null, hasError: false, errors: [] },
        terms: { checked: false, hasError: false, errors: [] },
    }

    postRegister = (e) => {
        e.persist();
        this.setState({ isSending: true });
        const {
            email: { value: email },
            password: { value: password },
            name: { value: name },
            team_name: { value: team_name },
            terms: { checked: terms }
        } = this.state;

        api.post('/register/', { email, password, name, terms, team_name })
            .then(success => {

                this.setState({ isSending: false });

                const { user, token, team } = success.data;

                window.localStorage.setItem('authToken', token);

                api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                this.props.setUser(user);
                this.props.setTeam(team);
                this.props.setAuthenticated(token);

                window.location = '/home/';

            }).catch(failed => {
                this.setState({ isSending: false });
                const { errors } = failed.response.data;
                if (failed.response.status == 422) {
                    for (const key in errors) {
                        this.setState(state => {
                            return {
                                ...state,
                                [key]: {
                                    hasError: true,
                                    errors: errors[key]
                                }
                            }
                        })
                    }
                } else {
                    this.setState({ error: failed.response.data.message });
                }
            });
    }

    onFieldChange = (event, stateKey) => {
        event.persist();
        this.setState(state => {
            return {
                [stateKey]: {
                    value: event.target.value
                }
            }
        })
    }
    onCheckboxCheck = () => {
        this.setState(state => {
            return {
                terms: {
                    checked: !state.terms.checked
                }
            }
        });
    }

    render() {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <div className="text-2xl font-bold text-gray-800 text-center items-center">Register an Account</div>
                    <Field type="text" label="Name" name="name" errors={this.state.name.errors} onKeyUp={(e) => this.onFieldChange(e, 'name')} hasError={this.state.name.hasError} />
                    <Field type="email" label="E-mail Address" name="email" hasError={this.state.email.hasError} errors={this.state.email.errors} onKeyUp={(e) => this.onFieldChange(e, 'email')} />
                    <Field type="text" label="Organization" name="team_name" hasError={this.state.team_name.hasError} errors={this.state.team_name.errors} onKeyUp={(e) => this.onFieldChange(e, 'team_name')} />
                    <Field type="password" label="Password" name="password" hasError={this.state.password.hasError} errors={this.state.password.errors} onKeyUp={(e) => this.onFieldChange(e, 'password')} />
                    <div className="flex flex-col md:flex-row items-center w-full justify-between">
                        <div className="w-full">
                            <Checkbox label="I agree with the Terms &amp; Conditions" errors={this.state.terms.errors} name="terms" onChange={this.onCheckboxCheck} />
                        </div>

                        <Link to="/terms-and-conditions" className="w-full text-purple-500 hover:text-purple-300 whitespace-no-wrap p-2 bg-purple-100 rounded-lg text-center text-sm">
                            View Terms &amp; Conditions
                        </Link>
                    </div>
                    {this.state.isSending ? <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" /> : <Button onClick={(e) => this.postRegister(e)} >Register</Button>}
                    <Link to="/login">
                        <Button type="secondary"> Back to Login </Button>
                    </Link>
                    {this.state.error ? <ErrorMessage text={this.state.error} /> : null}
                </Card>
            </Page>
        );
    }
}

export default connect(null, { setUser, setAuthenticated, setTeam })(RegisterPage);