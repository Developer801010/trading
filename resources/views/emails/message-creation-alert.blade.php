<x-mail::message>
<style>
    p{
        margin-bottom: 1px;
    }
</style>

<b>{{$data['first_title']}}</b>
<br>
<br>

{!! $data['message'] !!}<br>

Date: {{ $data['date_added'] }}
<br><br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
