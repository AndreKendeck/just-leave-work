import React from 'react';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';

const Navbar = class Navbar extends React.Component {

    state = {
        open: false,
        profile: {
            open: false
        }
    }


    getMobileMenuIconState = () => {
        if (!this.state.open) {
            return (
                <svg viewBox="0 0 24 24" className="stroke-current text-gray-700 h-8 w-8">
                    <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="6.5" x2="17.5" y1="10.75" y2="10.75"></line>
                        <line x1="8.25" x2="15.75" y1="14" y2="14"></line>
                    </g>
                </svg>
            )
        }
        return (
            <svg version="1.1" viewBox="0 0 24 24" className="stroke-current text-gray-700 h-8 w-8" xmlns="http://www.w3.org/2000/svg" >
                <g fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 8l8 8">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8l-8 8">
                    </path>
                </g>
            </svg>
        );
    }

    getAuthMobileMenu() {
        return (
            <React.Fragment>
                <Link to="/dashboard" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                    <svg version="1.1" className="stroke-current text-gray-700 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2.20912" ry="0"></rect>
                            <path d="M13.5 17v-3.88889h-3v3.88889h-2.94444 -2.42843e-08c-.306827-1.34118e-08-.55556-.248733-.55556-.55556 0 0 0-3.55271e-15 0-3.55271e-15v-4.93827l-6.82121e-13 7.90349e-07c2.39607e-08-.158685.0678579-.309795.186459-.41522l4.44445-3.95062 2.66057e-08-2.36506e-08c.210489-.18711.527691-.18711.73818 4.73012e-08l4.44445 3.95067 1.78737e-11 1.5886e-11c.118589.105413.186445.256503.18646.41517v4.93827l-3.55271e-15-2.39098e-11c0 .306827-.248733.55556-.55556.55556Z"></path>
                        </g>
                    </svg>
                </Link>
                <Link to="/leaves" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                    <svg version="1.1" className="stroke-current text-gray-700 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2.20912" ry="0"></rect>
                            <path d="M13.5 17v-3.88889h-3v3.88889h-2.94444 -2.42843e-08c-.306827-1.34118e-08-.55556-.248733-.55556-.55556 0 0 0-3.55271e-15 0-3.55271e-15v-4.93827l-6.82121e-13 7.90349e-07c2.39607e-08-.158685.0678579-.309795.186459-.41522l4.44445-3.95062 2.66057e-08-2.36506e-08c.210489-.18711.527691-.18711.73818 4.73012e-08l4.44445 3.95067 1.78737e-11 1.5886e-11c.118589.105413.186445.256503.18646.41517v4.93827l-3.55271e-15-2.39098e-11c0 .306827-.248733.55556-.55556.55556Z"></path>
                        </g>
                    </svg>
                </Link>
                <Link to="/profile" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                    <svg version="1.1" className="stroke-current text-gray-700 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2.20912" ry="0"></rect>
                            <path d="M13.5 17v-3.88889h-3v3.88889h-2.94444 -2.42843e-08c-.306827-1.34118e-08-.55556-.248733-.55556-.55556 0 0 0-3.55271e-15 0-3.55271e-15v-4.93827l-6.82121e-13 7.90349e-07c2.39607e-08-.158685.0678579-.309795.186459-.41522l4.44445-3.95062 2.66057e-08-2.36506e-08c.210489-.18711.527691-.18711.73818 4.73012e-08l4.44445 3.95067 1.78737e-11 1.5886e-11c.118589.105413.186445.256503.18646.41517v4.93827l-3.55271e-15-2.39098e-11c0 .306827-.248733.55556-.55556.55556Z"></path>
                        </g>
                    </svg>
                </Link>
                <Link to="/users" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                    <svg version="1.1" className="stroke-current text-gray-700 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2.20912" ry="0"></rect>
                            <path d="M13.5 17v-3.88889h-3v3.88889h-2.94444 -2.42843e-08c-.306827-1.34118e-08-.55556-.248733-.55556-.55556 0 0 0-3.55271e-15 0-3.55271e-15v-4.93827l-6.82121e-13 7.90349e-07c2.39607e-08-.158685.0678579-.309795.186459-.41522l4.44445-3.95062 2.66057e-08-2.36506e-08c.210489-.18711.527691-.18711.73818 4.73012e-08l4.44445 3.95067 1.78737e-11 1.5886e-11c.118589.105413.186445.256503.18646.41517v4.93827l-3.55271e-15-2.39098e-11c0 .306827-.248733.55556-.55556.55556Z"></path>
                        </g>
                    </svg>
                </Link>
                <Link to="/settings" className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                    <svg version="1.1" className="stroke-current text-gray-700 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2.20912" ry="0"></rect>
                            <path d="M13.5 17v-3.88889h-3v3.88889h-2.94444 -2.42843e-08c-.306827-1.34118e-08-.55556-.248733-.55556-.55556 0 0 0-3.55271e-15 0-3.55271e-15v-4.93827l-6.82121e-13 7.90349e-07c2.39607e-08-.158685.0678579-.309795.186459-.41522l4.44445-3.95062 2.66057e-08-2.36506e-08c.210489-.18711.527691-.18711.73818 4.73012e-08l4.44445 3.95067 1.78737e-11 1.5886e-11c.118589.105413.186445.256503.18646.41517v4.93827l-3.55271e-15-2.39098e-11c0 .306827-.248733.55556-.55556.55556Z"></path>
                        </g>
                    </svg>
                </Link>
            </React.Fragment>
        )
    }

    getMobileMenu() {
        return (
            <div className="md:hidden flex flex-row justify-between w-full items-center">
                <Link to="/" onClick={(e) => this.setState({ open: false })} className="text-gray-800 text-2xl font-bold">.Work</Link>
                <div className="flex flex-row space-x-2">
                    <button className="focus:outline-none rounded-md hover:bg-gray-200 p-1" onClick={(e) => { this.setState(state => { return { open: !state.open } }) }}>
                        {this.getMobileMenuIconState()}
                    </button>

                    {this.props.auth.authenticated ? this.getAuthMobileMenu() : (
                        <Link to="/login" onClick={(e) => this.setState({ open: false })} className="focus:outline-none rounded-md hover:bg-gray-200 p-1">
                            <svg version="1.1" className="stroke-current text-gray-700 h-8 w-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                                <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                                    <path d="M9.691 12.093l-1.93 1.934 1.84421e-08-1.85938e-08c-.166755.168127-.260531.395201-.261.632v.947l1.06581e-14 1.3499e-07c7.45531e-08.493743.400258.894.894.894h.951l-4.81956e-08-6.46452e-11c.237349.000318348.464947-.0943942.632-.263l1.926-1.93 2.66388e-07 9.32625e-08c.352754.123499.723277.188687 1.097.193l-6.36993e-08-1.04833e-09c1.96532.032344 3.58474-1.53464 3.61708-3.49995 .032344-1.96532-1.53464-3.58474-3.49995-3.61708 -1.96532-.032344-3.58474 1.53464-3.61708 3.49995 -.00677002.411366.0578383.820791.190954 1.21008Z"></path>
                                    <path d="M13 10.959h-1.79217e-09c-.0226437 9.89786e-10-.041.0183563-.041.041 9.89786e-10.0226437.0183563.041.041.041 .0226437-9.89786e-10.041-.0183563.041-.041v1.79217e-09c0-.0226437-.0183563-.041-.041-.041"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                </g>
                            </svg>
                        </Link>
                    )}
                </div>
            </div >
        )
    }

    getMobileDropdown() {
        if (this.state.open) {
            return (
                <div className="flex flex-col bg-white p-3 md:hidden space-y-2">
                    <Link to="/login" onClick={(e) => this.setState(state => { return { open: !state.open } })} className="bg-gray-800 text-white p-2 w-full rounded text-center">Login</Link>
                    <Link to="/register" onClick={(e) => this.setState(state => { return { open: !state.open } })} className="text-gray-800 border-2 border-gray-800 p-2 w-full rounded text-center">Register</Link>
                </div>
            )
        }
    }

    getDesktopMenu() {
        return (
            <div className="flex-row w-full justify-between items-center hidden md:flex">
                <Link to="/" onClick={(e) => this.setState({ open: false })} className="text-gray-800 text-2xl font-bold">.Work</Link>
                <div className="flex flex-row space-x-2 items-center w-1/4">
                    <Link to="/login" onClick={(e) => this.setState(state => { return { open: !state.open } })} className="bg-gray-800 text-white p-2 w-full rounded text-center hover:bg-gray-700">Login</Link>
                    <Link to="/register" onClick={(e) => this.setState(state => { return { open: !state.open } })} className="text-gray-800 border-2 border-gray-800 p-2 w-full rounded text-center hover:bg-gray-800 hover:text-white">Register</Link>
                </div>
            </div>
        )
    }

    render() {
        return (
            <div className="flex flex-col">
                <div className="flex flex-col bg-white shadow-sm rounded lg:p-4 p-2">
                    {/* mobile menu */}
                    {this.getMobileMenu()}
                    {/* mobile menu */}
                    {this.getDesktopMenu()}
                </div>
                {/* mobile drop down menu */}
                {this.getMobileDropdown()}
                {/* mobile drop down menu */}
            </div>
        )
    }

}

const mapStateToProps = (state) => {
    return {
        auth: state.auth
    }
}

export default connect(mapStateToProps, null)(Navbar);