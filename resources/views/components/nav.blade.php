@auth
<div class="flex justify-between items-center w-screen px-4 py-8 md:py-4 md:bg-white ">
     <div class="flex items-center text-jean md:text-gray-700">
          <h3 class="tracking-widest text-xl"> {{ Auth::user()->team->name  }} - @yield('heading') </h3>
     </div>

     <div class="flex justify-around items-center text-gray-700">

          <a href="{{ route('index') }}" class="hidden md:flex mx-4 hover:bg-gray-200 px-2 py-1 rounded-lg">
               Home
          </a>

          <a href="{{ route('leaves.index') }}" class="hidden md:flex mx-4 hover:bg-gray-200 px-2 py-1 rounded-lg">
               Leaves
          </a>

          <a href="{{ route('users.index') }}" class="hidden md:flex mx-4 hover:bg-gray-200 px-2 py-1 rounded-lg">
               Users
          </a>

          <div class="relative flex md:mx-4 md:hover:bg-gray-200 md:p-1 md:rounded-lg">
               <a href="{{ route('notifications.index') }}">
                    <svg id="Bell_Notification" data-name="Bell, Notification"
                         class="stroke-current stroke-0 w-8 h-8 text-gray-800 md:text-gray-700"
                         xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
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

          <a href="{{ route('profile') }}">
               <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full mx-3" alt="avatar">
          </a>

          <form action="{{ route('logout') }}" method="POST">
               @csrf
               <button class="bg-red-600 text-red mx-3 text-sm hover:bg-red-800" type="submit">
                    <svg version="1.1" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg" class="stroke-current text-white w-3 h-3" xmlns:xlink="http://www.w3.org/1999/xlink">
                         
                         <g fill="none">
                              <path  stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                   d="M17.657,6.343c3.124,3.124 3.124,8.19 0,11.314c-3.124,3.124 -8.19,3.124 -11.314,0c-3.124,-3.124 -3.124,-8.19 0,-11.314">
                              </path>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                   d="M12,4v8"></path>
                         </g>
                    </svg>
               </button>
          </form>
     </div>
</div>
@endauth