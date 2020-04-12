@extends('layouts.web')

@section('title')
Create a new User
@endsection

@section('content')
<div id="user" class="h-full mx-4 flex flex-col justify-center">
    <div class="card p-3 flex-col shadow-xs mt-6 pb-4 w-full lg:w-1/2 self-center">
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            @field([ 'type' => 'text' , 'name' => 'name' , 'label' => 'Full name' , 'required' => true ])
            @field([ 'type' => 'email' , 'name' => 'email' , 'label' => 'E-mail Address' , 'required' => true ])
            @checkbox(['name' => 'reporter' , 'label' => 'Allows this user to approve & deny leaves' , 'value' => true
            ])
            <button type="submit" class="mt-3 ml-2 bg-jean hover:bg-blue-800 text-white">
                Create
            </button>
        </form>
    </div>
    <hr class="my-6 w-full md:w-1/2 self-center">
    <div class="card p-3 flex-col shadow-xs mt-3 pb-4 w-full lg:w-1/2 self-center mt-5">
        <p class="text-sm text-gray-600"> Create multiple users by adding emails below separted by a comma ( , ) </p>
        <form action="{{ route('bulk.users.store') }}" method="post">
            @csrf
            @textarea(['name' => 'users' , 'label' => 'Users' , 'required' => true , 'placeholder' => 'Eg. johndoe@mail.com, janedoe@mail.com' , 'value' => old('users') ])
            <button type="submit" class="mt-3 ml-2 bg-jean hover:bg-blue-800 text-white">
                Create
            </button>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection
