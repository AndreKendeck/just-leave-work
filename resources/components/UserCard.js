import { mixin as clickAway } from 'vue-clickaway';
export default Vue.component('user-card', {
    mixins : [ clickAway ],
    props: ['user'],
    data: () => {
        return {
            isOpen: false,
        }
    },
    methods: {
        ontoggleBan() {
            return this.$emit('toggleBan', this.user);
        },
        away : function() {
            this.isOpen = false;
        }
    },
    template: `<div class="card flex-col my-3 p-2 relative w-full lg:w-3/4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img class="rounded-full w-10 md:w-10 lg:w-10"
                        v-bind:src="user.has_avatar ? user.avatar_url : user.avatar_url.encoded" alt="user.name" />
                    <span class="text-gray-600 text-lg lg:text-xl ml-2"> {{ user.name }} </span>
                    <span v-if="user.is_reporter" class="text-xs text-gray-400 ml-1 mt-1"> &bull; Reporter
                    </span>
                </div>
                <button class="bg-gray-100 hover:bg-gray-300 rounded p-1" v-on:click="isOpen = !isOpen" v-on-clickaway="away" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current text-gray-600 h-6 w-6 "
                        viewBox="0 0 24 24" fill="none"  stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" >
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                </button>
                <div class="absolute shadow-2xl p-3 w-1/3 md:w-1/6 lg:w-1/12 bg-white rounded-lg right-0 top-0 z-20" v-bind:class="{ 'hidden' : !isOpen }">
                    <div class="flex flex-col w-full">
                        <a v-bind:href="user.url"
                            class="flex justify-between w-full items-center hover:bg-gray-100 rounded px-2 py-2">
                            <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-6 w-6 text-gray-600"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3.118,12.467c-0.157,-0.291 -0.157,-0.644 0,-0.935c1.892,-3.499 5.387,-6.532 8.882,-6.532c3.495,0 6.99,3.033 8.882,6.533c0.157,0.291 0.157,0.644 0,0.935c-1.892,3.499 -5.387,6.532 -8.882,6.532c-3.495,0 -6.99,-3.033 -8.882,-6.533Z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4286"
                                        d="M14.1213,9.87868c1.17157,1.17157 1.17157,3.07107 0,4.24264c-1.17157,1.17157 -3.07107,1.17157 -4.24264,0c-1.17157,-1.17157 -1.17157,-3.07107 0,-4.24264c1.17157,-1.17157 3.07107,-1.17157 4.24264,0">
                                    </path>
                                </g>
                            </svg>
                            <span class="text-gray-600"> View </span>
                        </a>

                        <a v-bind:href="user.edit_url"
                            class="flex justify-between w-full items-center hover:bg-gray-100 rounded px-2 py-2">
                            <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-6 w-6 text-gray-600"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                                    <path
                                        d="M21,11v8c0,1.105 -0.895,2 -2,2h-14c-1.105,0 -2,-0.895 -2,-2v-14c0,-1.105 0.895,-2 2,-2h7">
                                    </path>
                                    <path
                                        d="M9,15l3.15,-0.389c0.221,-0.027 0.427,-0.128 0.585,-0.285l7.631,-7.631c0.845,-0.845 0.845,-2.215 0,-3.061v0c-0.845,-0.845 -2.215,-0.845 -3.061,0l-7.56,7.56c-0.153,0.153 -0.252,0.351 -0.283,0.566l-0.462,3.24Z">
                                    </path>
                                </g>
                            </svg>
                            <span class="text-gray-600"> Edit </span>
                        </a>

                        <a href="#" v-on:click="toggleBan()" v-if="!user.is_banned"
                            class="flex justify-between w-full items-center hover:bg-gray-100 rounded px-2 py-2">
                            <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-6 w-6 text-gray-600"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M18.364,5.636l-12.728,12.728l12.728,-12.728Z"></path>
                                    <path  stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M12,3v0c-4.971,0 -9,4.029 -9,9v0c0,4.971 4.029,9 9,9v0c4.971,0 9,-4.029 9,-9v0c0,-4.971 -4.029,-9 -9,-9Z">
                                    </path>
                                </g>
                            </svg>
                            <span class="text-gray-600"> Ban </span>
                        </a>

                        <a href="#" v-on:click="toggleBan()" v-if="user.is_banned"
                            class="flex justify-between w-full items-center hover:bg-gray-100 rounded px-2 py-2">
                            <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-6 w-6 text-gray-600"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g fill="none">
                                    <path stroke="#323232" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M18.364,5.636l-12.728,12.728l12.728,-12.728Z"></path>
                                    <path stroke="#323232" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M12,3v0c-4.971,0 -9,4.029 -9,9v0c0,4.971 4.029,9 9,9v0c4.971,0 9,-4.029 9,-9v0c0,-4.971 -4.029,-9 -9,-9Z">
                                    </path>
                                </g>
                            </svg>
                            <span class="text-gray-600"> Remove Ban </span>
                        </a>

                    </div>
                </div>
            </div>
            <div class="flex items-center mt-4 w-full justify-between">
                <div class="flex bg-gray-100 rounded-lg px-2 justify-center text-xs">
                    <span class="text-gray-600 font-bold"> Leaves Taken </span>
                    <span class="text-gray-600 text-center ml-2">{{ user.total_days_on_leave }}</span>
                </div>
                <div class="flex">
                    <span v-if="user.is_on_leave" class="bg-blue-200 text-blue-600 text-xs  px-2 rounded-lg mx-1"> On
                        leave </span>
                    <span v-if="user.is_banned"
                        class="bg-red-200 text-red-600 text-xs px-2 rounded-lg mx-1 ">banned</span>
                </div>
            </div>
        </div>`
});
