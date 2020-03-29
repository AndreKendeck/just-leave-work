@extends('layouts.web')


@section('title')
Leaves
@endsection
@section('heading')
Leaves
@endsection

@section('content')
<div class="flex h-screen w-screen flex-col" id="leaves">
     <div class="mt-10 p-3 rounded flex flex-col justify-center items-start w-full">
          
          <div
               class="card flex flex-col justify-between lg:flex-row p-3 w-full justify-center self-center md:w-3/4 lg:w-1/2">

               <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                    <span class="text-gray-600 text-sm"> User </span>
                    <input type="search" v-model="filters.search" class="w-full" placeholder="Search...">
               </div>

               <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                    <span class="text-gray-600 text-sm"> Month </span>
                    <select name="from" id="from" v-model="filters.month" placeholder="From"
                         class="form-select w-full border-gray-300 border-2 focus:outline-none">
                         <option v-bind:value="month" v-bind:selected="filters.month === month"
                              v-for="(month,idx) in months" :key="idx"> @{{ formatMonth(month) }} </option>
                    </select>
               </div>

               <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                    <span class="text-gray-600 text-sm"> From </span>
                    <select name="from" id="from" v-model="filters.from" placeholder="From"
                         class="form-select w-full border-gray-300 border-2 focus:outline-none">
                         <option v-bind:value="null" v-bind:selected="filters.from == null"></option>
                         <option v-bind:value="day" v-bind:selected="filters.from == day"
                              v-for="(day ,idx) in getDaysInMonth" :key="idx"> @{{ formatDay(day) }} </option>
                    </select>
               </div>

               <div class="flex flex-col lg:mx-2 w-full mt-2 md:mt-0">
                    <span class="text-gray-600 text-sm"> Until </span>
                    <select name="from" id="from" v-model="filters.until" placeholder="From"
                         class="form-select w-full border-gray-300 border-2 focus:outline-none">
                         <option v-bind:value="null" v-bind:selected="filters.until == null"></option>
                         <option v-bind:value="day" v-bind:selected="filters.until == day"
                              v-for="(day ,idx) in getDaysInMonth" :key="idx"> @{{ formatDay(day) }} </option>
                    </select>
               </div>

          </div>
          <div class="flex flex-col items-center overflow-y-scroll mt-2 w-full lg:w-1/2 self-center leave-cards"  >
               <user-leave-card v-on:selected="selectLeave(leave)" v-for="(leave,idx) in searchableFilter" :key="idx"
                    :leave="leave"></user-leave-card>
                    <hr class="w-full border-2 bg-gray-200">
          </div>

          {{ $leaves->links() }}
          {{ $leaves->links('components.simple-paginate') }}
     </div>
     <div class="modal-backdrop" v-show="selectedLeave">
          <div class="bg-white p-3 flex flex-col z-20 mx-6 rounded md:w-1/2 animated fadeInDown faster">
               <div class="flex justify-between items-center mb-4">
                    <div class="text-jean text-center text-lg tracking-widest">Leave</div>
                    <button class="p-1 rounded hover:bg-gray-200 " v-on:click="selectedLeave = null">
                         <svg version="1.1" class="h-8 w-8 stroke-current text-blue-800" viewBox="0 0 24 24"
                              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                              <g fill="none">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8,8l8,8">
                                   </path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16,8l-8,8">
                                   </path>
                              </g>
                         </svg>
                    </button>
               </div>
               Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorum porro sapiente, qui sunt sed ullam!
               Fuga odit facere rerum doloribus voluptatibus eligendi at, autem repudiandae soluta in. Voluptatibus,
               veniam quam.
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
               months : [ 0 , 1 ,2 ,3 , 4 , 5 ,6 ,7 , 8, 9 ,10 ,11 ] ,
               filters : {
                    search : null, 
                    month : moment().get('month'), 
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
                         return moment().set('month',month ).format('MMMM'); 
                    }, 
                    formatDay(day) {
                         return moment().set({ 'month' : this.filters.month , 'date' : day }).format('ddd D'); 
                    }
                    
              }, 
              computed: {

                    getDaysInMonth() {
                         return moment().set('month' , this.filters.month ).daysInMonth(); 
                    }, 

                   searchableFilter() {
                        if (this.filters.search == null) {
                             return this.timeFilter; 
                        }
                        return this.timeFilter.filter( leave => {
                             return leave.user.name.match( voca.capitalize(this.filters.search) ); 
                        } ); 
                   }, 
                   timeFilter() {
                        let { from , until } = this.filters; 
                        let leaves = this.leaves.data.filter( leave => {
                             return (moment(leave.from).get('month') == this.filters.month) || (moment(leave.until).get('month') == this.filters.month) 
                        } ); 
                        if (( from == null) && ( until == null ) ) {
                               return leaves; 
                        }
                        if ((from != null) && (until == null) ) {
                         return leaves.filter( leave => {
                              return moment(leave.from).isSameOrAfter( moment().set({ 'month' : this.filters.month , 'date' : this.filters.from })  ); 
                        });       
                        }
                        if ( (from == null) && (until != null) ) {
                         return leaves.filter( leave => {
                              return  moment(leave.until).isSameOrBefore( moment().set({ 'month' : this.filters.month , 'date' : this.filters.until }) ); 
                        } );
                        }
                        return leaves.filter( leave => {
                              return moment(leave.from).isSameOrAfter(
                                   moment().set({ 'month' : this.filters.month , 'date' : this.filters.from })
                              ) && moment(leave.until).isSameOrBefore(
                                   moment().set({ 'month' : this.filters.month , 'date' : this.filters.until })
                              ); 
                        } );
                   }
              },
         })
</script>
@endsection