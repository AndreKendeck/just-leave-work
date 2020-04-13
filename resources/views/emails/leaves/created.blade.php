@component('mail::message')

# Leave no {{ $leave->number }} has been requested

{{ $leave->user->name }} has approved your leave

@component('mail::button', ['url' => route('leaves.show' , $leave->id ) ])
    View
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent
