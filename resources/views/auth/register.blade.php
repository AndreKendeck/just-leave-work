@extends('layouts.web')
@section('title')
Sign up
@endsection
@section('content')
<div class="flex flex-col items-center mx-4">
     <div class="flex items-center mt-6 w-full">
          <img src="{{ asset('images/girl.png') }}" class="" alt="girl">
          <h3 class="text-jean text-2xl"> Let's get your team setup </h3>
     </div>
     <div class="card flex flex-col px-2 py-2 w-full">
          <form action="{{ route('register') }}" class="" method="POST">
               @csrf
               @field(['name' => 'name' , 'label' => 'Fullname' , 'required' => true ])
               @field(['name' => 'email' , 'label' => 'Email Address' , 'required' => true , 'type' => 'email' ])
               @field(['name' => 'organization_name' , 'label' => 'Organization Name' , 'required' => true ])
               @field(['name' => 'password' , 'label' => 'Password' , 'required' => true , 'type' => 'password' ])
               @field(['name' => 'password_confirmation' , 'label' => 'Confirm Password' , 'required' => true , 'type'
               =>
               'password' ])
               <button type="submit" class="bg-jean py-3 px-3 rounded-lg w-full mt-5 self-center">Register</button>
          </form>
     </div>
</div>
@endsection