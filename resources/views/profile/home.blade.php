@extends('layouts.web')
@section('title')
Home
@endsection
@section('heading')
Home
@endsection
@section('content')
<div class="h-screen mx-3 lg:mx-6 flex flex-col lg:flex-row mb-6" id="home">

     <div class="card flex flex-col mt-10 -mb-5 p-4 lg:w-8/12 self-center lg:self-auto shadow-xs w-full">
          <div class="flex flex-col md:flex-row mt-3 justify-between items-center">
               <h3 class="text-lg text-gray-500 tracking-wide "> Leave Calendar - @{{ currentMonth }}
                    @{{ currentYear }}
               </h3>

               <div class="flex justify-between my-3 md:my-1 md:mt-0">

                    <select v-model="currentWeek" class="form-select mx-3" v-on:change="changeWeek()"
                         placeholder="Week">
                         <option v-bind:selected="weekNumber == currentWeek" v-bind:value="weekNumber"
                              v-for="weekNumber in numberOfWeeksInYear">
                              @{{  timePeriod(weekNumber)  }}
                         </option>
                    </select>
                    <a class="bg-gray-800 hover:bg-gray-600 text-white py-2 px-2  md:px-3 text-center rounded-lg "
                         href="{{ route('leaves.create') }}">
                         <svg version="1.1" viewBox="0 0 24 24" class="stroke-current h-8 w-8"
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
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.5,14.7v3.6"></path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19.3,16.5h-3.6"></path>
                              </g>
                         </svg>
                    </a>
                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-2 md:px-3 text-center rounded-lg ml-2"
                         href="{{ route('users.create') }}">
                         <svg version="1.1" viewBox="0 0 24 24" class="h-8 w-8 stroke-current text-gray-700"
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
               </div>
          </div>
          <leave-card v-for="(user,userKey) in users.data" :user="user" :currentweek="currentWeek" :key="userKey">
          </leave-card>
          {{ $users->links() }}
          {{ $users->links('components.simple-paginate') }}
     </div>

     <div class="flex flex-col lg:w-4/12 w-full lg:mx-3">

          <div class="card flex flex-col p-4 min-h-1/4 shadow-xs mt-10 overflow-y-scroll">
               <vue-loader :active="metrics == null" spinner="ring"></vue-loader>
               <h3 class="text-lg text-jean tracking-widest w-1/2 text-center self-center"> Metrics </h3>
               <div class="flex justify-around mt-8 items-center">
                    <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                         <h4 class="text-gray-600 text-lg"> Requested </h4>
                         <div v-if="metrics"> @{{ metrics.requested }} </div>
                    </div>
                    <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full ">
                         <h4 class="text-gray-600 text-lg"> Approved </h4>
                         <div v-if="metrics"> @{{ metrics.approved  }} </div>
                    </div>
                    <div class="flex flex-col items-center hover:bg-gray-200 p-3 rounded-lg w-full">
                         <h4 class="text-gray-600 text-lg"> Denied </h4>
                         <div v-if="metrics"> @{{ metrics.denied  }} </div>
                    </div>
               </div>

          </div>

          <div class="card flex flex-col p-4 min-h-1/4 shadow-xs mt-2 overflow-y-scroll">
               <h3 class="text-lg text-jean tracking-widest w-1/2 text-center self-center"> Legend </h3>
               <div class="flex flex-col">
                    @foreach (\App\Reason::all() as $reason)
                    <span
                         class="mx-1 flex justify-start items-center border-b-2 border-gray-200 p-2 hover:bg-gray-200 rounded">
                         {!! $reason->tag !!} <span class=" mx-3 text-sm text-gray-500">
                              {{ $reason->name }}</span> </span>
                    @endforeach
               </div>
          </div>
          <div class="card flex flex-col p-4 min-h-1/4 shadow-xs mt-2 overflow-y-scroll">
               <vue-loader :active="chart == null" spinner="ring"></vue-loader>
               <h3 class="text-lg text-jean tracking-widest w-1/2 text-center self-center"> Chart </h3>
               <canvas id="chart"></canvas>
          </div>
     </div>
</div>
@endsection
@section('script')
<script>
     new Vue({
          el : '#home',  
          data : {
               currentWeek : moment().week(), 
               currentMonth : moment().format('MMMM'),
               currentYear : moment().format('Y'),  
               numberOfWeeksInYear :  moment().weeksInYear(),    
               users : @json($users),  
               metrics : null, 
               chart : null, 
          }, 
          methods: {
               changeWeek() {
                    this.currentMonth = moment().set('week' , this.currentWeek  ).format('MMMM'); 
               }, 
               timePeriod(week) {
                    return moment().set('week' , week ).startOf('week').format('MMM') + ' ' + moment().set('week' , week ).startOf('week').format('DD') 
                              + ` - ` + moment().set('week' , week ).endOf('week').format('MMM') + ' ' + moment().set('week' , week ).endOf('week').format('DD'); 
               }
          },
          mounted() {
               axios.get('/leave-metrics').then( (response) => {
                    this.metrics = response.data; 
               }); 
               axios.get('/chart').then( response => {
                    this.chart = new Chart( document.getElementById('chart') , {
                         type : 'bar', 
                         data : {
                              labels : ['Jan' , 'Feb' , 'Mar' , 'Apr' , 'May' , 'Jun' , 'Jul' , 'Aug' , 'Sep' , 'Nov' , 'Dec' ], 
                              datasets : [
                                   {
                                        label : 'Current Year leaves', 
                                        backgroundColor : '#0b3954', 
                                        data : response.data
                                   }
                              ]
                         }, 
                         options : {
                              responsive : true, 
                         }
                    } ) 
               });
          },
     })
</script>
@endsection