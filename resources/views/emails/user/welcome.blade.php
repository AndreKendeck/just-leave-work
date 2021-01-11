@component('mail::message')
    # Welcome to JustLeave.Work

    We are so glad you chose our platform to manage leave without your, team.
    We know that leave request forms, emails , texts, phone calls etc... can be tiresome & stressful
    when dealing with leave days <br />

    If you need to get started quickly check out our quick tutorial video below:

    - 


    @component('mail::button', ['url' => ''])
        Verify your email address.
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
