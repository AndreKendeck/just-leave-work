@component('mail::message')

# Welcome to Justleave , a better leave management platform


Hi {{ $user->name }} <br>

Thank you for signing up, click the button below to login

@component('mail::button', ['url' => route('login') ])
Login
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent
