@php
    $merchantSelect2 = App\Models\Merchant::all(['Id', 'Nama']);
@endphp
@extends('layouts.main')

@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Dashboard')

@section('content')
    @if (session('status'))
        <div class="alert alert-success mb-4 alert-dismissible fade show rounded-xl">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(auth()->user()->can('dashboard chart 1 access') || auth()->user()->can('dashboard chart 2 access'))
        <div class="row">
            @can('dashboard chart 1 access')
                <div class="@cannot('dashboard chart 2 access') col @endcannot @can('dashboard chart 2 access') col-md-6 @endcan mb-3">
                    <div class="card rounded-xxl">
                        <div class="card-header">
                            Daily Point Transactions
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-6 mb-3 text-lg-start text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button id="btnDay_chart1" type="button" data-code="d" class="btn-type-date-chart1 btn btn-sm py-0 px-3 rounded-xl-start btn-primary">D</button>
                                        <button id="btnMonth_chart1" type="button" data-code="M" class="btn-type-date-chart1 btn btn-sm py-0 px-3 btn-outline-primary">M</button>
                                        <button id="btnYear_chart1" type="button" data-code="y" class="btn-type-date-chart1 btn btn-sm py-0 px-3 rounded-xl-end btn-outline-primary">Y</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3 text-lg-end text-center">
                                    <button type="button" id="btnDatePrev_chart1" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" id="btnDateLabel_chart1" class="btn btn-sm py-0 px-2 rounded-xl btn-primary mx-2 px-2"></button>
                                    <button type="button" id="btnDateNext_chart1" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row justify-content-between mb-3">
                                <div class="col-auto">
                                    <div class="row">
                                        <div class="col">
                                            <span class="small text-muted d-block">
                                                Success
                                            </span>
                                            <span id="chart1Success" class="fs-4 d-block"></span>
                                            <span style="font-size: .7rem;" class="text-success d-block">
                                                <i class="fas fa-arrow-up"></i> <span id="chart1SuccessStat"></span>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <span class="small text-muted d-block">
                                                Failed
                                            </span>
                                            <span id="chart1Failed" class="fs-4 d-block"></span>
                                            <span style="font-size: .7rem;" class="text-danger d-block">
                                                <i class="fas fa-arrow-down"></i> <span id="chart1FailedStat"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto d-flex">
                                    <a href="#" class="small text-dark text-decoration-none text-muted">
                                        Detail <i class="fas fa-chevron-right ms-2" style="margin-top: .2rem"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="chart1"></div>
                                </div>
                            </div>

                            @if (auth()->user()->is_admin)
                                <div class="accordion rounded-xxl" id="chart1Setting">
                                    <div class="accordion-item rounded-xxl">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed rounded-xxl" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#chart1SettingBody" aria-expanded="false"
                                                aria-controls="chart1SettingBody">
                                                <i class="fas fa-cogs me-1"></i> Settings
                                            </button>
                                        </h2>
                                        <div id="chart1SettingBody" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#chart1Setting">
                                            <div class="accordion-body">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <select name="chart1FilterMerchant" id="chart1FilterMerchant" class="select2" style="width: 100%;">
                                                            <option></option>
                                                            @foreach ($merchantSelect2 as $merchant)
                                                                <option value="{{ $merchant->Id }}">{{ $merchant->Nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer small">
                            Updated At: <span id="chart1time"></span>
                        </div>
                    </div>
                </div>
            @endcan
            @can('dashboard chart 2 access')
                <div class="@cannot('dashboard chart 1 access') col @endcannot @can('dashboard chart 1 access') col-md-6 @endcan mb-3">
                    <div class="card rounded-xxl">
                        <div class="card-header">
                            Top 10 Total Points & Transactions
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-6 mb-3 text-lg-start text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button id="btnDay_chart2" type="button" data-code="d" class="btn-type-date-chart2 btn btn-sm py-0 px-3 rounded-xl-start btn-primary">D</button>
                                        <button id="btnMonth_chart2" type="button" data-code="M" class="btn-type-date-chart2 btn btn-sm py-0 px-3 btn-outline-primary">M</button>
                                        <button id="btnYear_chart2" type="button" data-code="y" class="btn-type-date-chart2 btn btn-sm py-0 px-3 rounded-xl-end btn-outline-primary">Y</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3 text-lg-end text-center">
                                    <button type="button" id="btnDatePrev_chart2" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" id="btnDateLabel_chart2" class="btn btn-sm py-0 px-2 rounded-xl btn-primary mx-2 px-2"></button>
                                    <button type="button" id="btnDateNext_chart2" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div id="chart2"></div>
                                </div>
                            </div>
                            <div class="accordion rounded-xxl" id="accordionExample">
                                <div class="accordion-item rounded-xxl">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed rounded-xxl" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                            <i class="fas fa-cogs me-1"></i> Settings
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @if (auth()->user()->is_admin)
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <select name="chart2FilterMerchant" id="chart2FilterMerchant" class="select2" style="width: 100%;">
                                                            <option></option>
                                                            @foreach ($merchantSelect2 as $merchant)
                                                                <option value="{{ $merchant->Id }}">{{ $merchant->Nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <select name="chart2OrderField1" id="chart2OrderField1" class="form-select rounded-xl" style="width: 100%;">
                                                        <option value="Hit" selected>Hit</option>
                                                        <option value="Point">Point</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <select name="chart2OrderType1" id="chart2OrderType1" class="form-select rounded-xl" style="width: 100%;">
                                                        <option value="asc">asc</option>
                                                        <option value="desc" selected>desc</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <select name="chart2OrderField2" id="chart2OrderField2" class="form-select rounded-xl" style="width: 100%;">
                                                        <option value="">None</option>
                                                        <option value="Hit">Hit</option>
                                                        <option value="Point">Point</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <select name="chart2OrderType2" id="chart2OrderType2" class="form-select  rounded-xl" style="width: 100%;">
                                                        <option value="asc">asc</option>
                                                        <option value="desc">desc</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer small">
                            Updated At: <span id="chart2time"></span>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    @endif

    @can('dashboard chart 3 access')
        <div class="card rounded-xxl">
            <div class="card-header">
                Activity Hit API
            </div>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-lg-6 mb-3 text-lg-start text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button id="btnDay_chart3" type="button" data-code="d" class="btn-type-date-chart3 btn btn-sm py-0 px-3 rounded-xl-start btn-primary">D</button>
                            <button id="btnMonth_chart3" type="button" data-code="M" class="btn-type-date-chart3 btn btn-sm py-0 px-3 btn-outline-primary">M</button>
                            <button id="btnYear_chart3" type="button" data-code="y" class="btn-type-date-chart3 btn btn-sm py-0 px-3 rounded-xl-end btn-outline-primary">Y</button>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3 text-lg-end text-center">
                        <button type="button" id="btnDatePrev_chart3" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="btnDateLabel_chart3" class="btn btn-sm py-0 px-2 rounded-xl btn-primary mx-2 px-2"></button>
                        <button type="button" id="btnDateNext_chart3" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div id="chart3"></div>
                    </div>
                </div>

                @if (auth()->user()->is_admin)
                    <div class="accordion rounded-xxl" id="chart3Setting">
                        <div class="accordion-item rounded-xxl">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed rounded-xxl" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#chart3SettingBody" aria-expanded="false"
                                    aria-controls="chart3SettingBody">
                                    <i class="fas fa-cogs me-1"></i> Settings
                                </button>
                            </h2>
                            <div id="chart3SettingBody" class="accordion-collapse collapse"
                                aria-labelledby="headingOne" data-bs-parent="#chart3Setting">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <select name="chart3FilterMerchant" id="chart3FilterMerchant" class="select2" style="width: 100%;">
                                                <option></option>
                                                @foreach ($merchantSelect2 as $merchant)
                                                    <option value="{{ $merchant->Id }}">{{ $merchant->Nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer small">
                Updated At: <span id="chart3time"></span>
            </div>
        </div>
    @endcan
@endsection

@section('modal')

@endsection

@section('js')
    <script>
        let chart1 = null,
            chart2 = null,
            chart3 = null;

        let chart1config = {
            type: {
                d: 'day',
                m: 'month',
                y: 'year',
                curr: 'd'
            },
            date: {
                d: {
                    prev: moment().subtract(1, 'd').format('DD MMM YYYY'),
                    curr: moment().format('DD MMM YYYY'),
                    next: moment().add(1, 'd').format('DD MMM YYYY'),
                },
                M: {
                    prev: moment().subtract(1, 'M').format('MMM YYYY'),
                    curr: moment().format('MMM YYYY'),
                    next: moment().add(1, 'M').format('MMM YYYY'),
                },
                y: {
                    prev: moment().subtract(1, 'y').format('YYYY'),
                    curr: moment().format('YYYY'),
                    next: moment().add(1, 'y').format('YYYY'),
                }
            },
            format: {
                d: 'DD MMM YYYY',
                M: 'MMM YYYY',
                y: 'YYYY'
            }
        };

        let chart2config = {
            type: {
                d: 'day',
                m: 'month',
                y: 'year',
                curr: 'd'
            },
            date: {
                d: {
                    prev: moment().subtract(1, 'd').format('DD MMM YYYY'),
                    curr: moment().format('DD MMM YYYY'),
                    next: moment().add(1, 'd').format('DD MMM YYYY'),
                },
                M: {
                    prev: moment().subtract(1, 'M').format('MMM YYYY'),
                    curr: moment().format('MMM YYYY'),
                    next: moment().add(1, 'M').format('MMM YYYY'),
                },
                y: {
                    prev: moment().subtract(1, 'y').format('YYYY'),
                    curr: moment().format('YYYY'),
                    next: moment().add(1, 'y').format('YYYY'),
                }
            },
            format: {
                d: 'DD MMM YYYY',
                M: 'MMM YYYY',
                y: 'YYYY'
            }
        };

        let chart3config = {
            type: {
                d: 'day',
                m: 'month',
                y: 'year',
                curr: 'd'
            },
            date: {
                d: {
                    prev: moment().subtract(1, 'd').format('DD MMM YYYY'),
                    curr: moment().format('DD MMM YYYY'),
                    next: moment().add(1, 'd').format('DD MMM YYYY'),
                },
                M: {
                    prev: moment().subtract(1, 'M').format('MMM YYYY'),
                    curr: moment().format('MMM YYYY'),
                    next: moment().add(1, 'M').format('MMM YYYY'),
                },
                y: {
                    prev: moment().subtract(1, 'y').format('YYYY'),
                    curr: moment().format('YYYY'),
                    next: moment().add(1, 'y').format('YYYY'),
                }
            },
            format: {
                d: 'DD MMM YYYY',
                M: 'MMM YYYY',
                y: 'YYYY'
            }
        };

        function loadEventChart1() {
            $('.btn-type-date-chart1').on('click', function () {
                $('.btn-type-date-chart1').addClass('btn-outline-primary');
                $('.btn-type-date-chart1').removeClass('btn-primary');

                $(this).removeClass('btn-outline-primary');
                $(this).addClass('btn-primary');

                chart1config.type.curr = $(this).data('code');
                loadConfigChart1();
                loadChart1(true);
            });

            $('#btnDateNext_chart1').on('click', function () {
                chart1config.date[chart1config.type.curr].prev = chart1config.date[chart1config.type.curr].curr;
                chart1config.date[chart1config.type.curr].curr = chart1config.date[chart1config.type.curr].next;
                chart1config.date[chart1config.type.curr].next = moment(chart1config.date[chart1config.type.curr].next, chart1config.format[chart1config.type.curr])
                                                        .add(1, chart1config.type.curr)
                                                        .format(chart1config.format[chart1config.type.curr]);
                loadConfigChart1();
                loadChart1(true);
            });

            $('#btnDatePrev_chart1').on('click', function () {
                chart1config.date[chart1config.type.curr].next = chart1config.date[chart1config.type.curr].curr;
                chart1config.date[chart1config.type.curr].curr = chart1config.date[chart1config.type.curr].prev;
                chart1config.date[chart1config.type.curr].prev = moment(chart1config.date[chart1config.type.curr].prev, chart1config.format[chart1config.type.curr])
                                                        .subtract(1, chart1config.type.curr)
                                                        .format(chart1config.format[chart1config.type.curr]);
                loadConfigChart1();
                loadChart1(true);
            });

            $('#btnDateLabel_chart1').on('click', function () {
                chart1config.date[chart1config.type.curr].next = moment().add(1, chart1config.type.curr).format(chart1config.format[chart1config.type.curr]);
                chart1config.date[chart1config.type.curr].curr = moment().format(chart1config.format[chart1config.type.curr]);
                chart1config.date[chart1config.type.curr].prev = moment().subtract(1, chart1config.type.curr).format(chart1config.format[chart1config.type.curr]);
                loadConfigChart1();
                loadChart1(true);
            });

            $('#chart1FilterMerchant').on('change', function (e) {
                loadConfigChart1();
                loadChart1(true);
            });
        }

        function loadEventChart2() {
            $('.btn-type-date-chart2').on('click', function () {
                $('.btn-type-date-chart2').addClass('btn-outline-primary');
                $('.btn-type-date-chart2').removeClass('btn-primary');

                $(this).removeClass('btn-outline-primary');
                $(this).addClass('btn-primary');

                chart2config.type.curr = $(this).data('code');
                loadConfigChart2();
                loadChart2(true);
            });

            $('#btnDateNext_chart2').on('click', function () {
                chart2config.date[chart2config.type.curr].prev = chart2config.date[chart2config.type.curr].curr;
                chart2config.date[chart2config.type.curr].curr = chart2config.date[chart2config.type.curr].next;
                chart2config.date[chart2config.type.curr].next = moment(chart2config.date[chart2config.type.curr].next, chart2config.format[chart2config.type.curr])
                                                        .add(1, chart2config.type.curr)
                                                        .format(chart2config.format[chart2config.type.curr]);
                loadConfigChart2();
                loadChart2(true);
            });

            $('#btnDatePrev_chart2').on('click', function () {
                chart2config.date[chart2config.type.curr].next = chart2config.date[chart2config.type.curr].curr;
                chart2config.date[chart2config.type.curr].curr = chart2config.date[chart2config.type.curr].prev;
                chart2config.date[chart2config.type.curr].prev = moment(chart2config.date[chart2config.type.curr].prev, chart2config.format[chart2config.type.curr])
                                                        .subtract(1, chart2config.type.curr)
                                                        .format(chart2config.format[chart2config.type.curr]);
                loadConfigChart2();
                loadChart2(true);
            });

            $('#btnDateLabel_chart2').on('click', function () {
                chart2config.date[chart2config.type.curr].next = moment().add(1, chart2config.type.curr).format(chart2config.format[chart2config.type.curr]);
                chart2config.date[chart2config.type.curr].curr = moment().format(chart2config.format[chart2config.type.curr]);
                chart2config.date[chart2config.type.curr].prev = moment().subtract(1, chart2config.type.curr).format(chart2config.format[chart2config.type.curr]);
                loadConfigChart2();
                loadChart2(true);
            });

            $('#chart2FilterMerchant').on('change', function (e) {
                loadConfigChart2();
                loadChart2(true);
            });

            $('#chart2OrderField1').on('change', function (e) {
                let opt = $('#chart2OrderField2 option');
                opt.each((index, el) => {
                    $(el).prop('disabled', false);
                });
                $("#chart2OrderField2 option[value=" + $(this).val() + "]").prop('disabled', true);

                loadConfigChart2();
                loadChart2(true);
            });

            $('#chart2OrderType1').on('change', function (e) {
                loadConfigChart2();
                loadChart2(true);
            });

            $('#chart2OrderField2').on('change', function (e) {
                loadConfigChart2();
                loadChart2(true);
            });

            $('#chart2OrderType2').on('change', function (e) {
                loadConfigChart2();
                loadChart2(true);
            });
        }

        function loadEventChart3() {
            $('.btn-type-date-chart3').on('click', function () {
                $('.btn-type-date-chart3').addClass('btn-outline-primary');
                $('.btn-type-date-chart3').removeClass('btn-primary');

                $(this).removeClass('btn-outline-primary');
                $(this).addClass('btn-primary');

                chart3config.type.curr = $(this).data('code');
                loadConfigChart3();
                loadChart3();
            });

            $('#btnDateNext_chart3').on('click', function () {
                chart3config.date[chart3config.type.curr].prev = chart3config.date[chart3config.type.curr].curr;
                chart3config.date[chart3config.type.curr].curr = chart3config.date[chart3config.type.curr].next;
                chart3config.date[chart3config.type.curr].next = moment(chart3config.date[chart3config.type.curr].next, chart3config.format[chart3config.type.curr])
                                                        .add(1, chart3config.type.curr)
                                                        .format(chart3config.format[chart3config.type.curr]);
                loadConfigChart3();
                loadChart3();
            });

            $('#btnDatePrev_chart3').on('click', function () {
                chart3config.date[chart3config.type.curr].next = chart3config.date[chart3config.type.curr].curr;
                chart3config.date[chart3config.type.curr].curr = chart3config.date[chart3config.type.curr].prev;
                chart3config.date[chart3config.type.curr].prev = moment(chart3config.date[chart3config.type.curr].prev, chart3config.format[chart3config.type.curr])
                                                        .subtract(1, chart3config.type.curr)
                                                        .format(chart3config.format[chart3config.type.curr]);
                loadConfigChart3();
                loadChart3();
            });

            $('#btnDateLabel_chart3').on('click', function () {
                chart3config.date[chart3config.type.curr].next = moment().add(1, chart3config.type.curr).format(chart3config.format[chart3config.type.curr]);
                chart3config.date[chart3config.type.curr].curr = moment().format(chart3config.format[chart3config.type.curr]);
                chart3config.date[chart3config.type.curr].prev = moment().subtract(1, chart3config.type.curr).format(chart3config.format[chart3config.type.curr]);
                loadConfigChart3();
                loadChart3();
            });

            $('#chart3FilterMerchant').on('change', function (e) {
                loadConfigChart3();
                loadChart3(true);
            });
        }

        function loadConfigChart1() {
            $('#btnDateLabel_chart1').html(chart1config.date[chart1config.type.curr].curr);
            if ( chart1config.date[chart1config.type.curr].curr === moment().format(chart1config.format[chart1config.type.curr]) ) {
                $('#btnDateLabel_chart1').addClass('btn-primary');
                $('#btnDateLabel_chart1').removeClass('btn-outline-primary');
            } else {
                $('#btnDateLabel_chart1').removeClass('btn-primary');
                $('#btnDateLabel_chart1').addClass('btn-outline-primary');
            }
            $('#btnDateNext_chart1').prop('disabled',
                chart1config.date[chart1config.type.curr].next === moment().add(1, chart1config.type.curr).format(chart1config.format[chart1config.type.curr])
            );
        }

        function loadConfigChart2() {
            $('#btnDateLabel_chart2').html(chart2config.date[chart2config.type.curr].curr);
            if ( chart2config.date[chart2config.type.curr].curr === moment().format(chart2config.format[chart2config.type.curr]) ) {
                $('#btnDateLabel_chart2').addClass('btn-primary');
                $('#btnDateLabel_chart2').removeClass('btn-outline-primary');
            } else {
                $('#btnDateLabel_chart2').removeClass('btn-primary');
                $('#btnDateLabel_chart2').addClass('btn-outline-primary');
            }
            $('#btnDateNext_chart2').prop('disabled',
                chart2config.date[chart2config.type.curr].next === moment().add(1, chart2config.type.curr).format(chart2config.format[chart2config.type.curr])
            );
        }

        function loadConfigChart3() {
            $('#btnDateLabel_chart3').html(chart3config.date[chart3config.type.curr].curr);
            if ( chart3config.date[chart3config.type.curr].curr === moment().format(chart3config.format[chart3config.type.curr]) ) {
                $('#btnDateLabel_chart3').addClass('btn-primary');
                $('#btnDateLabel_chart3').removeClass('btn-outline-primary');
            } else {
                $('#btnDateLabel_chart3').removeClass('btn-primary');
                $('#btnDateLabel_chart3').addClass('btn-outline-primary');
            }
            $('#btnDateNext_chart3').prop('disabled',
                chart3config.date[chart3config.type.curr].next === moment().add(1, chart3config.type.curr).format(chart3config.format[chart3config.type.curr])
            );
        }

        function loadChart1(isReload = false) {
            if (isReload) {
                chart1.option('dataSource', `{{ route('dashboard.chart1') }}${requestParamBuilder(1)}`);
                chart1.refresh();
            } else {
                chart1 = $('#chart1').dxChart({
                    palette: 'Cyan',
                    dataSource: `{{ route('dashboard.chart1') }}${requestParamBuilder(1)}`,
                    commonSeriesSettings: {
                        argumentField: 'date',
                        type: 'line',
                    },
                    margin: {
                        bottom: 10,
                    },
                    valueAxis: {
                        title: {
                            text: 'Points'
                        }
                    },
                    argumentAxis: {
                        title: {
                            text: 'Days'
                        },
                        valueMarginsEnabled: false,
                        discreteAxisDivisionMode: 'crossLabels',
                        grid: {
                            visible: true,
                        },
                    },
                    series: [{
                            valueField: 'inLogs',
                            name: 'In'
                        },
                        {
                            valueField: 'outLogs',
                            name: 'Out'
                        }
                    ],
                    tooltip: {
                        enabled: true,
                    },
                    size: {
                        height: 266,
                    },
                    legend: {
                        visible: true,
                        verticalAlignment: 'bottom',
                        horizontalAlignment: 'center',
                        hoverMode: 'excludePoints',
                    },
                    loadingIndicator: {
                        enabled: true,
                    },
                })
                .dxChart('instance')
                .on('legendClick', (e) => {
                    var series = e.target;
                    if (series.isVisible()) {
                        series.hide();
                    } else {
                        series.show();
                    }
                });
            }

            $.get(`{{ route('dashboard.chart1.stat') }}${requestParamBuilder(1)}`, function (response) {
                $('#chart1Success').text(response.success);
                $('#chart1SuccessStat').text(response.successPercent);
                $('#chart1Failed').text(response.failed);
                $('#chart1FailedStat').text(response.failedPercent);
            });

            $.get(`{{ route('dashboard.chartTime') }}${requestParamBuilder(1)}&ch=chart1`, function (response) {
                $('#chart1time').text(
                    moment(response).format('YYYY-MM-DD HH:mm:ss')
                );
            });

            $("#chart1FilterMerchant").select2({
                placeholder: "Select a merchant"
            });
        }

        function loadChart2(isReload = false) {
            if (isReload) {
                chart2.option('dataSource', `{{ route('dashboard.chart2') }}${requestParamBuilder(2)}`);
                chart2.refresh();
            }
            else {
                chart2 = $('#chart2').dxChart({
                    dataSource: `{{ route('dashboard.chart2') }}${requestParamBuilder(2)}`,
                    size: {
                        height: 340
                    },
                    series: [{
                        argumentField: 'Nama',
                        valueField: 'Point',
                        name: 'Point',
                        type: 'bar',
                        color: '#ffaa66',
                    },
                    {
                        argumentField: 'Nama',
                        valueField: 'Hit',
                        name: 'Hit',
                        type: 'bar',
                        color: '#7732a8',
                    }],
                    tooltip: {
                        visible: true,
                    },
                    customizeLabel() {
                        return {visible: true};
                    },
                    legend: {
                        visible: true,
                    },
                    valueAxis: {
                        title: {
                            text: 'Value'
                        }
                    },
                    argumentAxis: {
                        title: {
                            text: 'Member Name'
                        }
                    },
                    rotated: true,
                    loadingIndicator: {
                        enabled: true,
                    },
                }).dxChart('instance')
                .on('legendClick', (e) => {
                    var series = e.target;
                    if (series.isVisible()) {
                        series.hide();
                    } else {
                        series.show();
                    }
                });

                $("#chart2FilterMerchant").select2({
                    placeholder: "Select a merchant"
                });

                $("#chart2OrderField2 option[value=" + $('#chart2OrderField1').val() + "]").prop('disabled', true);
            }

            $.get(`{{ route('dashboard.chartTime') }}${requestParamBuilder(2)}&ch=chart2`, function (response) {
                $('#chart2time').text(
                    moment(response).format('YYYY-MM-DD HH:mm:ss')
                );
            });
        }

        function loadChart3(isReload = false) {
            if (isReload) {
                chart3.option('dataSource', `{{ route('dashboard.chart3') }}${requestParamBuilder(3)}`);
                chart3.refresh();
            }
            else {
                chart3 = $('#chart3').dxChart({
                    dataSource: `{{ route('dashboard.chart3') }}${requestParamBuilder(3)}`,
                    size: {
                        height: 250
                    },
                    valueAxis: [
                        {
                            enabled: true,
                            position: 'left',
                        },
                        {
                            enabled: true,
                            position: 'right',
                        }
                    ],
                    series: [
                        {
                            argumentField: 'date',
                            valueField: 'success',
                            name: 'Success',
                            type: 'bar',
                            color: 'cyan',
                        },
                        {
                            argumentField: 'date',
                            valueField: 'failed',
                            name: 'Failed',
                            type: 'bar',
                            color: 'violet',
                        }
                    ],
                    legend: {
                        visible: true,
                    },
                    valueAxis: {
                        title: {
                            text: 'Value'
                        }
                    },
                    argumentAxis: {
                        title: {
                            text: 'Days'
                        }
                    },
                    loadingIndicator: {
                        enabled: true,
                    },
                    customizeLabel(barInfo) {
                        if (barInfo.value > 0) {
                            return {
                                visible: true,
                            };
                        }
                    }
                }).dxChart('instance');

                $("#chart3FilterMerchant").select2({
                    placeholder: "Select a merchant"
                });
            }

            $.get(`{{ route('dashboard.chartTime') }}${requestParamBuilder(3)}&ch=chart3`, function (response) {
                $('#chart3time').text(
                    moment(response).format('YYYY-MM-DD HH:mm:ss')
                );
            });
        }

        function requestParamBuilder(chartNum) {
            let config = null;
            let extraParams = "";
            if (chartNum == 1) {
                config = chart1config;
                extraParams += `&mrc=${$('#chart1FilterMerchant').val()}`;
            }
            else if (chartNum == 2) {
                config = chart2config;
                extraParams += `&mrc=${$('#chart2FilterMerchant').val()}&of1=${$('#chart2OrderField1').val()}&ot1=${$('#chart2OrderType1').val()}`;
                if ($('#chart2OrderField2').val() != "") {
                    extraParams += `&of2=${$('#chart2OrderField2').val()}&ot2=${$('#chart2OrderType2').val()}`;
                }
            }
            else if (chartNum == 3) {
                config = chart3config;
                extraParams += `&mrc=${$('#chart3FilterMerchant').val()}`;
            }

            let params = [
                `t=${config.type.curr}`,
                `d=${moment(config.date[config.type.curr].curr, config.format[config.type.curr]).format('YYYY-MM-DD')}`
            ];

            return `?${params.join('&') + extraParams}`;
        }

        $(document).ready(() => {
            loadConfigChart1();
            loadConfigChart2();
            loadConfigChart3();
            loadChart1();
            loadChart2();
            loadChart3();
            loadEventChart1();
            loadEventChart2();
            loadEventChart3();

            @if (request()->route()->getName())

                $('#formClearCache').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: {},
                        success: (res) => {
                            Toast.fire({
                                icon: 'success',
                                text: 'Cache has been cleared'
                            });
                            loadChart1(true);
                            loadChart2(true);
                            loadChart3(true);
                        },
                        error: (error) => {

                        }
                    });
                });
            @endif
        });
    </script>
@endsection
