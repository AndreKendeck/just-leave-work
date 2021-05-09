import React, { useEffect, useState } from 'react';
import { useParams, useLocation } from 'react-router';
import api from '../../api';
import Card from '../Card';
import ErrorMessage from '../ErrorMessage';
import Page from '../Page';
import Loader from 'react-loader-spinner';
import { Link } from 'react-router-dom';
import Button from '../Button';


function useQuery() {
    return new URLSearchParams(useLocation().search);
}

const ResetPasswordPage = (props) => {

    const [error, setError] = useState(null);
    const [password, setPassword] = useState({ value: null, errors: [], hasError: false });
    const [passwordConfirmation, setPasswordConfirmation] = useState({ value: null, errors: [], hasError: false });
    const [isLoading, setIsLoading] = useState(true);
    const [tokenResult, setTokenResult] = useState(false);

    const { token } = useParams();
    const query = useQuery();

    const email = query.get('email');

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
            })
    });

    if (isLoading) {
        return (
            <Page className="flex justify-center">
                <Card className="lg:w-1/2 w-full self-center flex flex-col space-y-3 justify-center">
                    <Loader type="Oval" className="self-center" height={20} width={20} color="Gray" />
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
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Natus quam nostrum omnis, reprehenderit ex minima? Quas amet natus voluptatem totam deserunt ullam hic aliquam quos blanditiis tenetur magni, dolore distinctio.
            </Card>
        </Page>
    )

}

export default ResetPasswordPage;