@extends('layouts.web')
@section('title')
Login
@endsection
@section('content')
<div class="flex flex-col items-center h-screen mx-4">
     {!! file_get_contents(asset('images/table.svg')) !!}
     <div class="card flex flex-col px-2 py-8 w-full">
          <h4 class="text-jean text-xl text-center">Login to your account</h4>
          <form action="{{ route('login')}}" method="POST" class="flex flex-col">
               @csrf
               @field(['name' => 'email' , 'label' => 'Email Address' , 'required' => true ])
               @field(['name' => 'password' , 'label' => 'Password' , 'required' => true , 'type' => 'password' ])
               <button class="bg-jean hover:bg-black rounded-lg px-4 mt-6 py-2 w-1/2 self-center"> Login </button>
               <a href="{{ route('password.request') }}" class="rounded-lg px-4 py-2 mt-2 w-1/2 self-center bg-white text-black border-2 border-black
               text-center">
                    Reset Password </a>
          </form>
     </div>
</div>
@endsection