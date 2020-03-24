@extends('layouts.web')
@section('title')
Home
@endsection
@section('heading')
Home
@endsection
@section('content')
<div class="h-screen mx-3 lg:mx-6 flex flex-col lg:flex-row mb-6" id="home">

     <div class="card flex flex-col mt-10 p-4 lg:w-8/12 self-center lg:self-auto shadow-xs w-full">
          <div class="flex flex-col md:flex-row mt-3 justify-between items-center">
               <h3 class="text-lg text-gray-500 tracking-wide "> Leave Calendar - @{{ currentMonth }}
                    @{{ currentYear }}
               </h3>
               <div class="flex flex-col md:flex-row justify-between mt-3 md:mt-0">
                    <select v-model="currentWeek" class="form-select mx-3" v-on:change="changeWeek()"
                         placeholder="Week">
                         <option v-bind:selected="weekNumber == currentWeek" v-bind:value="weekNumber"
                              v-for="weekNumber in numberOfWeeksInYear">
                              @{{  timePeriod(weekNumber)  }}
                         </option>
                    </select>
                    <a class="bg-gray-800 hover:bg-gray-600 text-white py-2 px-1 md:px-3 text-center rounded-lg mt-4 md:mt-0"
                         href="{{ route('leaves.create') }}"> 
                         Add Leave
                    </a>
               </div>
          </div>
          <hr class="my-6" />
          <leave-card v-for="(user,userKey) in users.data" :user="user" :currentweek="currentWeek" :key="userKey">
          </leave-card>
          {{ $users->links() }}
          {{ $users->links('components.simple-paginate') }}
     </div>
     <div class="flex flex-col lg:w-4/12 w-full lg:mx-3">

          <div class="card flex flex-col p-4 min-h-1/4 shadow-xs mt-10 overflow-y-scroll">
               <vue-loader :active="metrics == null"></vue-loader>
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

          <div class="card p-4 min-h-1/4 shadow-xs mt-2"> Lorem ipsum, dolor sit amet consectetur adipisicing elit.
               Sequi, aliquid cumque cum ullam illum aut voluptates quidem accusamus aspernatur ut delectus culpa
               corrupti ipsam voluptatibus totam quos neque nesciunt quibusdam. </div>
          <div class="card p-4 min-h-1/4 shadow-xs mt-2"> Lorem ipsum, dolor sit amet consectetur adipisicing elit.
               Sequi, aliquid cumque cum ullam illum aut voluptates quidem accusamus aspernatur ut delectus culpa
               corrupti ipsam voluptatibus totam quos neque nesciunt quibusdam. </div>
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
               } ); 
          },
     })
</script>
@endsection