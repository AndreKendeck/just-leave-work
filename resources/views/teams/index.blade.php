@extends('layouts.web')
@section('title')
Team {{ $team->name }}
@endsection
@section('content')
<div class="h-full flex flex-col mx-4" id="team">
    <div class="card mt-6 flex flex-col p-3 w-full lg:w-1/2 self-center">
        <div class="flex self-center flex-col justify-center items-center">
            <button class="px-2 py-1 hover:bg-gray-100 rounded" v-on:click="selectFile()">
                <img v-bind:src="team.has_logo ? team.logo_url : team.logo_url.encoded"
                    class="w-24 h-24 rounded-full self-center" alt="organization_avatar">
                <input type="file" v-on:change="uploadFile()" name="logo" accept="image/*" ref="logo" id="logo"
                    class="hidden">
                <div class="flex justify-end mx-2 py-1 mt-2 items-center" v-for="(error,idx) in errors" :key="idx">
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
            </button>
            <button class="p-0 hover:bg-gray-100" v-if="team.has_logo" v-on:click="removeLogo()">
                <svg version="1.1" class="stroke-current h-8 w-8 text-gray-600 px-1 py-1" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g stroke-linecap="round" stroke-width="1.5" fill="none" stroke-linejoin="round">
                        <path d="M18,6.53h1"></path>
                        <path d="M9,10.47v6.06"></path>
                        <path d="M12,9.31v8.27"></path>
                        <path d="M15,10.47v6.06"></path>
                        <path
                            d="M15.795,20.472h-7.59c-1.218,0 -2.205,-0.987 -2.205,-2.205v-11.739h12v11.739c0,1.218 -0.987,2.205 -2.205,2.205Z">
                        </path>
                        <path
                            d="M16,6.528l-0.738,-2.305c-0.133,-0.414 -0.518,-0.695 -0.952,-0.695h-4.62c-0.435,0 -0.82,0.281 -0.952,0.695l-0.738,2.305">
                        </path>
                        <path d="M5,6.53h1"></path>
                    </g>
                </svg>
            </button>
            <p class="text-xl text-gray-600"> @{{ team.name  }} </p>
            <p class="text-gray-400 text-sm"> Joined {{ $team->created_at->diffForHumans() }} </p>
        </div>
        <div class="flex w-full mt-3">
            <form action="{{ route('teams.update') }}" method="post" class="flex w-full">
                @csrf
                @field(['name' => 'name' , 'label' => 'Team Name' , 'required' => true , 'value' => $team->name ])
                <button class="bg-gray-300 hover:bg-gray-400 flex p-1 items-center h-10 self-center mt-8">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-save stroke-current h-8 w-8 text-gray-600 p-2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                        </path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span class="text-gray-600 text-xs"> Update </span>
                </button>
            </form>
        </div>
        <div class="mt-3 flex flex-col w-full">
            <div class="flex my-4">
                {{-- Total users --}}
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600"> Members </h4>
                    <div> {{ $team->users->count() }} </div>
                </div>

                {{-- Total reporters --}}

                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600"> Reporters </h4>
                    <div> {{ $team->users()->role('reporter')->count() }} </div>
                </div>


                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600"> Banned </h4>
                    <div> {{ $team->users->where('is_banned' , true )->count() }} </div>
                </div>
            </div>


            <div class="flex my-4">

                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600 "> Total </h4>
                    <div> {{ $team->leaves->count() }} </div>
                </div>

                {{-- Total users --}}
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600"> Approved </h4>
                    <div> {{ $team->leaves()->whereNotNull('approved_at')->count() }} </div>
                </div>

                {{-- Total reporters --}}

                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600"> Denied </h4>
                    <div> {{ $team->leaves()->whereNotNull('denied_at')->count() }} </div>
                </div>
            </div>


            <div class="flex my-4">
                {{-- Total users --}}
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600 "> Avg. Days off </h4>
                    <div> {{ round($team->leaves->where('approved' , true )->avg('number_of_days_off') , 0 ) }} </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    new Vue({
        el : '#team',
        data : {
            team : @json($team),
            errors : [],
        },
        methods : {
            selectFile() {
                this.$refs.logo.click();
            },
            uploadFile() {
                let file = this.$refs.logo.files[0];

                if (file) {
                    this.team.logo_url = URL.createObjectURL(file);
                    this.team.has_logo = true;
                    this.errors = [];
                    let formData = new FormData();
                    formData.append('logo' , file );
                    axios.post('/upload-team-logo' , formData , {
                        headers : { 'Content-Type' : 'multipart/form-data' }
                    } ).then( successResponse => {
                        this.team.logo_url = successResponse.data.logo;
                    } ).catch( failedResponse => {
                        this.errors = collect(failedResponse.response.data.errors).flatten().all();
                    } )
                }
            },
            removeLogo() {
                axios.post('/delete-team-logo')
                .then( successResponse => {
                    this.team.has_logo = false;
                    this.team.logo_url = successResponse.data.logo;
                }).catch( failedResponse => {
                    this.errors = collect(failedResponse.response.data.errors).flatten().all();
                });
            }
        }
    })
</script>
@endsection
