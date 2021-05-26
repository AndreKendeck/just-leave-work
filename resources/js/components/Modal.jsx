import React, { useEffect } from 'react';
import { useState } from 'react';
import ReactDOM from 'react-dom';
import Button from './Button';
import Card from './Card';
import Heading from './Heading';


const Modal = ({ heading, show = true, children, onClose }) => {
    /** Set the default state */
    const [visible, setVisible] = useState(show);

    if (visible) {
        return (
            ReactDOM.createPortal(
                <div className="absolute bg-gray-800 bg-opacity-25 h-screen w-screen z-10">
                    <div className="flex flex-col justify-center items-center w-screen h-screen">
                        <div className="w-11/12 lg:w-1/2">
                            <Card>
                                <div className="flex w-full justify-between">
                                    <Heading>{heading}</Heading>
                                    <button onClick={(e) => { setVisible(false); }} className="focus:outline-none hover:bg-gray-200 rounded p-1">
                                        <svg version="1.1" className="stroke-current h-6 w-6 text-gray-800" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 8l8 8"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8l-8 8"></path>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                                {children}
                            </Card>
                        </div>
                    </div>
                </div >,
                document.getElementById('modal')
            )
        );
    }
    return null;
}

export default Modal;