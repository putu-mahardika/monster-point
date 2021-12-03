@component('mail::message')

@component('mail::table')
|                               |               |         <span style="color:rgb(5, 5, 158);">INVOICE</span>  |
| ------------------------------|:-------------:| ---------------------: |
| No       :  {{$details['noInvoice']}}               |               | Periode : {{$details['bulanLalu']}}|
| Date     : {{$details['tglInvoice']}}         |               | #[ PAID ]               |
| Merchant : {{$details['namaMerchant']}}            |               | Paid Date :  {{$details['jatuhTempo']}}                |
|         |               |                |
|1. Hit Bulan {{$details['bulanIni']}}            |           |{{$details['totalHitBulanIni']}}     |
|2. Sisa Hit Bulan {{$details['bulanLalu']}}       |           |{{$details['sisaHitBulanLalu']}}     |
@endcomponent
@component('mail::table')
|                               |               |                        |
| ------------------------------|:-------------:| ---------------------: |
|   Total hit                     |           | {{$details['totalHit']}}    |
|   Ditagihkan                    |           | {{$details['hitDitagihkan']}}    |
|   Akumulasi bulan depan         |           | {{$details['sisaHitBulanIni']}}    |
|   Tarif per hit                 |           | {{$details['Tarif']}}   |
|   Total biaya (1000 x 12)       |           | {{$details['Biaya']}}   |
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


Thanks,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::button', ['url' => ''])
Pilih Metode Pembayaran
@endcomponent
