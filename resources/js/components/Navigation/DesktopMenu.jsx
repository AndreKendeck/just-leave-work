
import React from 'react';
import { connect } from 'react-redux';
import { Link, NavLink } from 'react-router-dom';
import Button from '../Button';
import Icon from '../../assets/Icon';


const DesktopMenu = class DesktopMenu extends React.Component {


    userIsAdmin() {
        return this.props.user?.isAdmin;
    }

    render() {
        return (
            <div className="hidden md:flex flex-col bg-white p-4 mx-8 rounded-lg mt-4 shadow-lg w-2/3 self-center">
                <div className="flex flex-row space-x-2 items-center w-full justify-between">
                    <Link to="/" className="w-1/6">
                        <Icon width={12} height={12} />
                    </Link>
                    {this.props.auth.authenticated ? (
                        <div className="w-full flex flex-row space-x-2 items-center">
                            <NavLink to="/leave/create" className="text-white flex flex-row space-x-1 items-center bg-purple-500 transform hover:scale-105 rounded-lg py-2 px-3 justify-between">
                                <span>
                                    <svg version="1.1" className="stroke-current text-white h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                                        <g fill="none">
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M15 3v2"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M7 3v2"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 8h16"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M19 12.417v-6.417c0-1.105-.895-2-2-2h-12c-1.105 0-2 .895-2 2v11c0 1.105.895 2 2 2h7.417"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.999 10.75c-.138 0-.25.112-.249.25 0 .138.112.25.25.25 .138 0 .25-.112.25-.25 0-.138-.112-.25-.251-.25"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.999 14.75c-.138 0-.25.112-.249.25 0 .138.112.25.25.25 .138 0 .25-.112.25-.25 0-.138-.112-.25-.251-.25"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.75 11.001c0 .138.112.25.25.249 .138 0 .25-.112.25-.25 0-.138-.112-.25-.25-.25 -.138 0-.25.112-.25.251"></path>
                                            <path strokeWidth="1.5" d="M17 22c-2.761 0-5-2.238-5-5 0-2.704 2.3-5.003 5.004-5 2.76.002 4.996 2.24 4.996 5 0 2.761-2.238 5-5 5"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M17 15v4"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M19 17h-4"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span className="text-white text-base">Apply</span>
                            </NavLink>
                            <NavLink to="/home" activeClassName="text-purple-500" className="flex flex-row space-x-1 items-center p-2 text-gray-800 hover:text-purple-500 rounded">
                                <span className="transition-none">
                                    <svg version="1.1" className="stroke-current h-8 w-8 transition-none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                                        <g fill="none">
                                            <path strokeWidth="1.5" d="M19.842 8.299l-6-4.667c-1.083-.843-2.6-.843-3.684 0l-6 4.667c-.731.568-1.158 1.442-1.158 2.368v7.333c0 1.657 1.343 3 3 3h12c1.657 0 3-1.343 3-3v-7.333c0-.926-.427-1.8-1.158-2.368Z"></path>
                                            <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M14.121 11.379c1.172 1.172 1.172 3.071 0 4.243 -1.172 1.172-3.071 1.172-4.243 0 -1.172-1.172-1.172-3.071 0-4.243 1.172-1.172 3.072-1.172 4.243 0"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span className="text-base">Home</span>
                            </NavLink>
                            {this.userIsAdmin() ? (<NavLink to="/leaves/" activeClassName="text-purple-500" className="flex flex-row space-x-1 items-center p-2 text-gray-800 hover:text-purple-500 rounded">
                                <svg id="Layer_3" className="stroke-current h-8 w-8" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <line x1="16.5" y1="16" x2="11" y2="16" fill="none" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" />
                                    <path d="M7.5,15.875A.125.125,0,1,0,7.625,16a.125.125,0,0,0-.125-.125" fill="none" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" />
                                    <line x1="16.5" y1="12" x2="11" y2="12" fill="none" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" />
                                    <line x1="7.5" y1="3" x2="7.5" y2="6" fill="none" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" />
                                    <line x1="16.5" y1="3" x2="16.5" y2="6" fill="none" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" />
                                    <rect x="3" y="4.5" width="18" height="16.5" rx="3" strokeWidth="1.5" strokeLinejoin="round" strokeLinejoin="round" fill="none" />
                                    <path d="M7.5,11.875A.125.125,0,1,0,7.625,12a.125.125,0,0,0-.125-.125" fill="none" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" />
                                </svg>
                                <span className="text-base">Leaves</span>
                            </NavLink>) : null}


                            {this.userIsAdmin() ? (
                                <NavLink to="/users" activeClassName="text-purple-500" className="flex flex-row space-x-1 items-center p-2 text-gray-800 hover:text-purple-500 rounded">
                                    <span>
                                        <svg version="1.1" viewBox="0 0 24 24" className="stroke-current h-8 w-8" xmlns="http://www.w3.org/2000/svg">
                                            <g strokeLinejoin="round" strokeWidth="1.5" fill="none" strokeLinejoin="round">
                                                <path d="M20.7925,9.52352c0.790031,0.790031 0.790031,2.07092 0,2.86095c-0.790031,0.790031 -2.07092,0.790031 -2.86095,1.77636e-15c-0.790031,-0.790031 -0.790031,-2.07092 0,-2.86095c0.790031,-0.790031 2.07092,-0.790031 2.86095,-1.77636e-15"></path>
                                                <path d="M14.2026,5.91236c1.21648,1.21648 1.21648,3.18879 0,4.40528c-1.21648,1.21648 -3.18879,1.21648 -4.40528,0c-1.21648,-1.21648 -1.21648,-3.18879 0,-4.40528c1.21648,-1.21648 3.18879,-1.21648 4.40528,0"></path>
                                                <path d="M6.06848,9.52352c0.790031,0.790031 0.790031,2.07092 0,2.86095c-0.790031,0.790031 -2.07092,0.790031 -2.86095,1.77636e-15c-0.790031,-0.790031 -0.790031,-2.07092 0,-2.86095c0.790031,-0.790031 2.07092,-0.790031 2.86095,-1.77636e-15"></path>
                                                <path d="M23,19v-1.096c0,-1.381 -1.119,-2.5 -2.5,-2.5h-0.801"></path>
                                                <path d="M1,19v-1.096c0,-1.381 1.119,-2.5 2.5,-2.5h0.801"></path>
                                                <path d="M17.339,19v-1.601c0,-1.933 -1.567,-3.5 -3.5,-3.5h-3.679c-1.933,0 -3.5,1.567 -3.5,3.5v1.601"></path></g>
                                        </svg>
                                    </span>
                                    <span className="text-base">Users</span>
                                </NavLink>
                            ) : null}
                            {this.userIsAdmin() ? (
                                <NavLink to="/settings" activeClassName="text-purple-500" className="flex flex-row space-x-1 items-center p-2 text-gray-800 hover:text-purple-500 rounded">
                                    <span>
                                        <svg version="1.1" className="stroke-current h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                                            <g fill="none">
                                                <line x1="7.5" x2="10.5" y1="11" y2="11" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                                <line x1="9" x2="9" y1="11" y2="17" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                                <line x1="9" x2="9" y1="7" y2="8.5" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                                <line x1="16.5" x2="13.5" y1="13.08" y2="13.08" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                                <line x1="15" x2="15" y1="13" y2="7" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                                <line x1="15" x2="15" y1="17" y2="15.5" strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                                <path strokeLinejoin="round" strokeLinejoin="round" strokeWidth="1.5" d="M21 8v8 0c0 2.76142-2.23858 5-5 5h-8l-2.18557e-07-7.10543e-15c-2.76142-1.20706e-07-5-2.23858-5-5 0 0 0-1.77636e-15 0-1.77636e-15v-8l5.68434e-14 7.54979e-07c-4.16963e-07-2.76142 2.23858-5 5-5h8l-5.96244e-08 9.76996e-15c2.76142-4.49893e-07 5 2.23858 5 5 4.26326e-14 2.54893e-07 6.39488e-14 5.00086e-07 6.75016e-14 7.54979e-07Z"></path>
                                            </g></svg>
                                    </span>
                                    <span className="text-sm">Settings</span>
                                </NavLink>
                            ) : null}
                            <Link to="/profile" className="flex flex-row space-x-2 hover:bg-gray-200 rounded-lg items-center focus:outline-none p-2">
                                <img className="h-8 w-8 rounded-full" src={this.props.user?.avatarUrl} alt={this.props.user?.name} />
                                <span className="text-gray-600 text-base">{this.props.user?.name}</span>
                            </Link>
                        </div>
                    ) : (
                        <React.Fragment>
                            <div className="flex flex-row space-x-2 self-end items-center w-1/2">
                                <Link to="/login" className="w-full">
                                    <Button>Login</Button>
                                </Link>
                                <Link to="/register" className="w-full">
                                    <Button type="secondary">Register</Button>
                                </Link>
                            </div>
                        </React.Fragment>
                    )}
                </div>
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        auth: state.auth,
        user: state.user,
        team: state.team
    }
}
export default connect(mapStateToProps, null)(DesktopMenu);