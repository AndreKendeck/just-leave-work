@component('mail::message')
# Email Verification Code

Enter the code below.

<small>Note this will expire in 5 minutes</small>

@component('mail::panel')
    {{ $code }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
