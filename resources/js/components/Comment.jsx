import React from 'react';
import Button from './Button';
import UserBadge from './UserBadge';

const Comment = ({ comment, onDelete, onUpdate }) => {
    return (
        <div className="flex flex-col space-y-2 w-full md:w-3/2 lg:w-1/2 self-center space-y-4 bg-white border-2 border-gray-500 rounded p-3">
            <div className="flex flex-col space-y-2">
                <div className="flex flex-row w-full justify-between">
                    <UserBadge user={leave?.user} imageSize={8} />
                    <div className="flex flex-row space-x-1 w-full">
                        <Button type="soft">
                            <svg id="Layer_3" className="stroke-current h-6 w-6 text-gray-600" data-name="Layer 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M21,12v4a5,5,0,0,1-5,5H8a5,5,0,0,1-5-5V8A5,5,0,0,1,8,3h4" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" />
                                <path d="M17.37955,3.62025a2.11953,2.11953,0,0,1,2.99908.00268h0a2.12064,2.12064,0,0,1-.00039,2.99981c-.00064-.00064-4.1761,4.17463-5.62,5.61846a1.99163,1.99163,0,0,1-1.167.56861l-1.4778.18251a.99172.99172,0,0,1-1.10331-1.12443l.21863-1.531a1.9814,1.9814,0,0,1,.56085-1.12662C12.80012,8.19931,15.26954,5.72978,17.37955,3.62025Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                            </svg>
                        </Button>
                        <Button type="soft">
                            <svg version="1.1" className="stroke-current h-6 w-6 text-gray-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                                    <path d="M18 6.53h1"></path>
                                    <path d="M9 10.47v6.06"></path>
                                    <path d="M12 9.31v8.27"></path>
                                    <path d="M15 10.47v6.06"></path>
                                    <path d="M15.795 20.472h-7.59c-1.218 0-2.205-.987-2.205-2.205v-11.739h12v11.739c0 1.218-.987 2.205-2.205 2.205Z"></path>
                                    <path d="M16 6.528l-.738-2.305c-.133-.414-.518-.695-.952-.695h-4.62c-.435 0-.82.281-.952.695l-.738 2.305"></path>
                                    <path d="M5 6.53h1"></path>
                                </g>
                            </svg>
                        </Button>
                    </div>
                </div>
                <div className="text-gray-600 text-sm w-full">{moment(leave?.createdAt).fromNow()}</div>
            </div>
            <div className="text-gray-600 text-base">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab tempore, voluptatum molestiae laborum rem blanditiis commodi quae enim possimus mollitia, consequatur sunt voluptatibus id, repudiandae nulla dolorum ea quidem maxime.
            </div>
        </div>
    );
}