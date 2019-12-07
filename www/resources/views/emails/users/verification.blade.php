@component('mail::message')
# Welcome, {{ explode(' ', $user->name)[0] }}

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
