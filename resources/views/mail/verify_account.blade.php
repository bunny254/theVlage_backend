@component('mail::message')
# Hi {{ $user->surname ?? $user->email }},

Welcome to the {{ config('app.name') }}. Use the following code to verify your Account:

@component('mail::panel')
<h2>{{ $code }}</h2>
@endcomponent

Kind Regards,<br>
{{ config('app.name') . __(' Team') }}
@endcomponent
