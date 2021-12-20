@component('mail::message')

# Hallo, {{ $user['name'] }}
Click the button below to verify your new email address.

@component('mail::button', ['url' => route('verify-email-change', [
                                'token' => $details->token
                            ]), 'color' => 'custom-primary'])
Verify Email Address Change
@endcomponent


Regards,<br>
{{ config('app.name') }}


@slot('subcopy')
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => 'Verify Email Address Change',
    ]
) <span class="break-all">[{{ route('verify-email-change', [
    'token' => $details->token
]) }}]({{ route('verify-email-change', [
    'token' => $details->token
]) }})</span>
@endslot

@endcomponent
