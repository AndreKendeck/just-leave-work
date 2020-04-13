@component('mail::message')

# Leave no {{ $approval->leave->number }} has been approved

{{ $approval->user->name }} has approved your leave

@component('mail::button', ['url' => route('leaves.show' , $approve->leave->id ) ])
    View
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent
