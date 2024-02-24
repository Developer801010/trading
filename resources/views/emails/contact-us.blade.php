<x-mail::message>
Name: <b>{{$data['name']}}</b>
<br>
Email: {{$data['email']}}
<br>
<br>
{!! $data['message'] !!}<br>
<br><br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
