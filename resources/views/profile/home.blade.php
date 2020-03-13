@extends('layouts.web')
@section('title')
Home
@endsection
@section('heading')
Home
@endsection
@section('content')
<div class="h-screen mx-2 flex flex-col" id="home">
     <div class="flex self-center justify-between">
          @checkbox(['name' => 'pending' , 'value' => 1 , 'label' => 'Pending' ])
          @checkbox(['name' => 'approved' , 'value' => 2 , 'label' => 'Approved' ])
          @checkbox(['name' => 'denied' , 'value' => 3 , 'label' => 'Denied' ])
     </div>
     <select name="people" id="people" v-model="user" class="form-select mt-10 w-3/4 self-center ">
          <option v-bind:value="0" selected="" >Everyone</option>
          @foreach (Auth::user()->organization->users as $user)
               <option v-bind:value="{{ $user->id  }}">{{ $user->name  }}</option>
          @endforeach
     </select>
     @component('components.paginate')
     @endcomponent
</div>
@endsection
@section('script')
<script>
     const home = new Vue({
              el : '#home', 
              data : {
                   user : null, 
                   selectedLeaveStatus : []
              }, 
              methods : {

              }
         }); 
</script>
@endsection