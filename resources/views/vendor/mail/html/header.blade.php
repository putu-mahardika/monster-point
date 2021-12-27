<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{-- {{ $slot }} --}}
<img src="{{ asset("img/logo_ps_long.png") }}" height="53" data-auto-embed="attachment">

@endif
</a>
</td>
</tr>
