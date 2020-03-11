@if (session('message'))
<div class="bg-aqua w-screen flex md:hidden justify-between items-center px-2 py-3" x-data="{ removed : false }"
     x-show="!removed">
     <svg id="info" data-name="info" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path id="Path_55" data-name="Path 55" d="M0,0H20V20H0Z" fill="none" />
          <path id="Path_56" data-name="Path 56" d="M11.957,8a.208.208,0,1,0,.209.208A.207.207,0,0,0,11.957,8"
               transform="translate(-1.958 -1.333)" fill="none" stroke="#0b3954" stroke-linecap="round"
               stroke-linejoin="round" stroke-width="1.5" />
          <path id="Path_57" data-name="Path 57"
               d="M10.5,18h0A7.5,7.5,0,0,1,3,10.5H3A7.5,7.5,0,0,1,10.5,3h0A7.5,7.5,0,0,1,18,10.5h0A7.5,7.5,0,0,1,10.5,18Z"
               transform="translate(-0.5 -0.5)" fill="none" stroke="#0b3954" stroke-linecap="round"
               stroke-linejoin="round" stroke-width="1.5" />
          <path id="Path_58" data-name="Path 58" d="M12,12v4.167" transform="translate(-2 -2)" fill="none"
               stroke="#0b3954" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
     </svg>
     <span class="text-jean text-center"> {{ session('message') }} </span>
     <a href="#" x-on:click="removed = true">
          <svg id="delete" data-name="delete" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
               viewBox="0 0 24 24">
               <path id="Path_52" data-name="Path 52" d="M0,0H24V24H0Z" fill="none" />
               <path id="Path_53" data-name="Path 53" d="M8,8l8,8" fill="none" stroke="#323232" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="1.5" />
               <path id="Path_54" data-name="Path 54" d="M16,8,8,16" fill="none" stroke="#323232" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="1.5" />
          </svg>
     </a>
</div>

@endif