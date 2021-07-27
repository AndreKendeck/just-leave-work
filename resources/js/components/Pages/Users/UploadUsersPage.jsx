import React from 'react';
import { connect } from 'react-redux';
import api from '../../../api';
import Button from '../../Button';
import Card from '../../Card';
import Field from '../../Form/Field';
import Heading from '../../Heading';
import Page from '../../Page';

const UploadUsersPage = class UploadUsersPage extends React.Component {


    state = {
        file: null,
        errors: [],
        message: null,
    }

    isCorrectFile() {
        return this.state.file && this.state.errors.length === 0;
    }

    setFile(e) {
        e.persist();
        this.setState({ errors: [] });
        this.setState({ file: e.target.files[0] });
        if (e.target.files[0].type !== 'text/csv') {
            this.setState({ errors: ['Please upload a .csv File'] });
        }

    }

    onUpload() {
        let formData = new FormData();
        formData.append('users', this.state.file);
        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        };
        api.post('/users/import', formData, config)
            .then(success => {
                
            }).catch(failed => {

            });
    }

    renderButton() {
        if (this.isCorrectFile()) {
            return (
                <Button onClick={(e) => this.onUpload()} type="secondary">Upload Users</Button>
            )
        }
        return null;
    }

    render() {
        return (
            <Page className="flex flex-col justify-center space-y-2">
                <Card className="hidden md:flex w-full md:w-3/2 lg:w-1/2 self-center space-y-4">
                    <span className="text-white bg-purple-500 px-2 py-1 text-center rounded-full text-xs mt-2 self-end">Upload Users</span>
                    <div className="text-lg text-gray-700">How to Upload users:</div>
                    <div className="flex flex-col space-y-2">
                        <div className="text-gray-700 bg-gray-200 p-2 rounded-lg ">
                            1. Create a .CSV file
                        </div>
                        <div className="text-gray-700 bg-gray-200 p-2 rounded-lg ">
                            2. Have 3 Columns in this exact order for the following value [name,email,balance]
                        </div>
                    </div>
                    <div className="flex flex-row space-x-2 items-center">
                        <Field type="file" errors={this.state.errors} onChange={(e) => this.setFile(e)} name="users" label="Upload Users" tip="Choose a .csv file" />
                        {this.renderButton()}
                    </div>
                </Card>
                <Card className="w-full md:hidden lg:hidden self-center space-y-4">
                    <Heading>Uploading Users is Only Available on Desktop</Heading>
                </Card>
            </Page>
        );
    }

}

export default connect()(UploadUsersPage);