@component('mail::message')
# Email Verification Code

Enter the code below.

@component('mail::panel')
    {{ $code }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
