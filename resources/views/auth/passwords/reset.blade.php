@extends('layouts.web')
@section('title')
Reset your password
@endsection
@section('content')
<div class="h-full mx-4 flex flex-col">
     <div class="card flex flex-col items-center mt-6 w-full lg:w-1/2 self-center p-3">
          <h3 class="text-lg text-jean text-center mt-3"> Reset your password </h3>
          <form action="{{ action('Auth\ResetPasswordController@reset') }}" class="flex flex-col w-full" method="POST">
               @csrf
               <input type="hidden" name="token" value="{{ $token }}" readonly="">
               <input type="hidden" name="email" value="{{ $email }}" readonly="">
               @field(['name' => 'password' , 'type' => 'password' , 'required'  => true , 'label' => 'New password' ])
               @field(['name' => 'password_confirmation' , 'type' => 'password' , 'required' => true , 'label' => 'Confirm Password' ])
               <button class="p-2 ml-2 bg-jean hover:bg-blue-800 text-white self-center mt-3">Reset</button>
          </form>
     </div>
</div>
@endsection
