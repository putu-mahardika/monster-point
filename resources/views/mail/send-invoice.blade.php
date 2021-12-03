@component('mail::message')
Dear Sir/Madam -User Name-

Thank you for choosing Monster Point Service!
Here is an invoice that needs to be paid immediately.

@component('mail::table')
|                               |               |         <span style="color:rgb(5, 5, 158);">INVOICE</span>  |
| ------------------------------|:-------------:| ---------------------: |
| No       :  001               |               | Periode : December 2021|
| Date     : 1 Dec 2021         |               | #[ BILLED ]               |
| Merchant : Nama PT            |               | Due Date :  1 December 2021                |
|         |               |                |
|1.  November Hits          |           |10.775     |
|2.  Remaining Hits of November      |           |1.515     |
@endcomponent
@component('mail::table')
|                               |               |                        |
| ------------------------------|:-------------:| ---------------------: |
|   Hit Totals                  |           | 12.250    |
|   Billed                    |           | 12.000    |
|   Accumulate next month         |           | 250    |
|   Rate per 1000 hits            |           | 100.000   |
|   23 / 5000
|   Total cost (1000 x 12)        |           | 1.200.000   |


<b><u> Payment Method </u></b>

<b>1. Bank Transfer / QR Code (GO-PAY/OVO/DANA/m-BCA) / Credit Card (via Midtrans)</b>

<p>All payments through Midtrans do not require manual payment confirmation and orders are processed immediately.</p>

https://monsterpointservice/viewinvoice.php?id=410835

Silahkan klik link di atas untuk melakukan pembayaran:
- Bank Transfer / Virtual Account: BCA, ATM Bersama, Prima atau Alto
- QRIS Code: GO-PAY, OVO, Dana, LinkAja, m-BCA, dsb.
- Credit Card: Visa, Mastercard atau JCB
- LINE Pay e-cash
- Mandiri e-cash


<b>2. Bank Transfer Manual</b>
<ul>
    <li>CIMB NIAGA</li>
    <li>Recipient's name: Monster Point Service</li>
    <li>Account number: 287-287-8000</li>
</ul>



<i><u>LATE PAYMENT</u></i>

This bill is due : 14-10-2021

Please make payment now.
Late payments will cause your account to be suspended and your website will be down, until payment is received.
------------------------------------------------------

Please contact us if you need assistance via email: marketing@monstergroup.com or telephone: 021-2212-4702.

Thank you for your cooperation.

-Monster Point Service Billing Dept.
_____
https://www.monstergroup.co.id
Secure, Fast and Reliable Point Service Expert
_____
Share your experience - https://monstergroup.co.id/feedback
visit our website | log in to your account | get support
© 2021 Monster Point. All rights reserved..

@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Metode Pembayaran
@endcomponent --}}
