@extends('layouts.web')
@section('title')
Verify your account
@endsection
@section('heading')
Verify your account
@endsection
@section('content')
<div class="flex flex-col h-screen mx-2">
     <div class="card p-3 mt-10 w-full md:w-3/4 lg:w-1/2 self-center flex flex-col md:flex-row">

          <div class="flex justify-center flex-col">
              {!! file_get_contents(asset('images/svg/email.svg')) !!}
          </div>
          <form action="{{ action('Auth\VerificationController@resend') }}"
               class="mt-4 flex flex-col w-full items-center justify-center" method="POST">
               @csrf
               <h4 class="text-xl text-gray-600 tracking-wide md:block mb-4 text-center"> Please verify your email address </h4>
               <button class="bg-gray-300 hover:bg-gray-400 text-gray-600 self-center items-center flex justify-between" type="submit"> <span> Resend Email </span>
                    <svg class="stroke-current w-6 h-6 text-gray-600 mx-1" version="1.1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink">
                              <g fill="none">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8,8.028h-3.211c-0.988,0 -1.789,0.801 -1.789,1.789c0,0.593 0.294,1.148 0.785,1.481l5.957,4.037c1.364,0.924 3.153,0.924 4.517,0l5.955,-4.036c0.492,-0.333 0.786,-0.888 0.786,-1.481v-0.001c0,-0.988 -0.801,-1.789 -1.789,-1.789h-3.211">
                                   </path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3,9.833v9.195c0,1.105 0.895,2 2,2h14c1.105,0 2,-0.895 2,-2v-9.195"></path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3.558,20.415l5.524,-5.524"></path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M14.916,14.89l5.524,5.524"></path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M11.999,3.028v6.946"></path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13.999,5.028l-2,-2l-2,2"></path>
                              </g>
                         </svg>
               </button>
               <p class="text-gray-400 text-center text-md tracking-wide mt-4"> Check your inbox (maybe in SPAM) we've sent a verification email </p>

          </form>
     </div>
</div>
@endsection
