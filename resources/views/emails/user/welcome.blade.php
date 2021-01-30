@component('mail::message')
    # Welcome to justleave.work

    We are so glad you chose our platform to manage leave without your, team.
    We know that leave request forms, emails , texts, phone calls etc... can be tiresome & stressful
    when dealing with leave days <br />

    @if (isset($password))

        ## You have been added to {{ $user->team->display_name }} justleave.work Platform <br>

        Here are your login details

        ```Email: This email address
        Password: {{ $password }} ```

    @endif

    If you need to get started quickly check out our quick tutorial video below:



    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
