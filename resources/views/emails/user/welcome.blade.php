@component('mail::message')
# Welcome {{ $user->name }}

We are so glad you chose our platform to manage leave without your, team.
We know that leave request forms, emails , texts, phone calls etc... can be tiresome & stressful
when dealing with leave days

You have been added to  <a>justleave.work</a> platform

Here is your password

@component('mail::panel')
{{ $password }}
@endcomponent

If you need to get started quickly check out our quick tutorial video below:

Thanks,<br> 
{{ config('app.name') }}
@endcomponent
