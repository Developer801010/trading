<x-mail::message>

<b>{{$data['body']['title']}}</b><br>
<b>Trade Entry Date: </b>{{$data['body']['trade_exit_date']}}<br>
<b>Position Size: </b>{{$data['body']['position_size']}}%<br>
<b>{{$data['body']['trade_direction']}} Price: </b>${{$data['body']['exit_price']}}<br>
<b>Profit: </b> {{$data['body']['profits']}}%<br>
<b>Comments: </b>{{$data['body']['comments']}}<br>
{{-- <b>Visit: </b><a href="{{$data['body']['visit']}}" target="_blank">{{$data['body']['visit']}}</a><br> --}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
