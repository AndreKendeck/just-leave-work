@component('mail::message')

# Leave no {{ $leave->number }} has been requested

{{ $leave->user->name }} has requested for your review on their leave request  <br>

@component('mail::button', ['url' => route('leaves.show' , $leave->id ) ])
    View
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent
