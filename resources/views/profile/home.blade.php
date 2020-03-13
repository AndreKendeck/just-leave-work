@extends('layouts.web')
@section('title')
Home
@endsection
@section('heading')
Home
@endsection
@section('content')
<div class="h-screen mx-2 flex flex-col">
     <div class="flex justify-between">
          @checkbox(['name' => 'pending' , 'value' => 1 , 'label' => 'Pending' ])
          @checkbox(['name' => 'approved' , 'value' => 2 , 'label' => 'Approved' ])
          @checkbox(['name' => 'denied' , 'value' => 3 , 'label' => 'Denied' ])
     </div>
</div>
@endsection