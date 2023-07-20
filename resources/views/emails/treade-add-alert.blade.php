<x-mail::message>

<b>{{$data['body']['title']}}</b><br>
<b>Trade Entry Date: </b>{{$data['body']['trade_entry_date']}}<br>
<b>Position Size: </b>{{$data['body']['position_size']}}%<br>
<b>Stop Price: </b>${{$data['body']['stop_price']}}<br>
<b>Target Price: </b>${{$data['body']['target_price']}}<br>
<b>Comments: </b>{{$data['body']['comments']}}<br>
<b>Visit: </b><a href="{{$data['body']['visit']}}" target="_blank">{{$data['body']['visit']}}</a><br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
