@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://todosss.s3.ap-southeast-2.amazonaws.com/file+2.png" class="logo" alt="App Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
