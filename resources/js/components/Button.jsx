import React from 'react';

const Button = (props) => {
    switch (props.type) {
        default:
            return <button className="focus:outline-none bg-gray-800 text-white p-2 w-full rounded text-center hover:bg-gray-700" ></button>
    }
}