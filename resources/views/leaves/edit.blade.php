@extends('layouts.web')
@section('title')
    Edit Leave no. {{ $leave->number }}
@endsection
@section('heading')
    Edit Leave no. {{ $leave->number }}
@endsection
@section('content')
<div class="mx-2 flex flex-col w-full h-full"> 
     <div class="card p-3 flex-col shadow-xs mt-3 pb-4 w-full lg:w-1/2 self-center">
          <h3 class="text-jean my-3 text-center text-lg"> Edit leave no. {{ $leave->number }} </h3>
          <form action="{{ route('leaves.update' , $leave->id ) }}" class="w-full" method="post">
               @csrf
          
               @field(['name' => 'reason' , 'label' => 'Reason' , 'required' => true , 'disabled' => true , 'value' => $leave->reason->name ])
               @field(['name' => 'reporter' , 'label' => 'Reporter' , 'required' => true , 'disabled' => true  , 'value' => $leave->reporter->name ?? 'Anyone' ])
               @field(['name' => 'from' , 'label' => 'From Date' , 'required' => true , 'disabled' => true , 
               'value' => $leave->from->toFormattedDateString()  ])
               @field(['name' => 'until' , 'label' => 'Until Date' , 'required' => true , 'disabled' => true  , 
               'value' => $leave->until->toFormattedDateString() ])
               @textarea(['name' => 'description' , 'label' => 'Description' , 'required' => true , 'value' => $leave->description ])

               <button type="submit" class="mt-4 bg-jean hover:bg-gray-800 text-white self-center ml-2"> Submit  </button>
          </form>
     </div>
</div>
@endsection

@section('script')
    
@endsection