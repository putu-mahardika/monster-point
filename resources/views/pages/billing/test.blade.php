@component('mail::message')

@component('mail::table')
@endcomponent

<table  style="border: 1px solid black">
    <tr>
        <td>
            <a class="navbar-brand ps-3" href="index.html">
                <img src="{{ asset('/img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:53px; width:auto;">
            </a>
        </td>
        <td class="text-end">
            <h3 class="text-end me-2 fw-bold" style="color:rgb(5, 5, 158);">RECEIPT</h3>
        </td>
    </tr>
</table>


<table  style="border: 1px solid black">
    <tr>
        <td>No</td>
        <td class="text-start"> : 001</td>
    </tr>
    <tr>
        <td>Date</td>
        <td class="text-start">: 29 November 2021</td>
    </tr>
    <tr>
        <td> Merchant </td>
        <td class="text-start">: PT BAIK SEKALI</td>
    </tr>
</table>

<table class="table table-borderless text-start">
    <tr>
        <td>Periode</td>
        <td>: November 2021</td>
    </tr>
    <tr>
        <td>Status</td>
        <td><h3><i>PAID</i></h3></td>
    </tr>
    <tr>
        <td>Date Paid :</td>
        <td>30 November 2021</td>
    </tr>
</table>

<table  style="border: 1px solid black">
    <tbody>
        <tr width="100">
            <td>1</td>
            <td>Hits in November 2021</td>
            <td class="text-end">10.735</td>
        </tr>
        <tr>
            <td>2</td>
            <td>October Hits Remaining 2021</td>
            <td class="text-end">1.515</td>
        </tr>
    </tbody>
</table>

<hr>

<table   style="border: 1px solid black">
    <tr width="100">
        <td>Total Hits</td>
        <td class="text-end">12.250</td>
    </tr>
    <tr>
        <td>Billed</td>
        <td class="text-end">12.000</td>
    </tr>
    <tr>
        <td>Accumulate next month</td>
        <td class="text-end">250</td>
    </tr>
    <tr>
        <td>Rates Per 1000 Hits</td>
        <td class="text-end">100.000</td>
    </tr>
</table>
<hr>


<table class="table">
    <tr width="100" >
        <td>Total Cost (1000 x 12)</td>
        <td class="text-end fs-4">Rp 1.200.000,-</td>
    </tr>
</table>

                                Thanks,<br>
                                {{ config('app.name') }}
                                @endcomponent

                                @endsection
                                @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(() => {
            var element = document.getElementById('invoice-print');
            html2pdf(element).output();
        });
    </script>
@endsection
