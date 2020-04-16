@extends('layouts.web')


@section('title')
Leaves
@endsection
@section('heading')
Leaves
@endsection

@section('content')
<div class="flex w-full h-full" id="leaves">
    <div class="mt-6 p-3 rounded h-full w-full flex flex-col items-center">

        <div class="card flex flex-col justify-between lg:flex-row p-3 w-full lg:w-3/4">

            @role('reporter')
            <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                <span class="text-gray-600 text-sm"> Search </span>
                <form action="{{ route('leaves.index') }}" class="flex" method="get">
                    <input type="search" name="search" id="search" class="w-full" value="{{ request('search') }}"
                        placeholder="Search...">
                    <button class="p-1 rounded bg-gray-300 hover:bg-gray-400 text-gray-600 flex self-center ml-2">
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
                </form>
            </div>
            @endrole

            <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                <span class="text-gray-600 text-sm"> Month </span>
                <select name="from" id="from" v-model="filters.month" placeholder="From"
                    class="form-select w-full border-gray-300 border-2 focus:outline-none">
                    <option v-bind:value="month" v-bind:selected="filters.month === month" v-for="(month,idx) in months"
                        :key="idx"> @{{ formatMonth(month) }} </option>
                </select>
            </div>

            <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                <span class="text-gray-600 text-sm"> Status </span>
                <select name="from" id="status" v-model="filters.status" placeholder="Status"
                    class="form-select w-full border-gray-300 border-2 focus:outline-none">
                    <option v-bind:value="status" v-bind:selected="filters.status.value === status.value"
                        v-for="(status,idx) in statuses" :key="idx"> @{{ status.name }} </option>
                </select>
            </div>

            <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                <span class="text-gray-600 text-sm"> From </span>
                <select name="from" id="from" v-model="filters.from" placeholder="From"
                    class="form-select w-full border-gray-300 border-2 focus:outline-none">
                    <option v-bind:value="null" v-bind:selected="filters.from == null">Any Day</option>
                    <option v-bind:value="day" v-bind:selected="filters.from == day"
                        v-for="(day ,idx) in getDaysInMonth" :key="idx"> @{{ formatDay(day) }} </option>
                </select>
            </div>

            <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                <span class="text-gray-600 text-sm"> Until </span>
                <select name="from" id="from" v-model="filters.until" placeholder="From"
                    class="form-select w-full border-gray-300 border-2 focus:outline-none">
                    <option v-bind:value="null" v-bind:selected="filters.until == null">Any Day</option>
                    <option v-bind:value="day" v-bind:selected="filters.until == day"
                        v-for="(day ,idx) in getDaysInMonth" :key="idx"> @{{ formatDay(day) }} </option>
                </select>
            </div>


            <a class="p-1 rounded bg-gray-300 hover:bg-gray-400 text-gray-600 flex self-end lg:self-center mt-5"
                href="{{ route('leaves.create') }}">
                <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-8 w-8 "
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15,3v2">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11,3v2">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7,3v2">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19,12.26v-6.26c0,-1.105 -0.895,-2 -2,-2h-12c-1.105,0 -2,0.895 -2,2v11c0,1.105 0.895,2 2,2h8.758">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7,9h8">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7,13h3">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17.501,21c-2.485,0 -4.5,-2.015 -4.5,-4.5c0,-2.434 2.07,-4.502 4.504,-4.5c2.484,0.002 4.496,2.016 4.496,4.5c-3.55271e-15,2.485 -2.014,4.5 -4.5,4.5">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.5,14.7v3.6">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.3,16.5h-3.6">
                        </path>
                    </g>
                </svg>
            </a>


        </div>
        <div class="flex flex-col w-full lg:w-3/4  ">
            <user-leave-card v-on:selected="selectLeave(leave)" v-for="(leave,idx) in leaveFilter" :key="idx"
                :leave="leave"></user-leave-card>
            <hr class="w-full border-2 bg-gray-200">
        </div>

        {{ $leaves->links() }}
        {{ $leaves->links('components.simple-paginate') }}
    </div>

    {{-- --}}

    <div class="modal-backdrop" v-if="selectedLeave">
        <div class="bg-white p-3 flex flex-col z-20 mx-6 w-full rounded md:w-3/4 lg:w-1/2 animated fadeInDown faster">
            <div class="flex justify-between items-center mb-4">
                <div class="text-jean text-center text-lg tracking-widest">Leave no. @{{ selectedLeave.number }}
                </div>
                <button class="p-1 rounded hover:bg-gray-200 " v-on:click="selectedLeave = null">
                    <svg version="1.1" class="h-8 w-8 stroke-current text-gray-600" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8,8l8,8">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16,8l-8,8">
                            </path>
                        </g>
                    </svg>
                </button>
            </div>
            <div class="flex items-center">
                <img class="rounded-full w-8 md:w-10 lg:w-10"
                    v-bind:src="selectedLeave.user.has_avatar ? selectedLeave.user.avatar_url : selectedLeave.user.avatar_url.encoded"
                    alt="leave.user.name" />
                <span class="text-jean text-lg mx-2"> @{{ selectedLeave.user.name }} </span>
            </div>
            <div class="flex justify-between items-center my-4 px-3">
                <div class="text-gray-400"> @{{ selectedLeave.comments_count }} comments </div>
                <h3 class="text-gray-600"> @{{ selectedLeave.reason.name }} </h3>
            </div>
            <hr>
            <p class="py-3 text-gray-500">
                @{{ selectedLeave.description.substr(0,100) }}
                <a v-bind:href="selectedLeave.url" class="ml-2 text-blue-400 hover:text-blue-600"> more </a>
            </p>
            <div class="my-4 flex justify-between items-center">
                @role('reporter')
                <div class="flex" v-if="selectedLeave.pending">
                    <form action="{{ route('leaves.approve') }}" class="mx-1" method="POST">
                        @csrf
                        <input type="hidden" name="leave_id" v-bind:value="selectedLeave.id" readonly="">
                        <button type="submit" class="bg-jean hover:bg-gray-700"> Approve </button>
                    </form>

                    <form action="{{ route('leaves.deny') }}" class="mx-1" method="POST">
                        @csrf
                        <input type="hidden" name="leave_id" v-bind:value="selectedLeave.id" readonly="">
                        <button type="submit" class="bg-red-600 hover:bg-red-800 p-2"> Deny </button>
                    </form>
                </div>
                @endrole
                <div class="flex items-center">
                    <button class="mx-1 p-0" v-on:click="comment.open = !comment.open">
                        <svg class="stroke-current h-10 w-10 bg-gray-300 text-gray-600 hover:bg-gray-400 p-2 rounded"
                            version="1.1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.12,20h3.88">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.264,20h-3.339c-0.823,0 -1.235,-0.995 -0.653,-1.576l1.09,-1.09">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4,12c0,-4.418 3.582,-8 8,-8c4.418,0 8,3.582 8,8c0,4.418 -3.582,8 -8,8">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.73,16.96l-0.37,0.37"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.733,16.963c-1.082,-1.364 -1.733,-3.086 -1.733,-4.963"></path>
                            </g>
                        </svg>
                    </button>
                    <a v-bind:href="selectedLeave.url" class="bg-gray-300 mx-1 hover:bg-gray-400 rounded">
                        <svg class="stroke-current h-10 w-10 text-gray-600 p-2" version="1.1" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.118,12.467c-0.157,-0.291 -0.157,-0.644 0,-0.935c1.892,-3.499 5.387,-6.532 8.882,-6.532c3.495,0 6.99,3.033 8.882,6.533c0.157,0.291 0.157,0.644 0,0.935c-1.892,3.499 -5.387,6.532 -8.882,6.532c-3.495,0 -6.99,-3.033 -8.882,-6.533Z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.1213,9.87868c1.17157,1.17157 1.17157,3.07107 0,4.24264c-1.17157,1.17157 -3.07107,1.17157 -4.24264,0c-1.17157,-1.17157 -1.17157,-3.07107 0,-4.24264c1.17157,-1.17157 3.07107,-1.17157 4.24264,0">
                                </path>
                            </g>
                        </svg>
                    </a>
                    <a v-if="selectedLeave.can_edit" v-bind:href="selectedLeave.edit_url"
                        class="bg-gray-300 mx-1 hover:bg-gray-400 rounded">
                        <svg version="1.1" class="stroke-current h-10 w-10 text-gray-600 p-2" viewBox="0 0 24 24"
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
                </div>
            </div>
            <div class="flex flex-col items-center aninmated fadeInDown faster" v-if="comment.open">
                <vue-loader :active="comment.sending" spinner="ring"></vue-loader>
                <div class="flex items-center w-full">
                    <input type="text" placeholder="Add a comment...." class="w-full " v-model="comment.text">
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
              el : '#leaves',
              data : {
               leaves : @json($leaves),
               selectedLeave : null,
               search : null,
               comment : {
                    open : false,
                    text : null,
                    sending : false,
                    successMessage : null,
                    errors : [],
               },
               months : [ 0 , 1 ,2 ,3 , 4 , 5 ,6 ,7 , 8, 9 ,10 ,11 ] ,
               statuses : [
                    {
                         name : 'All',
                         value : null,
                    },
                    {
                         name : 'Pending',
                         value : 'Pending'
                    },
                    {
                         name : 'Approved',
                         value : 'Approved'
                    },
                    {
                         name : 'Denied',
                         value : 'Denied'
                    }
                ],
               filters : {
                    search : null,
                    month : moment().get('month'),
                    status : { name : 'All' , value : null },
                    from : null,
                    until : null,
               }
              },
              methods : {
                   selectLeave(e) {
                        this.selectedLeave = e;
                   },
                    changeWeek() {
                    this.currentMonth = moment().set('week' , this.currentWeek  ).format('MMMM');
                    },
                    formatMonth(month) {
                         return moment().set('month', month ).format('MMMM');
                    },
                    formatDay(day) {
                         return moment().set({ 'month' : this.filters.month , 'date' : day }).format('ddd D');
                    },
                    addComment() {
                         this.comment.sending = true;
                         this.comment.errors = [];
                         this.comment.successMessage = null;
                         axios.post('/comment' , { leave_id : this.selectedLeave.id , text : this.comment.text } )
                         .then( response => {
                              this.comment.text = null;
                              this.comment.successMessage = response.data.message;
                              this.comment.sending = false;
                              this.selectedLeave.comments_count++;
                         }).catch( failed => {
                              this.comment.text = null;
                              this.comment.sending = false;
                              this.comment.errors = collect(
                                   failed.response.data.errors
                              ).flatten().all();
                         });
                    }

              },
              computed: {

                    checkForBlankComment() {
                         return voca.isBlank(this.comment.text);
                    },

                    getDaysInMonth() {
                         return moment().set('month' , this.filters.month ).daysInMonth();
                    },

                   leaveFilter() {

                    let { from , until , month , status } = this.filters;

                    let leaves = this.leaves.data;

                    if (status.value) {
                         switch(status.value) {
                              case 'Pending':
                                   leaves = leaves.filter( leave => {
                                        return leave.pending == true;
                                   });
                              break;

                              case 'Approved':
                                   leaves = leaves.filter( leave => {
                                    return leave.approved == true;
                                   });
                              break;

                              case 'Denied':
                                   leaves = leaves.filter( leave => {
                                   return leave.denied == true;
                                   });
                              break;
                         }
                    }

                    if (month) {
                          leaves = leaves.filter( leave => {
                              return moment().set({'month' : month }).isSame(leave.from , 'month') ||
                              moment().set({ 'month' : month }).isSame(leave.until , 'month');
                         });
                    }


                    if (from) {
                         leaves = leaves.filter( leave => {
                              return moment(leave.from).isSameOrAfter( moment().set({ 'month' : month , 'date' : from }) , 'day' );
                         });
                        }

                    if (until) {
                         leaves = leaves.filter( leave => {
                              return  moment(leave.until).isSameOrBefore( moment().set({ 'month' : month , 'date' : until }) , 'day' );
                         });
                    }

                    return leaves;

                   },
              },
         })
</script>
@endsection
