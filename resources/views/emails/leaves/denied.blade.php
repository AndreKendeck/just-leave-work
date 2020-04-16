@component('mail::message')

# Leave no {{ $denial->leave->number }} has been denied

{{ $denial->user->name }} has denied your leave

@component('mail::button', ['url' => route('leaves.show' , $denial->leave->id ) ])
View
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent
