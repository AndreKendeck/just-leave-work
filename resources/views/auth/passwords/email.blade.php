@extends('layouts.web')
@section('title')
Request a new password
@endsection
@section('content')
<div class="flex flex-col items-center h-screen mx-4 mt-16">
     <div class="card flex flex-col px-2 py-8 w-full md:w-3/4 lg:w-1/2 self-center">
          <h3 class="text-xl text-gray-600 text-center"> Reset your password  </h3>
          <form action="{{ route('password.email') }}" method="POST" class="flex flex-col">
               @csrf
               @field(['name' => 'email' , 'label' => 'Email Address' , 'required' => true , 'type' => 'email' ])
               <button class="bg-jean hover:bg-black rounded-lg px-4 mt-6 p-2 w-1/2 lg:w-1/4 self-center">
                    Send email
               </button>
               <a href="{{ route('login') }}"
                    class="flex justify-center items-center p-2 bg-gray-400 rounded-lg mt-2 w-1/2 lg:w-1/4 self-center hover:bg-gray-500">
                    <span class="mx-1">
                         <svg version="1.1" class="stroke-current text-gray-600 w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink">
                              <g stroke-linecap="round" stroke-width="2" fill="none"
                                   stroke-linejoin="round">
                                   <path d="M5,12h14"></path>
                                   <path d="M10,7l-5,5"></path>
                                   <path d="M10,17l-5,-5"></path>
                              </g>
                         </svg>
                    </span>
                    <span class="text-gray-700 mx-1 whitespace-no-wrap">
                         Back to login
                    </span>
               </a>
          </form>
     </div>
</div>
@endsection