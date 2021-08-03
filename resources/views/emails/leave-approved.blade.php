@component('mail::message')
# Your leave for {{ $leave->from->toFormattedDateString() }} has been approved

Hurray, {{ $leave->user->name }} 🎉

Your leave has been approved.

@component('mail::button', ['url' => url("/leave/view/{$leave->id}")])
View Leave
@endcomponent

Enjoy your time off,<br>
{{ config('app.name') }}
@endcomponent
