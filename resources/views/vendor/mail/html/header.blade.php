@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset('assets/image/logo.png')}}" class="logo" alt="Trading Logo" style="width: 95px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
