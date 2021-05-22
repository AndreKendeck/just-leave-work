import React from 'react';
import Loader from 'react-loader-spinner';
import { connect } from 'react-redux';
import api from '../../api';
import Button from '../Button';
import Card from '../Card';
import ErrorMessage from '../ErrorMessage';
import Field from '../Form/Field';
import Heading from '../Heading';
import InfoMessage from '../InfoMessage';
import Page from '../Page';

const VerifyEmailPage = class VerifyEmailPage extends React.Component {

    state = {
        error: null,
        successMessage: null,
        code: { value: null, errors: [], hasError: false },
        isSending: false,

    }

    componentDidMount() {
        if (this.props.user?.verified) {
            window.location = '/';
        }
    }

    resendCode = () => {
        this.setState({ isSending: true });
        api.post('/resend-code')
            .then(success => {
                this.setState({ isSending: false });
                const { message } = success.data;
                this.setState({ successMessage: message });
            }).catch(failed => {
                this.setState({ error: failed.response.message });
            });
    }

    verifyEmailAddress = (e) => {
        e.persist();
    }

    onCodeChange = (e) => {
        e.persist();
        this.setState(state => {
            return {
                ...state,
                code: {
                    ...state.code,
                    value: e.target.value
                }
            }
        })
        console.log(this.state);
    }

    sendCodePost = (e) => {
        e.persist();
        const { code: { value: code } } = this.state;
        this.setState({ isSending: true });
        api.post('/verify-email', { code })
            .then(success => {
                this.setState({ isSending: false });
                this.setState({ successMessage: success.data.message });
                /** 
                 * redirect to the homepage
                 */
                setTimeout(() => {
                    window.location = '/home';
                }, 2000);
            }).catch(failed => {
                this.setState({ isSending: false });
                if (failed.response.status == 422) {
                    const { errors } = failed.response.data;
                    this.setState(state => {
                        return {
                            ...state,
                            code: {
                                ...state.code,
                                errors: errors.code
                            }
                        }
                    });
                    return;
                }
                this.setState({ error: failed.response.data.message });
            });
    }


    render() {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <Heading>Verify your account</Heading>
                    <Field name="code" hasError={this.state.code.hasError}
                        errors={this.state.code.errors} onKeyUp={(e) => this.onCodeChange(e)} label="Verification Code" />
                    {this.state.error ? <ErrorMessage onDismiss={() => this.setState({ error: null })} text={this.state.error} /> : null}
                    {this.state.successMessage ? <InfoMessage onDismiss={() => this.setState({ successMessage: null })} text={this.state.successMessage} /> : null}
                    {this.state.isSending ? (
                        <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
                    ) : <React.Fragment>
                        <Button onClick={(e) => this.sendCodePost(e)}>Verify</Button>
                        <Button type="secondary" onClick={(e) => this.resendCode(e)} >Resend code</Button>
                    </React.Fragment>}
                </Card>
            </Page>
        )
    }

}

const mapStateToProps = (state) => {
    return {
        user: state.user
    }
}
export default connect(mapStateToProps, null)(VerifyEmailPage);
