@component('mail::message')

# You have been banned from {{ $user->team->name . "'s" }} JustLeave


Hi {{ $user->name }} , <br>

You will no longer be able to request leave or login to the platform until your ban is lifted.


Thanks, <br>
{{ config('app.name') }}
@endcomponent
