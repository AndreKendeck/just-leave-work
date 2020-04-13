@extends('layouts.web')
@section('title')
Login
@endsection
@section('content')
<div class="flex flex-col lg:flex-row items-center justify-center h-full mx-4 mt-6">
     <div class="card p-3 flex flex-col lg:w-1/2 w-full self-center">
          <h4 class="text-jean text-xl text-center mt-3">Login to your account</h4>
          <form action="{{ route('login')}}" method="POST" class="flex flex-col">
               @csrf
               @field(['name' => 'email' , 'label' => 'Email Address' , 'required' => true ])
               @field(['name' => 'password' , 'label' => 'Password' , 'required' => true , 'type' => 'password' ])
               <button class="bg-jean hover:bg-black rounded-lg px-4 mt-6 py-2 w-1/2 lg:w-1/4 self-center"> Login
               </button>
               <a href="{{ route('password.request') }}" class="rounded-lg px-4 py-2 mt-2 w-1/2 lg:w-1/4  self-center bg-gray-300 text-gray-700
               hover:bg-gray-400
               text-center">
                    Reset Password </a>
               <p class="text-center text-gray-600 mt-6"> Don't have an account? <a class="text-jean"
                         href="{{ route('register') }}"> Sign
                         up </a> </p>
          </form>
     </div>
</div>
@endsection
