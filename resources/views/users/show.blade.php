@extends('layouts.web')
@section('title')
{{ $user->name  }}
@endsection
@section('content')
<div class="h-full mx-4 flex flex-col justify-center" id="user">
    <div class="card flex-col w-full h-full lg:w-1/2 mt-6 p-3 self-center">
        <div class="flex flex-col md:flex-row w-full items-center justify-between">
            <div class="flex flex-col">
                <img src="{{ $user->avatar_url }}" class="h-12 w-12 rounded-full mr-1 self-center" alt="avatar">
                <span class="text-gray-400 text-xs mt-1"> Joined {{ $user->created_at->diffForHumans() }} </span>
            </div>
            <div class="flex flex-col justify-between">
                <h3 class="text-lg text-gray-600 tracking-wide text-right"> {{ $user->name }} </h3>
                @if ($user->is_reporter)
                <span class="text-xs bg-gray-200 rounded-lg text-gray-400 text-center mt-1"> Reporter
                </span>
                @endif
                @if ($user->is_banned)
                <span class="bg-red-200 text-red-600 text-xs px-2 rounded-lg text-center mt-1">Banned</span>
                @endif
                @if ($user->is_on_leave)
                <span class="bg-blue-200 text-blue-600 text-xs px-2 rounded-lg text-center  mt-1">On leave</span>
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
    <div class="flex flex-col">
        <vue-loader :active="is_loading" loader="spinner"> </vue-loader>
        <a v-bind:href="leave.url"
            class="bg-white rounded p-3 flex flex-col lg:w-1/2 w-full self-center m-4 hover:bg-gray-200"
            v-for="(leave,idx) in leaves" :key="idx">
            <div class="flex justify-between w-full items-center">
                <h3 class="text-gray-600"> @{{ leave.number }} </h3>
                <h3 class="text-gray-600"> @{{ leave.reason.name }} </h3>
                <div class="flex">
                    <div v-if="leave.pending" class="bg-blue-200 text-blue-800 rounded px-2 text-xs flex items-center ">
                        Pending
                    </div>

                    <div v-if="leave.approved" class="bg-green-200 text-green-800 rounded px-2 text-xs flex items-center">
                        Approved
                    </div>

                    <div v-if="leave.denied" class="bg-red-200 text-red-800 rounded px-2 text-xs flex items-center">
                        Denied
                    </div>
                    <div class="bg-gray-300 text-gray-600 ml-1 px-2 flex items-center rounded">
                        <svg class="stroke-current h-4 w-4 text-gray-600 mx-1" version="1.1"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.12,20h3.88">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.264,20h-3.339c-0.823,0 -1.235,-0.995 -0.653,-1.576l1.09,-1.09">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4,12c0,-4.418 3.582,-8 8,-8c4.418,0 8,3.582 8,8c0,4.418 -3.582,8 -8,8">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.73,16.96l-0.37,0.37"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.733,16.963c-1.082,-1.364 -1.733,-3.086 -1.733,-4.963"></path>
                            </g>
                        </svg>
                        <span> @{{ leave.comments_count }} </span>
                    </div>
                </div>
            </div>
            <div class="flex mt-3 w-full items-center">

            </div>
        </a>
    </div>
    <div class="flex justify-center mt-2" v-show="!max_leaves_reached">
        <button v-on:click="getLeaves()" class="p-1 hover:bg-gray-300 flex justify-around w-100 items-center">
            <span class="text-gray-600 mr-1"> more </span>
            <svg version="1.1" viewBox="0 0 24 24" class="stroke-current text-gray-600 h-4 w-4"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21,7.5l-9,9l-9,-9">
                    </path>
                </g>
            </svg>
        </button>
    </div>
</div>
@endsection

@section('script')
<script>
    new Vue({
            el : '#user',
            data : {
                leaves : [],
                user : @json($user),
                flag : 0,
                is_loading : false,
                max_leaves_reached : false,
            },
            methods : {
                getLeaves() {
                    this.is_loading = true;
                    axios.get(`/user/${this.user.id}/leaves/${this.flag}`)
                    .then( successData => {
                        if (successData.data.leaves.length === 0) {
                            this.max_leaves_reached = true;
                        }
                        collect(successData.data.leaves).each( leave => {
                            this.leaves.push(leave);
                        } );
                        this.flag += 5;
                        this.is_loading = false;
                    } ).catch ( failedData => {
                        this.is_loading = false;
                    } );
                }
            },
            mounted() {
                this.getLeaves();
            }
        })
</script>
@endsection
