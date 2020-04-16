@component('mail::message')

# Your ban from {{ $user->team->name . "'s" }} JustLeave has been lifted


Hi {{ $user->name }} , <br>

You are no longer banned from your teams JustLeave you can login as normal <br>

@component('mail::button', ['url' => route('login') ])
Login
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent
