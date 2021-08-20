
import React from 'react';
import { connect } from 'react-redux';
import Error from '../messages/Error';
import Info from '../messages/Info';
import DesktopMenu from './DesktopMenu';
import MobileMenu from './MobileMenu';

const Navbar = class Navbar extends React.Component {

    renderMessage() {
        const { message } = this.props;
        if (message) {
            return <Info message={message} />
        }
    }

    renderErrorMessage() {

    }

    render() {
        return (
            <div className="flex flex-col bg-purple-300 md:pb-6 border-b-8 border-purple-600">
                <DesktopMenu />
                <MobileMenu />
            </div>
        )
    }

}
const mapStateToProps = (state) => {
    const { messages, errorMessages: errors } = state;
    return {
        messages,
        errors
    }
}
export default connect(mapStateToProps, null)(Navbar);