@extends('layouts.web')
@section('title')
Verify your account
@endsection
@section('heading')
Verify your account
@endsection
@section('content')
<div class="flex flex-col h-screen mx-2">
     <div class="card p-5 w-full" >
          <form action="{{ action('Auth\VerificationController@resend') }}" class="flex w-full items-center" method="POST">
               @csrf
               <button class="bg-seaweed text-white self-center" type="submit"> Resend email </button>
          </form>
     </div>
</div>
@endsection