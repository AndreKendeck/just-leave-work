@extends('layouts.web')
@section('title')
Sign up
@endsection
@section('content')
<div class="h-full flex flex-col items-center mx-4 mt-6">
    <div class="card flex-col px-2 py-2 w-full md:w-3/4 pb-10">

        <h3 class="text-jean text-2xl tracking-wide mt-3 text-center w-full "> Register your Team </h3>

        <form action="{{ route('register') }}" class="flex flex-col w-full" method="POST">
            @csrf
            @field(['name' => 'name' , 'label' => 'Fullname' , 'required' => true , ])
            @field(['name' => 'email' , 'label' => 'Email Address' , 'required' => true , 'type' => 'email' ])
            @field(['name' => 'team_name' , 'label' => 'Organization Name' , 'required' => true ])
            @field(['name' => 'password' , 'label' => 'Password' , 'required' => true , 'type' => 'password' ])
            <button type="submit" class="bg-jean py-3 px-3 rounded-lg w-full md:w-1/4 mt-5 self-center">
                Sign up
            </button>
        </form>
        <p class="text-gray-600 mt-4 text-center"> By signing up you agree with the <a href="{{ route('terms') }}"
                class="text-jean hover:text-blue-800"> Terms &amp; Conditions </a> as well as the 
                <a href="{{ route('privacy') }}"
                class="text-jean hover:text-blue-800"> Privacy Policy </a> </p>
    </div>
</div>
@endsection