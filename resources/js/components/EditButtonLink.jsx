import React from 'react';
import { Link } from 'react-router-dom';


const EditButtonLink = ({ url }) => {
    return <Link to={url} className="bg-gray-300 rounded p-1 focus:outline-none hover:bg-gray-200">
        <svg id="Layer_3" className="stroke-current h-6 w-6 text-gray-600" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M21,12v4a5,5,0,0,1-5,5H8a5,5,0,0,1-5-5V8A5,5,0,0,1,8,3h4" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
            <path d="M17.37955,3.62025a2.11953,2.11953,0,0,1,2.99908.00268h0a2.12064,2.12064,0,0,1-.00039,2.99981c-.00064-.00064-4.1761,4.17463-5.62,5.61846a1.99163,1.99163,0,0,1-1.167.56861l-1.4778.18251a.99172.99172,0,0,1-1.10331-1.12443l.21863-1.531a1.9814,1.9814,0,0,1,.56085-1.12662C12.80012,8.19931,15.26954,5.72978,17.37955,3.62025Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
        </svg>
    </Link>
}

export default EditButtonLink;