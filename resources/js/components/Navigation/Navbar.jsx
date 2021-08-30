
import React from 'react';
import { connect } from 'react-redux';
import { clearMessages } from '../../actions/messages';
import DesktopMenu from './DesktopMenu';
import MobileMenu from './MobileMenu';

const Navbar = class Navbar extends React.Component {
    render() {
        return (
            <div className="flex flex-col bg-purple-300 md:pb-6 border-b-8 border-purple-600">
                <DesktopMenu />
                <MobileMenu />
            </div>
        )
    }

}


export default Navbar;