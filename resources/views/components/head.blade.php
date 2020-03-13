@auth
<div class="flex justify-between items-end w-screen px-8 py-8 md:hidden">
     <h3 class="text-blue-700 text-xl font-bold tracking-wide"> @yield('heading') </h3>
     <div class="flex justify-around items-center">
          <a href="{{ route('profile') }}">
               <img src="https://api.adorable.io/avatars/285/abott@adorable.png" class="h-8 w-8 rounded-full mx-3"
                    alt="avatar">
          </a>
          <div class="relative flex">
               <svg id="Bell_Notification" data-name="Bell, Notification" xmlns="http://www.w3.org/2000/svg" width="30"
                    height="30" viewBox="0 0 30 30">
                    <g id="Group_22" data-name="Group 22" transform="translate(5.938 3.75)">
                         <path id="Path_48" data-name="Path 48"
                              d="M9.708,18.344V18.8a2.864,2.864,0,0,0,2.865,2.864h0A2.865,2.865,0,0,0,15.438,18.8v-.456"
                              transform="translate(-3.511 0.836)" fill="none" stroke="#717171" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" />
                         <path id="Path_49" data-name="Path 49"
                              d="M14.75,6.439V5.291A2.291,2.291,0,0,0,12.458,3h0a2.291,2.291,0,0,0-2.291,2.291V6.439"
                              transform="translate(-3.396 -3)" fill="none" stroke="#717171" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" />
                         <path id="Path_50" data-name="Path 50"
                              d="M7.016,11.321h0A5.664,5.664,0,0,1,12.68,5.657h2.266a5.664,5.664,0,0,1,5.664,5.664h0v3.5a2.5,2.5,0,0,0,.733,1.768l.8.8a2.5,2.5,0,0,1,.733,1.768h0a2.362,2.362,0,0,1-2.362,2.362H7.113A2.362,2.362,0,0,1,4.75,19.153h0a2.5,2.5,0,0,1,.733-1.767l.8-.8a2.5,2.5,0,0,0,.733-1.767v-3.5Z"
                              transform="translate(-4.75 -2.336)" fill="none" stroke="#717171" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" />
                    </g>
                    <path id="Path_51" data-name="Path 51" d="M0,0H30V30H0Z" fill="none" />
               </svg>
               @if (Auth::user()->unreadNotifications->count() > 0)
               <span class="absolute bg-red-700 text-white rounded-full opacity-75 px-1 text-sm notification-ballon">
                    @if (Auth::user()->unreadNotifications->count() > 99)
                    99 +
                    @else
                    {{ Auth::user()->unreadNotifications->count() }}
                    @endif
               </span>
               @endif
          </div>
     </div>
</div>
@endauth