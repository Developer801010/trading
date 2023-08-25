<x-mail::message>
<style>
    p{
        margin-bottom: 1px;
    }
</style>
<b>{{$data['body']['title']}}</b><br>
<b>Trade Entry Date: </b>{{$data['body']['trade_entry_date']}}<br>
<b>Trade Entry Price: </b>${{$data['body']['trade_entry_price']}}<br>
<b>Position Size: </b>{{$data['body']['position_size']}}%<br>
@if (is_numeric($data['body']['stop_price']))
<b>Stop Price: </b>{{ '$' . number_format((float) $data['body']['stop_price'], 0) }}<br>
@else
<b>Stop Price: </b>{{ $data['body']['stop_price'] }}<br>
@endif
<b>Target Price: </b>${{$data['body']['target_price']}}<br>
<b>Comments: </b>{!! $data['body']['comments'] !!}<br>
<b>Visit: </b><a href="{{$data['body']['visit']}}" target="_blank">{{$data['body']['visit']}}</a><br>


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
