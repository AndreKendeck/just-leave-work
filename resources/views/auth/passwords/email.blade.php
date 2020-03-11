@extends('layouts.web')
@section('title')
Request a new password
@endsection
@section('content')
<div class="flex flex-col items-center h-screen mx-4 mt-16">
     <div class="card flex flex-col px-2 py-8 w-full">
          <form action="{{ route('password.email') }}" method="POST" class="flex flex-col">
               @csrf
               @field(['name' => 'email' , 'label' => 'Email Address' , 'required' => true , 'type' => 'email' ])
               <button class="bg-jean hover:bg-black rounded-lg px-4 mt-6 py-2 w-1/2 self-center">
                    Send email 
               </button>
               @if (session('status'))
                   {{ session('status') }}
               @endif
          </form>
     </div>
</div>
@endsection