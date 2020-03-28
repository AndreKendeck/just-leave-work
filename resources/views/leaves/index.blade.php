@extends('layouts.web')


@section('title')
Leaves
@endsection
@section('heading')
Leaves
@endsection

@section('content')
<div class="flex h-screen flex-col" id="leaves">
     <div class="mt-10 p-3 rounded flex flex-col justify-center items-start w-full ">
          <user-leave-card v-for="(leave,idx) in leaves.data" :key="idx" :leave="leave"></user-leave-card>
     </div>
</div>
@endsection
@section('script')
<script>
     new Vue({
              el : '#leaves', 
              data : {
                   leaves : @json($leaves)
              }
         })
</script>
@endsection