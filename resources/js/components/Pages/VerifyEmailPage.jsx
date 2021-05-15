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
                this.setState({ isSending: false });
                if (failed.response.status == 422) {
                    const errors = failed.response.data;
                    this.setState(state => {
                        return {
                            ...state,
                            code: {
                                ...state.code,
                                errors: errors[code],
                                hasError: true
                            }
                        }
                    })
                }
            });
    }



    render() {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <Heading>Verify your account</Heading>
                    <Field name="code" label="Verification Code" />
                    {this.state.error ? <ErrorMessage text={this.state.error} /> : null}
                    {this.state.successMessage ? <InfoMessage text={this.state.successMessage} /> : null}
                    {this.state.isSending ? (
                        <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
                    ) : <Button onClick={this.resendCode()}>Verify</Button>}
                    <Button type="secondary" onClick={this.resendCode()} >Resend code</Button>
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
