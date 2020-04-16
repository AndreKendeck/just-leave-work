@component('mail::message')

# You have been Invited to {{ $user->team->name . "'s" }} JustLeave


Hi {{ $user->name }} <br>

Here is are your login credientials, don't worry this has been auto-generated no one else
knows this but you.

@component('mail::panel')
  <p> <b>Email</b> : This email address </p>
  <p> <b>Password</b> : <code> {{ $password  }} </code> </p>
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent
