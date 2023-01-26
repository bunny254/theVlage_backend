@component('mail::message')
# Hi {{ $user->surname ?? $user->email }},

You are receiving this email because you requested a password reset for your Vlage Account.

Use the following credentials to login:

@component('mail::panel')
Username: <b>{{ $user->email }}</b>
Password: <b>{{ $password }}</b>
@endcomponent

This is a temporary password and it's highly recommend to change it on your successful login

Kind Regards,<br>
{{ config('app.name') . __(' Team') }}
@endcomponent
