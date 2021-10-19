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
import { setErrorMessage } from '../../actions/messages';
import ReCAPTCHA from 'react-google-recaptcha';
import { updateRegisterForm, clearRegisterForm } from '../../actions/forms/auth/register';
import Dropdown from '../Form/Dropdown';


const RegisterPage = class RegisterPage extends React.Component {

    state = {
        countries: []
    }

    componentDidMount() {
        this.getCountries();
    }

    postRegister = (e) => {
        e.persist();
        const { registerForm } = this.props;
        const { email, password, name, team_name, terms, recaptcha, country } = registerForm;
        this.props.updateRegisterForm({ ...registerForm, loading: true });
        api.post('/register/', { email, password, name, terms, team_name, recaptcha, country })
            .then(success => {

                this.props.updateRegisterForm({ ...registerForm, loading: true });

                const { user, token, team } = success.data;

                window.localStorage.setItem('authToken', token);

                api.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                this.props.setUser(user);
                this.props.setTeam(team);
                this.props.setAuthenticated(token);

                window.location = '/home/';

            }).catch(failed => {
                this.props.updateRegisterForm({ ...registerForm, loading: false });
                const { errors, message } = failed.response.data;
                if (failed.response.status == 422) {
                    const { registerForm } = this.props;
                    this.props.updateRegisterForm({ ...registerForm, errors: errors });
                } else {
                    this.props.setErrorMessage(message);
                }
            });
    }

    onFieldChange(e, key) {
        const value = e.target.value;
        const { registerForm } = this.props;
        this.props.updateRegisterForm({ ...registerForm, [key]: value });
    }

    getCountries() {
        api.get('/countries').then(success => {
            // set a default value for the countries
            let countries = [{ value: null, label: 'Select a country', selected: true }, ...success.data];
            this.setState({ countries });
        }).catch(failed => {
            const { message } = failed.response.data;
            this.props.setErrorMessage(message);
        });
    }

    onCheckboxCheck() {
        const { registerForm } = this.props;
        const { terms } = this.props.registerForm;
        this.props.updateRegisterForm({ ...registerForm, terms: !terms });
    }

    captchaChange(value) {
        const { registerForm } = this.props;
        this.props.updateRegisterForm({ ...registerForm, recaptcha: value });
    }

    getCaptchaErrors() {
        const { errors } = this.props.registerForm;
        if (errors?.recaptcha) {
            return errors.recaptcha.map((err, key) => {
                return <span className="text-red-800 text-sm" key={key}>{err}</span>
            })
        }
        return null;
    }

    render() {
        const { errors, terms, loading } = this.props.registerForm;
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <div className="text-2xl font-bold text-gray-800 text-center items-center">Register an Account</div>
                    <Field type="text" label="Name" name="name" errors={errors?.name} onKeyUp={(e) => this.onFieldChange(e, 'name')} />
                    <Field type="email" label="E-mail Address" name="email" errors={errors?.email} onKeyUp={(e) => this.onFieldChange(e, 'email')} />
                    <Field type="text" label="Organization" name="team_name" errors={errors?.team_name} onKeyUp={(e) => this.onFieldChange(e, 'team_name')} />
                    <Field type="password" label="Password" name="password" errors={errors?.password} onKeyUp={(e) => this.onFieldChange(e, 'password')} />
                    <Dropdown options={this.state.countries} label="Country" tip="Optional" name="counrty" onChange={(e) => this.onFieldChange(e, 'country')} />
                    <div className="flex flex-col md:flex-row items-center w-full justify-between">
                        <div className="w-full">
                            <Checkbox label="I agree with the Terms &amp; Conditions" checked={terms}
                                errors={errors.terms} name="terms" onChange={(e) => this.onCheckboxCheck()} />
                        </div>

                        <Link to="/terms-and-conditions" className="w-full text-purple-500 hover:text-purple-300 whitespace-no-wrap p-2 bg-purple-100 rounded-lg text-center text-sm">
                            View Terms &amp; Conditions
                        </Link>
                    </div>
                    <ReCAPTCHA sitekey={process.env.MIX_REACT_CAPTCHA_SITE_KEY} onChange={(e) => this.captchaChange(e)} />
                    <div className="flex flex-col space-y-1">
                        {this.getCaptchaErrors()}
                    </div>
                    {loading ? <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" /> : <Button onClick={(e) => this.postRegister(e)} >Register</Button>}
                    <Link to="/login">
                        <Button type="secondary"> Back to Login </Button>
                    </Link>
                </Card>
            </Page>
        );
    }
}

const mapStateToProps = (state) => {
    const { registerForm } = state;
    return {
        registerForm
    }
}

export default connect(mapStateToProps, { setUser, setAuthenticated, setTeam, setErrorMessage, updateRegisterForm, clearRegisterForm })(RegisterPage);