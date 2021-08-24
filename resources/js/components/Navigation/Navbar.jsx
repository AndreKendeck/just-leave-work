
import React from 'react';
import { connect } from 'react-redux';
import { clearMessages } from '../../actions/messages';
import Error from '../messages/Error';
import Info from '../messages/Info';
import DesktopMenu from './DesktopMenu';
import MobileMenu from './MobileMenu';

const Navbar = class Navbar extends React.Component {

    renderMessage() {
        const { message } = this.props;
        if (message) {
            return <Info message={message} onClose={(e) => { this.props.clearMessages() }} />
        }
    }

    renderErrorMessage() {
        const { error } = this.props;
        if (error) {
            return <Error message={error} onClose={(e) => { this.props.clearMessages() }} />
        }
    }

    render() {
        return (
            <div className="flex flex-col bg-purple-300 md:pb-6 border-b-8 border-purple-600">
                {this.renderMessage()}
                {this.renderErrorMessage()}
                <DesktopMenu />
                <MobileMenu />
            </div>
        )
    }

}
const mapStateToProps = (state) => {
    const { message, errorMessage: error } = state;
    return {
        message,
        error
    }
}


export default connect(mapStateToProps, { clearMessages })(Navbar);