@component('mail::message')
# Your leave for {{ $leave->from->toFormattedDateString() }} has been denied

Sorry {{ $leave->user->name }},
your leave has been denied.

@component('mail::button', ['url' => url("/leave/view/{$leave->id}")])
View Leave
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
