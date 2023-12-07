<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
{{-- @foreach ($introLines as $line)
{{ $line }}

@endforeach --}}

We received a request to create a new password for your TradeInSync account and for security we need to make sure it's really you. Please click the button below to confirm you requested a password reset.


{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
{{-- @foreach ($outroLines as $line)
{{ $line }}

@endforeach --}}

{{-- Salutation --}}
{{-- @if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif --}}

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>

<span>Need More Help? If you still cannot access your account, contact us at <a href="mailto:support@tradeinsync.com"></a>. Our Support Team is available Monday-Friday from 9a - 5p CT to assist.</span>
</x-slot:subcopy>
@endisset



</x-mail::message>
