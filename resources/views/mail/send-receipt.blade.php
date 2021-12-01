@component('mail::message')

@component('mail::table')
|                               |               |         <span style="color: red"> INVOICE</span>  |
| ------------------------------|:-------------:| ---------------------: |
| No       :  001               |               | Periode : Desember 2021|
| Date     : 1 Dec 2021         |               | [ BILLED ]             |
| Merchant : Nama PT            |               |                        |
|1. Hit Bulan Desember            |           |10.775     |
|2. Sisa Hit Bulan November       |           |10.775     |
|   Total hit                     |           | 12.250    |
|   Ditagihkan                    |           | 12.250    |
|   Akumulasi bulan depan         |           | 12.000    |
|   Tarif per hit                 |           | 100.000   |
|   Total biaya (1000 x 12)       |           | 100.000   |
|Metode Pembayaran : Go-Pay       |           |           |
@endcomponent

{{-- <h1>{{ $details['title'] }}</h1>
<p>{{ $details['body'] }}</p>
<table style="border: 1px solid black">
    <tr>
        <td>foo</td>
        <td>bar</td>
    </tr>
</table> --}}

@component('mail::button', ['url' => ''])
Metode Pembayaran
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
