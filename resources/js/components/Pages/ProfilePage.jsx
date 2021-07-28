import React from 'react';
import { connect } from 'react-redux';
import { unsetAuthenticated } from '../../actions/auth';
import Button from '../Button';
import Card from '../Card';
import Page from '../Page';
import UserBadge from '../UserBadge';
import { clearUserForm, updateUserForm } from '../../actions/forms/user';
import Loader from 'react-loader-spinner';
import api from '../../api';
import ErrorMessage from '../ErrorMessage';
import moment from 'moment';
import Heading from '../Heading';
import UserLeaveSummary from '../UserLeaveSummary';
const ProfilePage = class ProfilePage extends React.Component {

    state = {
        loading: false,
        errors: [],
    }

    logout() {
        this.setState({ loading: true });
        api.post('/logout')
            .then(success => {
                this.props.unsetAuthenticated();
                localStorage.removeItem('authToken');
                window.location = '/';
            }).catch(failed => {
                const { message } = failed.response.data;
                this.setState({ errors: [...message, ...this.state.errors] });
            });

    }

    componentDidMount() {
        const { name, leaveBalance } = this.props.user;
        this.props.updateUserForm({ name, balance: leaveBalance });
    }

    isAdmin() {
        const { user } = this.props;
        return user?.isAdmin;
    }

    renderErrors() {
        return this.state.errors?.map((error, key) => {
            return <ErrorMessage text={error} key={key} />
        });
    }

    render() {
        if (this.state.loading) {
            return (
                <Page className="flex flex-col justify-center space-y-2">
                    <Card className="w-full lg:w-1/2 self-center pointer-cursor">
                        <Loader type="Oval" className="self-center" height={80} width={80} color="Gray" />
                    </Card>
                </Page>
            )
        }
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col space-y-4 w-full lg:w-1/2 self-center pointer-cursor">
                    {this.renderErrors()}
                    <div className="flex flex-row justify-between items-center">
                        <div className="flex flex-row space-x-1">
                            <div>
                                <UserBadge user={this.props?.user} />
                            </div>
                            {this.props?.user.isAdmin ? (<div className="bg-purple-500 bg-opacity-25 text-purple-500 text-xs px-2 rounded-full py-1">Admin</div>) : null}
                        </div>
                        <div>
                            <Button type="soft" onClick={(e) => this.logout()}>
                                <div className="flex space-x-1 items-center">
                                    <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-gray-600 h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink">
                                        <g fill="none"><use xlinkHref="#a"></use>
                                            <path strokeLinecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.86 12h10.14"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.864 19.981l-4.168.019c-1.195.006-2.167-.952-2.167-2.135v-11.73c0-1.179.965-2.135 2.157-2.135h4.314"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 16l4-4 -4-4"></path>
                                            <use xlinkHref="#a"></use>
                                        </g>
                                    </svg>
                                    <span className="text-gray-600">Logout</span>
                                </div>
                            </Button>
                        </div>
                    </div>
                </Card>

                <div className="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:w-1/2 w-full self-center">
                    <UserLeaveSummary user={this.props?.user} />
                </div>
            </Page>
        );
    }
}

const mapStateToProps = (state) => {
    const { user, userForm } = state;
    return {
        user,
        userForm
    }
}


export default connect(mapStateToProps, { unsetAuthenticated, updateUserForm, clearUserForm })(ProfilePage);