@component('mail::message')
# Leave Request from {{ $leave->user->name }} <br>

For: {{ $leave->reason->name }}

@if ($leave->is_for_one_day)
<b>On - {{ $leave->from->toFormattedDateString() }}</b>
@else
<b>On - {{ $leave->from->toFormattedDateString() }}</b><br/>
<b>Until - {{ $leave->until->toFormattedDateString() }}</b>
@endif

@component('mail::button', ['url' => url("/leave/view/{$leave->id}")])
View Leave
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
