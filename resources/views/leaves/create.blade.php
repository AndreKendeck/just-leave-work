@extends('layouts.web')
@section('title')
Request leave
@endsection
@section('heading')
Request leave
@endsection
@section('content')
<div class="mx-2 flex flex-col w-full h-full">

     <div class="card p-3 flex-col shadow-xs mt-3 pb-4 w-full lg:w-1/2 self-center">
          <h3 class="text-jean my-3 text-center text-lg"> Request leave </h3>
          <form action="{{ route('leaves.store') }}" class="w-full" method="post">
               @csrf
               @select(['name' => 'reason_id' , 'required' => true , 'label' => 'Reason' ])
               @foreach ($reasons as $reason)
               <option @if (old('reason_id')===$reason->id)
                    selected=""
                    @endif value="{{ $reason->id }}">
                    {{ $reason->name }}
               </option>
               @endforeach
               @endselect

               @select(['name' => 'reporter_id' , 'required' => false , 'label' => 'Report to? ' ])
               @foreach ($reporters as $reporter)
               <option @if (old('reporter_id')===$reporter->id)
                    selected=""
                    @endif value="{{ $reporter->id }}">
                    {{ $reporter->name }}
               </option>
               @endforeach
               @endselect

               @field(['name' => 'from' , 'label' => 'From Date' , 'required' => true  ])
               @field(['name' => 'until' , 'label' => 'Until Date' , 'required' => true  ])
               @textarea(['name' => 'description' , 'label' => 'Description' , 'required' => true  ])

               <button type="submit" class="mt-4 bg-jean hover:bg-gray-800 text-white self-center ml-2"> Submit  </button>
          </form>
     </div>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
     $('#from').datepicker(); 
     $('#until').datepicker(); 
</script>
@endsection