@extends('layouts.web')

@section('title')
About Just Leave
@endsection

@section('content')
<div class="mt-6 flex flex-col mx-4">
    <div class="card p-3 flex flex-col w-full">
        <div class="my-4 flex flex-col justify-center items-center">
            <h3 class="text-lg text-gray-600 tracking-wide"> Creator & Contributor </h3>
            <img src="{{ asset('images/andre.jpeg') }}" class="w-1/3 lg:w-2/12 rounded-full" alt="andre">
            <p class="text-gray-600"> Checkout my personal website 👉🏾 <a href="https://andrekendeck.dev" class=" text-blue-600 hover:text-jean" target="_blank" > andrekendeck.dev </a> </p>
        </div>
        <div class="text-gray-600 text-md">
            JustLeave is just a Personal Project to allow teams to have a centralized place to manage leaves taken. This
            can be quite useful for reporting perposes. This app was not for teams to micro-manage their employees' leave
            days.
        </div>
    </div>
</div>
@endsection
