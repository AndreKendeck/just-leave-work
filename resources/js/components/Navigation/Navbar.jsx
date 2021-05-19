
import React from 'react';
import { connect } from 'react-redux';
import DesktopMenu from './DesktopMenu';
import MobileMenu from './MobileMenu';

const Navbar = class Navbar extends React.Component {

    render() {
        return (
            <div className="flex flex-col">
                <DesktopMenu />
                <MobileMenu />
            </div>
        )
    }

}

const mapStateToProps = (state) => {
    return {
        auth: state.auth,
        team: state.team,
        user: state.user
    }
}

export default connect(mapStateToProps, null)(Navbar);