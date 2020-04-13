@component('mail::message')

# Comment on Leave no. {{ $comment->leave->number }}

{{ $comment->user->name }} has left a comment on your leave

@component('mail::button', ['url' => route('leaves.show' , $comment->leave->id ) ])
View
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent
