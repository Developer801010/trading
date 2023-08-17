<x-mail::message>
Hello <b>{{$data['first_name']}} {{$data['last_name']}},</b>

This is a confirmation that your TradeInSync subscription has been cancelled. You will continue to receive trade updates until your membership expires on {{$data['cancel_at']}}. You can restart membership anytime by going to <a href="{{route('front.account-membership')}}" target="_blank">membership</a>

Thank you, 
{{ config('app.name') }}
<br>

</x-mail::message>
