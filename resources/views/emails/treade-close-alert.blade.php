<x-mail::message>

<b>{{$data['body']['title']}}</b><br>
<b>Trade Exit Date: </b>{{$data['body']['trade_exit_date']}}<br>
<b>Exit Price: </b>${{$data['body']['exit_price']}}<br>
<b>Comments: </b>{{$data['body']['comments']}}<br>
<b>Visit: </b><a href="{{$data['body']['visit']}}" target="_blank">{{$data['body']['visit']}}</a><br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
