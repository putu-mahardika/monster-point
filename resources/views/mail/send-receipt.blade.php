@component('mail::message')
<h1> <b>Monster Point Service</b></h1>

<h3>IDR 159.500</h3>
<hr>
<b>GO-PAY</b>

<table>
    <tr>
        <td>17 Desember 2020 - 19:51:20</td>
        <td>ORDER ID: 338268</td>
    </tr>
    <tr style="color: green">
        <td>Transaction has been Successful</td>
    </tr>
</table>



Thanks,<br>
{{ config('app.name') }}
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Metode Pembayaran
@endcomponent --}}
