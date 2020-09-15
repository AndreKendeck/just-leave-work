@extends('layouts.web')
@section('title')
Login
@endsection
@section('content')
<div class="w-full flex flex-col">
     <div class="p-3 w-full flex flex-col items-center justify-center mt-20">
          <form action="{{ route('login') }}" class="w-full flex flex-col items-center" method="post">
               @csrf
               <div class="w-full lg:w-1/2">
                    <x-field name="email" type="email" required="true" label="Email Address"></x-field>
               </div>
               <div class="w-full lg:w-1/2 mt-2">
                    <x-field name="password" type="password" required="true" label="Password "></x-field>
               </div>
               <div class="w-full lg:w-1/2 mt-4 flex flex-col lg:flex-row">
                    <button class="bg-teal-500 p-3 text-white flex items-center w-full lg:w-1/4 hover:bg-teal-400 justify-center">
                         Login
                    </button>
                    <button
                         class="bg-gray-700 p-3 mt-2 lg:mt-0 lg:ml-2 text-white flex items-center w-full lg:w-1/4 hover:bg-gray-600 justify-center">
                         Password Recovery
                    </button>
               </div>
          </form>
     </div>
</div>
@endsection