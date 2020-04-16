@auth
<div x-data="{ showNotifications : false }" x-on:click.away="showNotifications = false">
    <div
        class="flex shadow-xs md:shadow-none justify-between items-center w-screen md:px-2 md:py-3 px-2 py-2 bg-white ">
        <a href="{{ route('index') }}" class="flex items-center">
            <img src="{{ Auth::user()->team->logo_url }}" class="w-8 h-8 mr-4" alt="organization_avatar">
            <h3 class="text-gray-600 text-xs md:text-lg hidden md:block"> {{ Auth::user()->team->name }} </h3>
        </a>
        <div class="flex justify-between md:justify-around items-center text-gray-700">

            <a href="{{ route('index') }}" class="md:flex mx-2 hover:bg-gray-200 px-2 py-1 rounded justify-center">
                <svg version="1.1" viewBox="0 0 24 24" class="stroke-current text-gray-600 h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-width="1.5" fill="none">
                        <path
                            d="M19.842,8.299l-6,-4.667c-1.083,-0.843 -2.6,-0.843 -3.684,0l-6,4.667c-0.731,0.568 -1.158,1.442 -1.158,2.368v7.333c0,1.657 1.343,3 3,3h12c1.657,0 3,-1.343 3,-3v-7.333c0,-0.926 -0.427,-1.8 -1.158,-2.368Z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9,17h6"></path>
                    </g>
                </svg>
            </a>

            <a href="{{ route('leaves.index') }}"
                class="md:flex mx-2 hover:bg-gray-200 px-2 py-1 rounded justify-center">
                <svg version="1.1" class="stroke-current text-gray-600 w-6 h-6" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                        <path
                            d="M18.383,8h1.061c0.86,0 1.556,0.696 1.556,1.556v9.889c0,0.859 -0.696,1.555 -1.556,1.555h-10.888c-0.86,0 -1.556,-0.696 -1.556,-1.556v-1.444">
                        </path>
                        <path
                            d="M4.001,18h11.312c0.669,0 1.293,-0.334 1.664,-0.891l0.734,-1.102c0.438,-0.657 0.672,-1.429 0.672,-2.219v-7.788c0,-1.105 -0.895,-2 -2,-2h-10c-1.105,0 -2,0.895 -2,2v7.056c0,0.621 -0.145,1.233 -0.422,1.789l-0.854,1.708c-0.333,0.665 0.151,1.447 0.894,1.447Z">
                        </path>
                        <path d="M8.38,3v2"></path>
                        <path d="M14.38,3v2"></path>
                        <path d="M8.19,9h6"></path>
                        <path d="M8.19,13h6"></path>
                    </g>
                </svg>
            </a>

            @role('reporter')
            <a href="{{ route('users.index') }}"
                class="md:flex mx-2 hover:bg-gray-200 px-2 py-1 rounded justify-center">
                <svg version="1.1" viewBox="0 0 24 24" class="stroke-current text-gray-600 h-6 h-6"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                        <path
                            d="M20.7925,9.52352c0.790031,0.790031 0.790031,2.07092 0,2.86095c-0.790031,0.790031 -2.07092,0.790031 -2.86095,1.77636e-15c-0.790031,-0.790031 -0.790031,-2.07092 0,-2.86095c0.790031,-0.790031 2.07092,-0.790031 2.86095,-1.77636e-15">
                        </path>
                        <path
                            d="M14.2026,5.91236c1.21648,1.21648 1.21648,3.18879 0,4.40528c-1.21648,1.21648 -3.18879,1.21648 -4.40528,0c-1.21648,-1.21648 -1.21648,-3.18879 0,-4.40528c1.21648,-1.21648 3.18879,-1.21648 4.40528,0">
                        </path>
                        <path
                            d="M6.06848,9.52352c0.790031,0.790031 0.790031,2.07092 0,2.86095c-0.790031,0.790031 -2.07092,0.790031 -2.86095,1.77636e-15c-0.790031,-0.790031 -0.790031,-2.07092 0,-2.86095c0.790031,-0.790031 2.07092,-0.790031 2.86095,-1.77636e-15">
                        </path>
                        <path d="M23,19v-1.096c0,-1.381 -1.119,-2.5 -2.5,-2.5h-0.801"></path>
                        <path d="M1,19v-1.096c0,-1.381 1.119,-2.5 2.5,-2.5h0.801"></path>
                        <path
                            d="M17.339,19v-1.601c0,-1.933 -1.567,-3.5 -3.5,-3.5h-3.679c-1.933,0 -3.5,1.567 -3.5,3.5v1.601">
                        </path>
                    </g>
                </svg>
            </a>
            @endrole


            @role('reporter')
            <a href="{{ route('teams.index') }}"
                class="md:flex mx-2 hover:bg-gray-200 px-2 py-1 rounded justify-center">
                <svg version="1.1" viewBox="0 0 24 24" class="stroke-current text-gray-600 h-6 h-6"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.225,6.452v0c0,-1.532 1.242,-2.775 2.775,-2.775v0c1.532,0 2.775,1.242 2.775,2.775v0c0,1.532 -1.242,2.775 -2.775,2.775v0c-1.533,-0.002 -2.775,-1.244 -2.775,-2.775Z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M2.5,17.548v0c0,-1.532 1.242,-2.775 2.775,-2.775v0c1.532,0 2.775,1.242 2.775,2.775v0c-0.001,1.532 -1.242,2.775 -2.775,2.775v0c-1.533,3.55271e-15 -2.775,-1.242 -2.775,-2.775Z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15.951,17.548v0c0,-1.532 1.242,-2.775 2.775,-2.775v0c1.532,0 2.775,1.242 2.775,2.775v0c0,1.532 -1.242,2.775 -2.775,2.775v0c-1.534,3.55271e-15 -2.775,-1.242 -2.775,-2.775Z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8.49,11.92l-2.01,3.14"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13.5,8.78l2.01,3.14"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.95,17.55h-3.95">
                        </path>
                    </g>
                </svg>
            </a>
            @endrole


            <div class="relative flex mx-2 md:hover:bg-gray-200 md:p-1 rounded">
                <a href="#" x-on:click="showNotifications = !showNotifications; axios.get('/notifications-read'); ">
                    <svg id="Bell_Notification" data-name="Bell, Notification"
                        class="stroke-current stroke-0 w-6 h-6 text-gray-600 md:text-gray-600"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                        <g id="Group_22" data-name="Group 22" transform="translate(5.938 3.75)">
                            <path id="Path_48" data-name="Path 48"
                                d="M9.708,18.344V18.8a2.864,2.864,0,0,0,2.865,2.864h0A2.865,2.865,0,0,0,15.438,18.8v-.456"
                                transform="translate(-3.511 0.836)" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                            <path id="Path_49" data-name="Path 49"
                                d="M14.75,6.439V5.291A2.291,2.291,0,0,0,12.458,3h0a2.291,2.291,0,0,0-2.291,2.291V6.439"
                                transform="translate(-3.396 -3)" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                            <path id="Path_50" data-name="Path 50"
                                d="M7.016,11.321h0A5.664,5.664,0,0,1,12.68,5.657h2.266a5.664,5.664,0,0,1,5.664,5.664h0v3.5a2.5,2.5,0,0,0,.733,1.768l.8.8a2.5,2.5,0,0,1,.733,1.768h0a2.362,2.362,0,0,1-2.362,2.362H7.113A2.362,2.362,0,0,1,4.75,19.153h0a2.5,2.5,0,0,1,.733-1.767l.8-.8a2.5,2.5,0,0,0,.733-1.767v-3.5Z"
                                transform="translate(-4.75 -2.336)" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </g>
                        <path id="Path_51" data-name="Path 51" d="M0,0H30V30H0Z" fill="none" />
                    </svg>
                    @if (Auth::user()->unreadNotifications->count() > 0)
                    <span
                        class="absolute bg-red-700 text-white rounded-full opacity-75 px-1 text-sm notification-ballon">
                        @if (Auth::user()->unreadNotifications->count() > 99)
                        99 +
                        @else
                        {{ Auth::user()->unreadNotifications->count() }}
                        @endif
                    </span>
                    @endif
                </a>

            </div>

            <a href="{{ route('profile') }}" class="md:flex rounded-lg">
                <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full mx-1" alt="avatar">
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mx-2 hidden md:block" >
                @csrf
                <button class="bg-red-300 border-red-600 p-2 text-sm hover:bg-red-400" type="submit">
                    <svg version="1.1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        class="stroke-current text-red-600 w-3 h-3" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17.657,6.343c3.124,3.124 3.124,8.19 0,11.314c-3.124,3.124 -8.19,3.124 -11.314,0c-3.124,-3.124 -3.124,-8.19 0,-11.314">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12,4v8">
                            </path>
                        </g>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <div x-bind:class="{ 'hidden' : !showNotifications }"
        class="animated fadeIn faster notification-modal flex flex-col w-10/12 md:mx-0 bg-white mt-12 px-4 py-2 rounded-lg lg:w-1/4 md:w-7/12  rounded absolute z-10 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="text-jean text-center text-lg tracking-widest">Notifcations</div>
            <button class="p-1 rounded hover:bg-gray-200 " x-on:click="showNotifications = false">
                <svg version="1.1" class="h-8 w-8 stroke-current text-blue-800" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8,8l8,8">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16,8l-8,8">
                        </path>
                    </g>
                </svg>
            </button>
        </div>
        <div class="flex flex-col overflow-y-scroll p-3">
            @if (Auth::user()->unreadNotifications->count() > 0)
            @foreach ( Auth::user()->unreadNotifications as $notification)
            <a href="{{ $notification->data['url'] ?? '#' }}"
                class="hover:bg-gray-200 rounded my-2 p-3 md:p-2 border border-gray-300 flex flex-col justify-between">
                <span class="text-sm text-gray-600 my-2"> {{ $notification->created_at->diffForHumans() }} </span>
                <span class="my-2"> {{ $notification->data['text'] }} </span>
            </a>
            @endforeach
            @else
            <h3 class="text-gray-400 text-lg tracking-wide my-6 text-center"> No new notifications. </h3>
            @endif
        </div>
        <a href="{{ route('notifications.index') }}"
            class="w-32 text-right text-jean justify-around self-end flex rounded hover:bg-gray-200 p-1">
            <span> View all </span>
            <svg version="1.1" class="stroke-current h-6 w-6 text-jean " viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

                <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                    <path d="M19,12h-14"></path>
                    <path d="M14,17l5,-5"></path>
                    <path d="M14,7l5,5"></path>
                </g>
            </svg>
        </a>
    </div>
</div>
@endauth
