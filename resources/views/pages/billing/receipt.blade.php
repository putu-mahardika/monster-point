@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Receipt')


@section('content')
<div class="row">
    <div class="col">
        <div class="card rounded-xxl" style="min-height: calc(100vh - 10.3rem);">
                <div class="card-body">
                    <div class="position-relative" style="overflow: hidden; font-size: 11pt !important; width:210mm; height:297mm; padding:1cm;" id="invoice-print">
                        <img class="position-absolute" src="{{ asset('/img/lunas.png')}}" style="top:20rem; left:10rem; opacity: 0.5; transform: rotate(-27deg);">
                        <div class="row">
                            <div class="col">
                                <table class="table table-borderless">
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
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>No</td>
                                        <td class="text-start"> : 001</td>
                                    </tr>
                                    <tr>
                                        <td>Tgl</td>
                                        <td class="text-start">: 29 November 2021</td>
                                    </tr>
                                    <tr>
                                        <td> Merchant </td>
                                        <td class="text-start">: PT BAIK SEKALI</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col">
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
                            </div>
                        </div>


                        <div class="row p-3">
                            <div class="col">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr width="100">
                                            <td>1</td>
                                            <td>Hit Bulan November 2021</td>
                                            <td class="text-end">10.735</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Sisa Hit Oktober 2021</td>
                                            <td class="text-end">1.515</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col">
                                        <hr>
                                    </div>
                                </div>
                                <table  class="table table-borderless">
                                    <tr width="100">
                                        <td>Total Hit</td>
                                        <td class="text-end">12.250</td>
                                    </tr>
                                    <tr>
                                        <td>Ditagihkan</td>
                                        <td class="text-end">12.000</td>
                                    </tr>
                                    <tr>
                                        <td>Akumulasi bulan depan</td>
                                        <td class="text-end">250</td>
                                    </tr>
                                    <tr>
                                        <td>Tarif Per 1000 Hit</td>
                                        <td class="text-end">100.000</td>
                                    </tr>
                                    <tr>
                                        <td> </td>
                                    </tr>
                                </table>
                                <hr>
                            </div>
                        </div>


                        <div class="row p-3">
                            <div class="col">
                                <table class="table">
                                    <tr width="100" >
                                        <td>Total Biaya (1000 x 12)</td>
                                        <td class="text-end fs-4">Rp 1.200.000,-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                           <div class="col">
                                <a href="">Info cara pembayaran</a>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                                <a href="">Kembali ke Admin</a>
                           </div>
                        </div>
                    </div>

                </div>
        </div>
    </div>

</div>

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
