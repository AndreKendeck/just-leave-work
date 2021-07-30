import React from 'react';
import { connect } from 'react-redux';
import Card from '../Card';
import Page from '../Page';


const SettingPage = class SettingPage extends React.Component {

    
    render() {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="flex flex-col space-y-4 w-full lg:w-1/2 self-center pointer-cursor">
                    <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs self-start">Settings</span>

                </Card>
            </Page>
        )
    }

}


export default connect(null, null)(SettingPage);