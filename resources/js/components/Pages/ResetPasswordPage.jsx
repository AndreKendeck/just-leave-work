import React, { useEffect, useState } from 'react';
import { useParams, useLocation } from 'react-router';
import api from '../../api';
import Card from '../Card';
import ErrorMessage from '../ErrorMessage';
import Page from '../Page';
import Loader from 'react-loader-spinner';
import { Link } from 'react-router-dom';
import Button from '../Button';
import Heading from '../Heading';
import Field from '../Form/Field';
import InfoMessage from '../InfoMessage';
import { connect } from 'react-redux';
import { setErrorMessage, setMessage } from '../../actions/messages';


function useQuery() {
    return new URLSearchParams(useLocation().search);
}


const ResetPasswordPage = (props) => {

    const [error, setError] = useState(null);
    const [password, setPassword] = useState({ value: null, errors: [], hasError: false });
    const [passwordConfirmation, setPasswordConfirmation] = useState({ value: null, errors: [], hasError: false });
    const [isLoading, setIsLoading] = useState(true);
    const [tokenResult, setTokenResult] = useState(false);
    const [message, setMessage] = useState(null);
    const [isSending, setIsSending] = useState(false);

    const { token } = useParams();
    const query = useQuery();

    const email = query.get('email');

    const resetPasswordPost = ({ email, password, passwordConfirmation, token }) => {
        setIsSending(true);
        api.post('/reset-password', { email, password, password_confirmation: passwordConfirmation, token })
            .then(success => {
                setIsSending(false);
                setMessage(success.data.message);
                setTimeout(() => {
                    window.location = '/login';
                }, 2500);
            }).catch(failed => {
                setIsSending(false);
                if (failed.response.status == 422) {
                    setPassword({ ...password, errors: failed.response.data.errors.password });
                    return;
                }
                setError(failed.response.data.message);
            });
    }



    useEffect(() => {
        api.post('/check-password-reset-token', { token, email })
            .then(success => {
                setIsLoading(false);
                setTokenResult(true);
                return true;
            }).catch(failed => {
                setError(failed.response.data.message);
                setIsLoading(false);
                return false;
            });
    }, []);


    if (isLoading) {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <Loader type="Oval" className="self-center" height={100} width={100} color="Gray" />
                </Card>
            </Page>
        )
    }


    if (!tokenResult) {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <Link to="/login">
                        <Button> Back to Login </Button>
                    </Link>
                    <ErrorMessage text={error ? error : 'Something went wrong please try again'} />
                </Card>
            </Page>
        )
    }

    return (
        <Page className="flex justify-center">
            <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                <Heading>Reset your account password</Heading>
                <Field disabled={message ? true : false} type="password" name="password" label="New password" hasError={password.hasError}
                    errors={password.errors} onKeyUp={(e) => { e.persist(); setPassword({ value: e.target.value, errors: [], hasError: false }) }} />
                <Field disabled={message ? true : false} type="password" name="password_confirmation" label="Confirm new password" hasError={passwordConfirmation.hasError}
                    onKeyUp={(e) => { e.persist(); setPasswordConfirmation({ value: e.target.value, errors: [], hasError: false }) }}
                    errors={passwordConfirmation.errors} />
                {isSending ? <Loader type="Oval" className="self-center" height={100} width={100} color="Gray" /> : (
                    <Button onClick={(e) => { resetPasswordPost({ email, password: password.value, passwordConfirmation: passwordConfirmation.value, token }) }}>
                        Save
                    </Button>
                )}
            </Card>
        </Page>
    )

}

export default connect(null, { setMessage, setErrorMessage })(ResetPasswordPage);