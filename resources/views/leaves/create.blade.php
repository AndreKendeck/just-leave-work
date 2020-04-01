@extends('layouts.web')
@section('title')
Request leave
@endsection
@section('heading')
Request leave
@endsection
@section('content')
<div class="h-screen mx-2">
     <h3 class="text-jean mt-3 text-center text-lg"> Request leave </h3>
     <div class="card p-3 flex-col shadow-xs mt-3">
          <form action="{{ route('leaves.store') }}" method="post">
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