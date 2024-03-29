import { collect } from 'collect.js';
import React from 'react';
import { connect } from 'react-redux';
import { Link, NavLink } from 'react-router-dom';
import Icon from '../../assets/Icon';
import Button from '../Button';

const MobileMenu = class MobileMenu extends React.Component {


    userIsAdmin() {
        return this.props.user?.isAdmin;
    }

    render() {
        return (
            <div className="md:hidden flex flex-col bg-white shadow rounded lg:p-4 p-2 m-4">
                <div className={`md:hidden flex flex-row ${this.props.auth.authenticated ? 'justify-center' : 'justify-between'} w-full items-center`}>
                    {this.props.auth.authenticated ? null : (
                        <Link to="/">
                            <Icon />
                        </Link>
                    )}
                    <div className="flex flex-row space-x-2 items-center">
                        {this.props.auth.authenticated ? (
                            <React.Fragment>
                                <Link to="/leave/create" className="text-white flex flex-row space-x-1 items-center bg-purple-500 transform hover:scale-105 rounded-lg p-1 justify-between">
                                    <span>
                                        <svg version="1.1" className="stroke-current text-white h-8 w-8" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M15 3v2"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M7 3v2"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 8h16"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M19 12.417v-6.417c0-1.105-.895-2-2-2h-12c-1.105 0-2 .895-2 2v11c0 1.105.895 2 2 2h7.417"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.999 10.75c-.138 0-.25.112-.249.25 0 .138.112.25.25.25 .138 0 .25-.112.25-.25 0-.138-.112-.25-.251-.25"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.999 14.75c-.138 0-.25.112-.249.25 0 .138.112.25.25.25 .138 0 .25-.112.25-.25 0-.138-.112-.25-.251-.25"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10.75 11.001c0 .138.112.25.25.249 .138 0 .25-.112.25-.25 0-.138-.112-.25-.25-.25 -.138 0-.25.112-.25.251"></path>
                                                <path strokeWidth="1.5" d="M17 22c-2.761 0-5-2.238-5-5 0-2.704 2.3-5.003 5.004-5 2.76.002 4.996 2.24 4.996 5 0 2.761-2.238 5-5 5"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M17 15v4"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M19 17h-4"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </Link>

                                <NavLink to="/home" activeClassName="border-2 border-purple-500" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                                    <span>
                                        <svg version="1.1" className="stroke-current text-gray-700 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                                            <g fill="none">
                                                <path strokeWidth="1.5" d="M19.842 8.299l-6-4.667c-1.083-.843-2.6-.843-3.684 0l-6 4.667c-.731.568-1.158 1.442-1.158 2.368v7.333c0 1.657 1.343 3 3 3h12c1.657 0 3-1.343 3-3v-7.333c0-.926-.427-1.8-1.158-2.368Z"></path>
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M14.121 11.379c1.172 1.172 1.172 3.071 0 4.243 -1.172 1.172-3.071 1.172-4.243 0 -1.172-1.172-1.172-3.071 0-4.243 1.172-1.172 3.072-1.172 4.243 0"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </NavLink>

                                {this.userIsAdmin() ? (
                                    <NavLink to="/leaves" activeClassName="border-2 border-purple-500" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                                        <svg id="Layer_3" className="stroke-current text-gray-700 h-8 w-8" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <line x1="16.5" y1="16" x2="11" y2="16" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                            <path d="M7.5,15.875A.125.125,0,1,0,7.625,16a.125.125,0,0,0-.125-.125" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                            <line x1="16.5" y1="12" x2="11" y2="12" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                            <line x1="7.5" y1="3" x2="7.5" y2="6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                            <line x1="16.5" y1="3" x2="16.5" y2="6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                            <rect x="3" y="4.5" width="18" height="16.5" rx="3" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" fill="none" />
                                            <path d="M7.5,11.875A.125.125,0,1,0,7.625,12a.125.125,0,0,0-.125-.125" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                        </svg>
                                    </NavLink>
                                ) : null}
                                {this.userIsAdmin() ? (
                                    <NavLink to="/users" activeClassName="border-2 border-purple-500" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                                        <span>
                                            <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-gray-700 h-8 w-8" xmlns="http://www.w3.org/2000/svg">
                                                <g strokeLinecap="round" strokeWidth="1.5" fill="none" strokeLinejoin="round">
                                                    <path d="M20.7925,9.52352c0.790031,0.790031 0.790031,2.07092 0,2.86095c-0.790031,0.790031 -2.07092,0.790031 -2.86095,1.77636e-15c-0.790031,-0.790031 -0.790031,-2.07092 0,-2.86095c0.790031,-0.790031 2.07092,-0.790031 2.86095,-1.77636e-15"></path>
                                                    <path d="M14.2026,5.91236c1.21648,1.21648 1.21648,3.18879 0,4.40528c-1.21648,1.21648 -3.18879,1.21648 -4.40528,0c-1.21648,-1.21648 -1.21648,-3.18879 0,-4.40528c1.21648,-1.21648 3.18879,-1.21648 4.40528,0"></path>
                                                    <path d="M6.06848,9.52352c0.790031,0.790031 0.790031,2.07092 0,2.86095c-0.790031,0.790031 -2.07092,0.790031 -2.86095,1.77636e-15c-0.790031,-0.790031 -0.790031,-2.07092 0,-2.86095c0.790031,-0.790031 2.07092,-0.790031 2.86095,-1.77636e-15"></path>
                                                    <path d="M23,19v-1.096c0,-1.381 -1.119,-2.5 -2.5,-2.5h-0.801"></path>
                                                    <path d="M1,19v-1.096c0,-1.381 1.119,-2.5 2.5,-2.5h0.801"></path>
                                                    <path d="M17.339,19v-1.601c0,-1.933 -1.567,-3.5 -3.5,-3.5h-3.679c-1.933,0 -3.5,1.567 -3.5,3.5v1.601"></path></g>
                                            </svg>
                                        </span>
                                    </NavLink>
                                ) : null}
                                <NavLink to="/profile" activeClassName="border-2 border-purple-500" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                                    <svg version="1.1" className="stroke-current text-gray-800 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                                        <path d="M12 12c-2.467 0-4.483-2.015-4.483-4.483 0-2.468 2.016-4.517 4.483-4.517 2.467 0 4.483 2.015 4.483 4.483 0 2.468-2.016 4.517-4.483 4.517Zm7 9h-14c-.55 0-1-.45-1-1v-1c0-2.2 1.8-4 4-4h8c2.2 0 4 1.8 4 4v1c0 .55-.45 1-1 1Z" strokeLinecap="round" strokeWidth="1.5" fill="none" strokeLinejoin="round">
                                        </path>
                                    </svg>
                                </NavLink>
                                <NavLink to="/settings" activeClassName="border-2 border-purple-500" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                                    <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-gray-700 h-8 w-8" xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none">
                                            <line x1="13" x2="13" y1="7.5" y2="10.5" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                            <line x1="13" x2="7" y1="9" y2="9" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                            <line x1="17" x2="15.5" y1="9" y2="9" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                            <line x1="10.92" x2="10.92" y1="16.5" y2="13.5" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                            <line x1="11" x2="17" y1="15" y2="15" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                            <line x1="7" x2="8.5" y1="15" y2="15" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5"></line>
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M16 21h-8l-2.18557e-07-7.10543e-15c-2.76142-1.20706e-07-5-2.23858-5-5 0 0 0-1.77636e-15 0-1.77636e-15v-8l5.68434e-14 7.54979e-07c-4.16963e-07-2.76142 2.23858-5 5-5h8l-2.18557e-07 5.32907e-15c2.76142-1.20706e-07 5 2.23858 5 5v8l3.55271e-15 2.18557e-07c0 2.76142-2.23858 5-5 5Z"></path>
                                        </g>
                                    </svg>
                                </NavLink>
                            </React.Fragment>
                        ) : (
                            <React.Fragment>
                                <Link to="/login">
                                    <Button type="primary">Login</Button>
                                </Link>
                                <Link to="/register">
                                    <Button type="secondary">Register</Button>
                                </Link>
                            </React.Fragment>
                        )}
                    </div>
                </div>
            </div>
        );

    }

}

const mapStateToProps = (state) => {
    return {
        auth: state.auth,
        user: state.user
    }
}

export default connect(mapStateToProps, null)(MobileMenu);