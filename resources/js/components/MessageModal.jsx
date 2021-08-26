import React from 'react';
import { connect } from 'react-redux';
import { clearMessages } from '../actions/messages';
import InfoMessage from './InfoMessage';
import ReactDOM from 'react-dom';
import ErrorMessage from './ErrorMessage';

const MessageModal = class MessageModal extends React.Component {

    state = {
        open: false
    }

    close() {
        this.setState({ open: false });
    }

    render() {
        const { message, errorMessage } = this.props;
        if (message || errorMessage) {
            return ReactDOM.createPortal(
                <div className="absolute bg-gray-800 bg-opacity-25 w-full z-20" style={{ height: '120%' }} onClick={(e) => { setVisible(false); onClose(e) }}>
                    <div className="flex flex-col justify-center items-center w-full h-full">
                        <div className="flex justify-center w-full lg:w-1/2 px-2" onClick={(e) => e.stopPropagation()}>
                            {message ? <InfoMessage text={message} onDismiss={(e) => this.props.clearMessages()} /> : null}
                            {errorMessage ? <ErrorMessage text={errorMessage} onDismiss={(e) => this.props.clearMessages()} /> : null}
                        </div>
                    </div>
                </div>
                , document.getElementById('message-modal'))
        }
        return null;
    }
}

const mapStateToProps = (state) => {
    const { message, errorMessage } = state;
    return {
        message,
        errorMessage
    }
}

export default connect(mapStateToProps, { clearMessages })(MessageModal);