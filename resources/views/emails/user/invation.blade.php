@component('mail::message')

# You have been Invited to {{ $user->team . "'s" }} JustLeave


Hi {{ $user->name }} <br>

Here is are your login credientials, don't worry this has been auto-generated no one else
knows this but you.




Thanks, <br>
{{ config('app.name') }}
@endcomponent
