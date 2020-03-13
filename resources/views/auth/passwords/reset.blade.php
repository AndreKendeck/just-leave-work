@extends('layouts.web')
@section('title')
Reset your password
@endsection
@section('content')
<div class="h-screen mx-auto">
     <div class="card flex flex-col items-center">
          <h3 class="text-lg text-jean text-center"> Reset your password </h3>
          <form action="{{ action('Auth\ResetPasswordController@reset') }}" method="POST">
               @csrf
               <input type="hidden" name="token" value="{{ $token }}" readonly="">
               @field(['name' => 'email' , 'disabled' => true   ])
          </form>
     </div>
</div>
@endsection