@extends('layouts.web')

@section('title')
Edit User {{ $user->name }}
@endsection

@section('content')
<div class="h-full mx-4 flex flex-col justify-center items-center" id="user">
    <div class="card p-3 flex-col mt-6 lg:w-1/2 w-full self-center">
        <div class="flex flex-col md:flex-row justify-between my-3">
            <div class="flex flex-col items-start">
                <img src="{{ $user->avatar_url }}" class="h-12 w-12 rounded-full mb-2 self-center" alt="avatar">
                <span class="text-gray-600 text-xs lg:text-md self-center"> {{ $user->name }}
                    @if ($user->is_reporter)
                    <span class="text-xs text-gray-400 ml-1 mt-1"> &bull; Reporter
                    </span>
                    @endif
                </span>
                <div class="flex mt-2 self-center">
                    @if ($user->is_banned)
                    <span class="bg-red-200 text-red-600 text-xs px-2 rounded-lg mx-1">banned</span>
                    @endif
                    @if ($user->is_on_leave)
                    <span class="bg-blue-200 text-blue-600 text-xs px-2 rounded-lg mx-1 ">On leave</span>
                    @endif
                </div>
            </div>
            <div class="flex justify-center md:justify-between items-center">
                @if (!$user->is_banned)
                <form action="{{ route('users.ban') }}" class="mt-3 lg:mt-0" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}" readonly="">
                    <button class="text-red-600 flex justify-between bg-red-300 hover:bg-red-400 p-1 items-center">
                        <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-3 w-3 text-red-600"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364,5.636l-12.728,12.728l12.728,-12.728Z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12,3v0c-4.971,0 -9,4.029 -9,9v0c0,4.971 4.029,9 9,9v0c4.971,0 9,-4.029 9,-9v0c0,-4.971 -4.029,-9 -9,-9Z">
                                </path>
                            </g>
                        </svg>
                        <span class="text-red-600 text-xs"> Ban </span>
                    </button>
                </form>
                @endif
                @if ($user->is_banned)
                <form action="{{ route('users.unban') }}" class="mt-3 lg:mt-0" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}" readonly="">
                    <button class="bg-gray-200 hover:bg-gray-300 py-1 flex items-center">
                        <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-3 w-3 text-gray-600"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364,5.636l-12.728,12.728l12.728,-12.728Z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12,3v0c-4.971,0 -9,4.029 -9,9v0c0,4.971 4.029,9 9,9v0c4.971,0 9,-4.029 9,-9v0c0,-4.971 -4.029,-9 -9,-9Z">
                                </path>
                            </g>
                        </svg>
                        <span class="text-gray-600 text-xs ml-1"> Remove Ban </span>
                    </button>
                </form>
                @endif
                @if (!$user->is_reporter)
                <form action="{{ route('reporter.add') }}" class="mt-3 lg:mt-0 ml-1" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}" readonly="">
                    <button class="bg-gray-200 hover:bg-gray-300 py-1 flex">
                        <svg version="1.1" class="stroke-current text-gray-600 h-4 w-4" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4,20v0c0,-2.485 2.015,-4.5 4.5,-4.5h2.583"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.497,21c0,0 2.497,-1.193 2.497,-2.983l0.006,-2.084l-1.821,-0.652c-0.438,-0.157 -0.916,-0.157 -1.353,0l-1.82,0.652l-0.006,2.083c0,1.79 2.497,2.984 2.497,2.984Z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15.0052,5.2448c1.65973,1.65973 1.65973,4.35068 0,6.01041c-1.65973,1.65973 -4.35068,1.65973 -6.01041,0c-1.65973,-1.65973 -1.65973,-4.35068 -1.77636e-15,-6.01041c1.65973,-1.65973 4.35068,-1.65973 6.01041,-1.77636e-15">
                                </path>
                            </g>
                        </svg>
                        <span class="text-gray-600 text-xs ml-1"> Make reporter </span>
                    </button>
                </form>
                @endif

                @if ($user->is_reporter)
                <form action="{{ route('reporter.remove') }}" class="mt-3 lg:mt-0 ml-1" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}" readonly="">
                    <button class="bg-gray-200 hover:bg-gray-300 py-1 flex items-center">
                        <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-3 w-3 text-gray-600"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364,5.636l-12.728,12.728l12.728,-12.728Z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12,3v0c-4.971,0 -9,4.029 -9,9v0c0,4.971 4.029,9 9,9v0c4.971,0 9,-4.029 9,-9v0c0,-4.971 -4.029,-9 -9,-9Z">
                                </path>
                            </g>
                        </svg>
                        <span class="text-gray-600 text-xs ml-1"> Remove reporter </span>
                    </button>
                </form>
                @endif

            </div>
        </div>

        <div class="flex flex-col mt-3 w-full">
            <hr class="my-3">
            <div class="flex w-full justify-between mt-2">
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600 text-lg"> Requested </h4>
                    <div> {{ $user->leaves->whereNull(['approved_at' , 'denied_at' ])->count() }} </div>
                </div>
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full ">
                    <h4 class="text-gray-600 text-lg"> Approved </h4>
                    <div> {{ $user->leaves->whereNotNull('approved_at')->count() }} </div>
                </div>
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600 text-lg"> Denied </h4>
                    <div> {{ $user->leaves->whereNotNull('denied_at')->count() }} </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')

@endsection
