@extends('layouts.web')
@section('title' , 'Welcome' )
@section('content')
<div class="flex flex-col h-screen w-screen mx-auto items-center">
     <div class="self-center">
          <img src="{{ asset('images/man@2x.png') }}" class="md:hidden h-64" alt="man">
     </div>
     <div class="text-center text-black text-3xl px-3">
          You deserve a day off.
     </div>
     <div class="text-center text-gray-600 mt-4 px-5">
          justleave.work
          Is a web-based leave management
          app without the fuss.
     </div>
     <div class="mt-20 flex flex-col justify-between ">
          <a href="{{ route('register') }}" class="py-3 px-2 text-white bg-jean rounded-lg flex justify-between">
               <span class="mx-2">Get started</span>
               <svg id="Arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g id="Group_1" data-name="Group 1">
                         <path id="Path_1" data-name="Path 1" d="M19,12H5" fill="none" stroke="#fafafa"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                         <path id="Path_2" data-name="Path 2" d="M14,17l5-5" fill="none" stroke="#fafafa"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                         <path id="Path_3" data-name="Path 3" d="M14,7l5,5" fill="none" stroke="#fafafa"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                    </g>
                    <path id="Path_4" data-name="Path 4" d="M0,0H24V24H0Z" fill="none" />
               </svg>
          </a>

          <a href="{{ route('login') }}" class="py-3 px-2 text-white bg-gray-800 rounded-lg flex justify-between mt-2
          hover:bg-gray-900">
               <span class="mx-2">Login</span>
               <svg id="Lock" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g id="Group_10" data-name="Group 10">
                         <path id="Path_6" data-name="Path 6"
                              d="M17,21H7a2,2,0,0,1-2-2V11A2,2,0,0,1,7,9H17a2,2,0,0,1,2,2v8A2,2,0,0,1,17,21Z"
                              fill="none" stroke="#fafafa" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.5" />
                         <path id="Path_7" data-name="Path 7" d="M12,17.09V14.5" fill="none" stroke="#fafafa"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                         <path id="Path_8" data-name="Path 8" d="M12.53,13.22a.75.75,0,1,1-1.061,0,.75.75,0,0,1,1.061,0"
                              fill="none" stroke="#fafafa" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.5" />
                         <path id="Path_9" data-name="Path 9" d="M8,9V7H8a4,4,0,0,1,4-4h0a4,4,0,0,1,4,4h0V9" fill="none"
                              stroke="#fafafa" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                    </g>
                    <path id="Path_10" data-name="Path 10" d="M0,0H24V24H0Z" fill="none" />
               </svg>
          </a>
     </div>
</div>
@endsection