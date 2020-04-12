@extends('layouts.web')
@section('title')
My Profile
@endsection

@section('content')
<div class="flex h-full justify-center mx-2" id="profile">
    <div class="card flex-col w-full h-full lg:w-1/2 mt-6 p-3">
        <div class="flex w-full items-center">
            <button class="hover:bg-gray-200 p-2 rounded-lg">
                <img v-on:click="selectAvatar()"
                    v-bind:src="user.has_avatar ? user.avatar_url : user.avatar_url.encoded"
                    class="h-12 w-12 rounded-full mr-1" alt="avatar">
                <input type="file" v-on:change="assignAvatar()" name="avatar" accept="image/*" class="hidden"
                    ref="avatar" id="avatar">

            </button>

            <button class="p-0" v-if="user.has_avatar" v-on:click="removeAvatar()">
                <svg version="1.1" class="stroke-current h-10 w-10 text-gray-600 px-2 py-1" viewBox="0 0 24 24"
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
            <span class="text-gray-400 text-xs"> Joined {{ Auth::user()->created_at->diffForHumans() }} </span>
            <h3 class="text-lg text-gray-600 tracking-wide flex-1 text-right"> @{{ user.name }} </h3>
        </div>
        <div class="flex mt-3 w-full flex-col">
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
                        d="M11.906,16a.156.156,0,1,0,.157.156A.155.155,0,0,0,11.906,16" transform="translate(-4.406 -6)"
                        fill="none" stroke="#c81d25" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5" />
                </svg>
                <span class="text-red-600 text-xs mx-1">@{{ error }}</span>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" class="w-full">
                @csrf
                @field(['name' => 'name' , 'label' => 'Full name' , 'required' => true , 'value' => Auth::user()->name
                ])
                <button class="hover:bg-gray-300 bg-gray-200 rounded p-0 ml-2 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-save stroke-current h-8 w-8 text-gray-600 p-2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                        </path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                </button>
            </form>
        </div>
        <div class="flex flex-col mt-3 w-full">
            <hr class="my-3">
            <div class="flex w-full justify-between mt-2">
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600 text-lg"> Requested </h4>
                    <div> {{ Auth::user()->leaves->whereNull(['approved_at' , 'denied_at' ])->count() }} </div>
                </div>
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full ">
                    <h4 class="text-gray-600 text-lg"> Approved </h4>
                    <div> {{ Auth::user()->leaves->whereNotNull('approved_at')->count() }} </div>
                </div>
                <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                    <h4 class="text-gray-600 text-lg"> Denied </h4>
                    <div> {{ Auth::user()->leaves->whereNotNull('denied_at')->count() }} </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col mt-3 w-full">
            <form action="{{ route('logout') }}" method="POST" class="w-full mx-2 md:hidden">
                @csrf
                <button class="bg-red-300 p-2 text-red-600 border-red-600 border text-sm hover:bg-red-400 w-full" type="submit">
                    <span > Logout </span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    new Vue({
            el : '#profile',
            data : {
                user : @json(Auth::user()),
                errors : [],
            },
            methods : {
                selectAvatar() {
                    this.$refs.avatar.click();
                },
                assignAvatar() {
                    let avatar = this.$refs.avatar.files[0];
                    this.errors = [];
                    if (avatar) {
                        this.user.has_avatar = true;
                        this.user.avatar_url = URL.createObjectURL(avatar);
                        let formData = new FormData();
                        formData.append('avatar' , avatar );
                        axios.post('/avatar-upload' , formData ,  {
                            headers : { 'Content-Type' : 'multipart/form-data' }
                        } ).then( successResponse => {
                            this.user.avatar_url = successResponse.data.avatar;
                        } ).catch( errorResponse => {
                          this.errors = collect(errorResponse.response.data.errors).flatten().all();
                          this.user.has_avatar = false;
                        } );
                    }
                },
                removeAvatar(){
                    axios.post('/avatar-remove')
                    .then( successResponse => {
                        this.user.has_avatar = false;
                        this.user.avatar_url = successResponse.data.avatar;
                    } );
                }
            }
        })
</script>
@endsection
