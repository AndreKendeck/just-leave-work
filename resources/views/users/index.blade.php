@extends('layouts.web')
@section('title')
Users
@endsection
@section('heading')
Users
@endsection
@section('content')
<div id="users" class="h-full mx-4">
    <div class="flex flex-col lg:justify-center items-center w-full">
        <div class="card w-full lg:w-3/4 p-2 my-3">
            <form action="{{ route('users.index') }}" method="GET" class="flex w-full">
                @field(['type' => 'search' , 'name' => 'search' , 'label' => 'Search User' , 'required' => false ,
                'value' => request('search') ])
                <button class="p-1 rounded bg-gray-300 hover:bg-gray-400 text-gray-600 flex max-h-1/2 self-center mt-8">
                    <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-8 w-8 text-gray-600"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15.7138,6.8382c2.45093,2.45093 2.45093,6.42467 0,8.8756c-2.45093,2.45093 -6.42467,2.45093 -8.8756,0c-2.45093,-2.45093 -2.45093,-6.42467 -8.88178e-16,-8.8756c2.45093,-2.45093 6.42467,-2.45093 8.8756,-8.88178e-16">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19,19l-3.29,-3.29">
                            </path>
                        </g>
                    </svg>
                </button>
                <a class="bg-gray-300 hover:bg-gray-400 text-gray-700 p-1 self-center flex text-center rounded ml-1 mt-8 max-h-1/2"
                    href="{{ route('users.create') }}">
                    <svg version="1.1" viewBox="0 0 24 24" class="h-8 w-8 stroke-current text-gray-600"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                            <path
                                d="M12.4692,3.02278c1.36371,1.36371 1.36371,3.57472 0,4.93843c-1.36371,1.36371 -3.57472,1.36371 -4.93843,8.88178e-16c-1.36371,-1.36371 -1.36371,-3.57472 -8.88178e-16,-4.93843c1.36371,-1.36371 3.57472,-1.36371 4.93843,-8.88178e-16">
                            </path>
                            <path
                                d="M14.363,12.796c-1.299,-0.519 -2.823,-0.805 -4.363,-0.805c-4.048,0 -8,1.967 -8,4.992v1c0,0.552 0.448,1 1,1h9.413">
                            </path>
                            <path
                                d="M17,22c-2.761,0 -5,-2.238 -5,-5c0,-2.704 2.3,-5.003 5.004,-5c2.76,0.002 4.996,2.24 4.996,5c0,2.761 -2.238,5 -5,5">
                            </path>
                            <path d="M17,15v4"></path>
                            <path d="M19,17h-4"></path>
                        </g>
                    </svg>
                </a>
            </form>
        </div>

        <user-card :user="user" v-for="(user,idx) in users.data" :key="idx"  ></user-card>

        {{ $users->links() }}
        {{ $users->links('components.simple-paginate') }}

    </div>
</div>
@endsection
@section('script')
<script>
    new Vue({
              el : '#users',
              data : {
                   users : @json($users),
              }
         })
</script>
@endsection
