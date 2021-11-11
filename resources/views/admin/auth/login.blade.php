@extends('admin.layout')

@section('title', 'Login')

@section('content')
<div class="flex flex-row w-1/2 self-center">
    <x-card>
        <h3 class="text-lg text-purple-500 p-3 rounded-lg">justleave.work</h3>
        <form action="{{ route('admin.post.login') }}" method="POST" class="flex flex-col space-y-4">
            @csrf
            <x-form.input name="email" label="E-mail Address"></x-form.input>
            <x-form.input name="password" label="Password" type="password"></x-form.input>
            <div>
                <x-button>
                    Login
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection