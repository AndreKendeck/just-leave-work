import React from 'react';
import { connect } from 'react-redux';
import { unsetAuthenticated } from '../../actions/auth';
import Button from '../Button';
import Card from '../Card';
import Page from '../Page';
import UserBadge from '../UserBadge';

const ProfilePage = class ProfilePage extends React.Component {

    render() {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="w-full lg:w-1/2 self-center pointer-cursor">
                    <div className="flex flex-row justify-between items-center">
                        <div className="flex flex-row space-x-1">
                            <div>
                                <UserBadge user={this.props?.user} />
                            </div>
                            {this.props?.user.isAdmin ? (<div className="bg-purple-500 bg-opacity-25 text-purple-500 text-xs px-2 rounded-full py-1">Admin</div>) : null}
                        </div>
                        <div>
                            <Button type="soft">
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
            </Page>
        );
    }
}

const mapStateToProps = (state) => {
    const { user } = state;
    return {
        user
    }
}


export default connect(mapStateToProps, { unsetAuthenticated })(ProfilePage);