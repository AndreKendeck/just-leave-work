@extends('layouts.web')

@section('title')
Leave no. {{ $leave->number }}
@endsection

@section('heading')
Leave no. {{ $leave->number }}
@endsection
@section('content')
<div class="flex h-full mx-4 lg:justify-center" id="leave">
    <div class="card rounded-lg w-full lg:w-3/4 mt-6 flex flex-col p-3">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-2 mg:mb-0">
                <a href="{{ $leave->user->url }}">
                    <img src="{{ $leave->user->avatar_url }}" class="h-8 w-8 rounded-full"
                        alt="{{ $leave->user->avatar_url }}">
                </a>
                <span class="text-xs text-gray-400 ml-1">{{ $leave->user->name }}</span>

            </div>
            @if ($leave->pending)
            <div class="bg-blue-200 text-blue-800 rounded px-2 text-xs mb-2 mg:mb-0">
                Pending
            </div>
            @endif
            @if ($leave->approved)
            <div class="bg-green-200 text-green-800 rounded px-2 text-xs text-xs mb-2 mg:mb-0">
                Approved by <a class="text-green-900 hover:text-green-400" href="{{ $leave->approval->user->url }}">
                    {{ $leave->approval->user->name }} </a>
            </div>
            @endif
            @if ($leave->denied)
            <div class="bg-red-200 text-red-800 rounded px-2 text-xs mb-2 mg:mb-0">
                Denied by <a class="text-red-900 hover:text-red-400 text-xs" href="{{ $leave->denial->user->url }}">
                    {{ $leave->denial->user->name }} </a>
            </div>
            @endif
            <h3 class="text-jean text-lg"> {{ $leave->reason->name }} <span class="text-xs text-gray-400 ml-1"> &bull;
                    {{ $leave->created_at->diffForHumans() }}</span> </h3>
        </div>
        <div class="flex mt-10 justify-between items-center px-4">
            <div class="flex flex-col">
                <p class="text-gray-600 text-sm"> From </p>
                <span class="text-sm"> {{ $leave->from->toFormattedDateString() }} </span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-gray-600 text-xs"> ({{ $leave->number_of_days_off }} Days) </span>
                <svg version="1.1" class="stroke-current h-6 w-6 text-gray-600" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                        <path d="M19,12h-14"></path>
                        <path d="M14,17l5,-5"></path>
                        <path d="M14,7l5,5"></path>
                    </g>
                </svg>
            </div>
            <div class="flex flex-col">
                <p class="text-gray-600 text-sm"> Until </p>
                <span class="text-sm"> {{ $leave->until->toFormattedDateString() }} </span>
            </div>
        </div>
        <div class="flex flex-col mt-5 items-center">
            <div class="px-2 text-gray-600 text-sm">
                {{ $leave->description }}
            </div>
            @if ($leave->can_edit)
            <a href="{{ $leave->edit_url }}"
                class="md:self-start mt-2 md:ml-2 text-gray-400 hover:bg-gray-300 tracking-wide lg:text-sm bg-gray-200 rounded">
                <svg version="1.1" class="stroke-current h-8 w-8 text-gray-600 p-2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                        <path
                            d="M21,11v8c0,1.105 -0.895,2 -2,2h-14c-1.105,0 -2,-0.895 -2,-2v-14c0,-1.105 0.895,-2 2,-2h8">
                        </path>
                        <path
                            d="M20.707,6.121l-10.879,10.879h-2.828v-2.828l10.879,-10.879c0.391,-0.391 1.024,-0.391 1.414,8.88178e-16l1.414,1.414c0.391,0.391 0.391,1.024 -3.55271e-15,1.414Z">
                        </path>
                        <path d="M16.09,5.09l2.82,2.82"></path>
                    </g>
                </svg>
            </a>
            @endif
            @role('reporter')
            @if ($leave->pending)
            <div class="flex mt-5 self-end">
                <form action="{{ route('leaves.approve') }}" class="mx-1" method="POST">
                    @csrf
                    <input type="hidden" name="leave_id" value="{{ $leave->id }}" readonly="">
                    <button type="submit" class="bg-jean hover:bg-gray-700"> Approve </button>
                </form>

                <form action="{{ route('leaves.deny') }}" class="mx-1" method="POST">
                    @csrf
                    <input type="hidden" name="leave_id" value="{{ $leave->id }}" readonly="">
                    <button type="submit" class="bg-red-600 hover:bg-red-800 p-2"> Deny </button>
                </form>
            </div>
            @endif
            @endrole
        </div>
        <div class="flex flex-col items-center mt-5">
            <h4 class="text-md text-jean my-4"> Comments (@{{ comments.length }}) </h4>

            <user-comment :comment="comment" :key="idx" v-for="(comment,idx) in comments"
                v-on:deleted="removeComment(idx)"></user-comment>

            <div class="flex flex-col items-center w-full mt-10">
                <vue-loader :active="comment.sending" spinner="ring"></vue-loader>
                <div class="flex items-center w-full">
                    <input type="text" placeholder="Add a comment...." v-on:keyup.enter="addComment()" class="w-full "
                        v-model="comment.text">
                    <button v-on:click="addComment()" class="bg-gray-300 mx-1 hover:bg-gray-400 rounded p-0"
                        v-bind:class="{ 'disabled' : checkForBlankComment }" v-bind:disabled="checkForBlankComment">

                        <svg version="1.1" class="stroke-current h-10 w-10 text-gray-600 p-2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g stroke-linecap="round" stroke-width="2" fill="none" stroke-linejoin="round">
                                <path
                                    d="M8.754,12.149l1.771,7.969c0.221,0.993 1.54,1.207 2.063,0.335l8.249,-13.749c0.451,-0.75 -0.089,-1.704 -0.964,-1.704h-15.551c-1.003,0 -1.505,1.212 -0.796,1.921l5.228,5.228Z">
                                </path>
                                <path d="M20.84,5.56l-12.09,6.59"></path>
                            </g>
                        </svg>
                    </button>
                </div>

                <div class="flex justify-end mx-2 py-1 mt-2 items-center" v-for="(error,idx) in comment.errors"
                    :key="idx">
                    <svg id="warning" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                        <path id="Path_41" data-name="Path 41" d="M0,0H15V15H0Z" fill="none" />
                        <path id="Path_42" data-name="Path 42"
                            d="M8.625,3h0A5.625,5.625,0,0,1,14.25,8.625h0A5.625,5.625,0,0,1,8.625,14.25h0A5.625,5.625,0,0,1,3,8.625H3A5.625,5.625,0,0,1,8.625,3Z"
                            transform="translate(-1.125 -1.125)" fill="none" stroke="#c81d25" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="1.5" />
                        <path id="Path_43" data-name="Path 43" d="M12,10.625V7.5" transform="translate(-4.5 -2.813)"
                            fill="none" stroke="#c81d25" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5" />
                        <path id="Path_44" data-name="Path 44"
                            d="M11.906,16a.156.156,0,1,0,.157.156A.155.155,0,0,0,11.906,16"
                            transform="translate(-4.406 -6)" fill="none" stroke="#c81d25" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="1.5" />
                    </svg>
                    <span class="text-red-600 text-xs mx-1">@{{ error }}</span>
                </div>

                <div class="flex justify-end mx-2 py-1 mt-2 items-center" v-if="comment.successMessage">
                    <svg version="1.1" class="stroke-current w-3 h-3 text-green-600" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12,21v0c-4.971,0 -9,-4.029 -9,-9v0c0,-4.971 4.029,-9 9,-9v0c4.971,0 9,4.029 9,9v0c0,4.971 -4.029,9 -9,9Z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16,10l-5,5l-3,-3">
                            </path>
                        </g>
                    </svg>
                    <span class="text-green-600 text-xs mx-1">@{{ comment.successMessage }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    new Vue({
               el : '#leave',
               data : {
               comments : @json($leave->comments),
               comment : {
                    text : null,
                    sending : false,
                    successMessage : null,
                    errors : [],
                    }
               },
               methods: {
                    addComment() {
                         this.comment.sending = true;
                         this.comment.errors = [];
                         this.comment.successMessage = null;
                         axios.post('/comment' , { leave_id : @json($leave->id) , text : this.comment.text } )
                         .then( response => {
                              this.comment.text = null;
                              this.comment.successMessage = response.data.message;
                              this.comment.sending = false;
                              this.comments = [ response.data.comment , ...this.comments ];
                         }).catch( failed => {
                              this.comment.text = null;
                              this.comment.sending = false;
                              this.comment.errors = collect(
                                   failed.response.data.errors
                              ).flatten().all();
                         });
                    },
                    removeComment(idx) {
                         this.comments.splice(idx , 1);
                    },
                    toReadableTime(date) {
                         return moment(date).fromNow();
                    }
               },
               computed: {
                    checkForBlankComment() {
                         return voca.isBlank(this.comment.text);
                    },
               },
          });
</script>
@endsection
