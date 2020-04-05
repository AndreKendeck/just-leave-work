@extends('layouts.web')
@section('title')
Users
@endsection
@section('heading')
Users
@endsection
@section('content')
<div id="users" class="w-full h-full mx-4">
     <div class="flex flex-col">

          <div class="card mt-4">
               
          </div>

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