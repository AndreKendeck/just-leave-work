@component('mail::message')
    # Reset your account password.

    Hey {{ $user-> }}
    
    @component('mail::button', ['url' => route('index')])
        Login
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
