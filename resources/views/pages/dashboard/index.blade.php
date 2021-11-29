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
                                            <span class="fs-4 d-block">
                                                1.5K
                                            </span>
                                            <span style="font-size: .7rem;" class="text-success d-block">
                                                <i class="fas fa-arrow-up"></i> 4.5%
                                            </span>
                                        </div>
                                        <div class="col">
                                            <span class="small text-muted d-block">
                                                Failed
                                            </span>
                                            <span class="fs-4 d-block">
                                                1.5K
                                            </span>
                                            <span style="font-size: .7rem;" class="text-danger d-block">
                                                <i class="fas fa-arrow-down"></i> 4.5%
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
                        </div>
                    </div>
                </div>
            @endcan
            @can('dashboard chart 2 access')
                <div class="@cannot('dashboard chart 1 access') col @endcannot @can('dashboard chart 1 access') col-md-6 @endcan mb-3">
                    <div class="card rounded-xxl">
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
                            <div class="row">
                                <div class="col">
                                    <div id="chart2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    @endif

    @can('dashboard chart 3 access')
        <div class="card rounded-xxl">
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
                <div class="row">
                    <div class="col">
                        <div id="chart3"></div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('modal')

@endsection

@section('js')
    <script>
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
            });

            $('#btnDateNext_chart1').on('click', function () {
                chart1config.date[chart1config.type.curr].prev = chart1config.date[chart1config.type.curr].curr;
                chart1config.date[chart1config.type.curr].curr = chart1config.date[chart1config.type.curr].next;
                chart1config.date[chart1config.type.curr].next = moment(chart1config.date[chart1config.type.curr].next, chart1config.format[chart1config.type.curr])
                                                        .add(1, chart1config.type.curr)
                                                        .format(chart1config.format[chart1config.type.curr]);
                loadConfigChart1();
            });

            $('#btnDatePrev_chart1').on('click', function () {
                chart1config.date[chart1config.type.curr].next = chart1config.date[chart1config.type.curr].curr;
                chart1config.date[chart1config.type.curr].curr = chart1config.date[chart1config.type.curr].prev;
                chart1config.date[chart1config.type.curr].prev = moment(chart1config.date[chart1config.type.curr].prev, chart1config.format[chart1config.type.curr])
                                                        .subtract(1, chart1config.type.curr)
                                                        .format(chart1config.format[chart1config.type.curr]);
                loadConfigChart1();
            });

            $('#btnDateLabel_chart1').on('click', function () {
                chart1config.date[chart1config.type.curr].next = moment().add(1, chart1config.type.curr).format(chart1config.format[chart1config.type.curr]);
                chart1config.date[chart1config.type.curr].curr = moment().format(chart1config.format[chart1config.type.curr]);
                chart1config.date[chart1config.type.curr].prev = moment().subtract(1, chart1config.type.curr).format(chart1config.format[chart1config.type.curr]);
                loadConfigChart1();
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
            });

            $('#btnDateNext_chart2').on('click', function () {
                chart2config.date[chart2config.type.curr].prev = chart2config.date[chart2config.type.curr].curr;
                chart2config.date[chart2config.type.curr].curr = chart2config.date[chart2config.type.curr].next;
                chart2config.date[chart2config.type.curr].next = moment(chart2config.date[chart2config.type.curr].next, chart2config.format[chart2config.type.curr])
                                                        .add(1, chart2config.type.curr)
                                                        .format(chart2config.format[chart2config.type.curr]);
                loadConfigChart2();
            });

            $('#btnDatePrev_chart2').on('click', function () {
                chart2config.date[chart2config.type.curr].next = chart2config.date[chart2config.type.curr].curr;
                chart2config.date[chart2config.type.curr].curr = chart2config.date[chart2config.type.curr].prev;
                chart2config.date[chart2config.type.curr].prev = moment(chart2config.date[chart2config.type.curr].prev, chart2config.format[chart2config.type.curr])
                                                        .subtract(1, chart2config.type.curr)
                                                        .format(chart2config.format[chart2config.type.curr]);
                loadConfigChart2();
            });

            $('#btnDateLabel_chart2').on('click', function () {
                chart2config.date[chart2config.type.curr].next = moment().add(1, chart2config.type.curr).format(chart2config.format[chart2config.type.curr]);
                chart2config.date[chart2config.type.curr].curr = moment().format(chart2config.format[chart2config.type.curr]);
                chart2config.date[chart2config.type.curr].prev = moment().subtract(1, chart2config.type.curr).format(chart2config.format[chart2config.type.curr]);
                loadConfigChart2();
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
            });

            $('#btnDateNext_chart3').on('click', function () {
                chart3config.date[chart3config.type.curr].prev = chart3config.date[chart3config.type.curr].curr;
                chart3config.date[chart3config.type.curr].curr = chart3config.date[chart3config.type.curr].next;
                chart3config.date[chart3config.type.curr].next = moment(chart3config.date[chart3config.type.curr].next, chart3config.format[chart3config.type.curr])
                                                        .add(1, chart3config.type.curr)
                                                        .format(chart3config.format[chart3config.type.curr]);
                loadConfigChart3();
            });

            $('#btnDatePrev_chart3').on('click', function () {
                chart3config.date[chart3config.type.curr].next = chart3config.date[chart3config.type.curr].curr;
                chart3config.date[chart3config.type.curr].curr = chart3config.date[chart3config.type.curr].prev;
                chart3config.date[chart3config.type.curr].prev = moment(chart3config.date[chart3config.type.curr].prev, chart3config.format[chart3config.type.curr])
                                                        .subtract(1, chart3config.type.curr)
                                                        .format(chart3config.format[chart3config.type.curr]);
                loadConfigChart3();
            });

            $('#btnDateLabel_chart3').on('click', function () {
                chart3config.date[chart3config.type.curr].next = moment().add(1, chart3config.type.curr).format(chart3config.format[chart3config.type.curr]);
                chart3config.date[chart3config.type.curr].curr = moment().format(chart3config.format[chart3config.type.curr]);
                chart3config.date[chart3config.type.curr].prev = moment().subtract(1, chart3config.type.curr).format(chart3config.format[chart3config.type.curr]);
                loadConfigChart3();
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

        function requestParamBuilder(chartNum) {
            let config = null;
            if (chartNum == 1) {
                config = chart1config;
            }
            else if (chartNum == 2) {
                config = chart2config;
            }
            else if (chartNum == 3) {
                config = chart3config;
            }

            let params = [
                `t=${config.type.curr}`,
                `d=${moment(config.date[config.type.curr].curr, config.format[config.type.curr]).format('YYYY-MM-DD')}`
            ];

            return `?${params.join('&')}`;
        }

        $(document).ready(() => {
            loadConfigChart1();
            loadEventChart1();
            loadConfigChart2();
            loadEventChart2();
            loadConfigChart3();
            loadEventChart3();
        });

        const complaintsData = [{
                complaint: 'Sunday',
                count: 780
            },
            {
                complaint: 'Monday',
                count: 120
            },
            {
                complaint: 'Tuesdey',
                count: 52
            },
            {
                complaint: 'Wednesday',
                count: 1123
            },
            {
                complaint: 'Thursday',
                count: 321
            },
            {
                complaint: 'Friday',
                count: 89
            },
            {
                complaint: 'Saturday',
                count: 222
            },
        ];

        const data = complaintsData;
        const totalCount = data.reduce((prevValue, item) => prevValue + item.count, 0);
        let cumulativeCount = 0;
        const dataSource = data.map((item) => {
            cumulativeCount += item.count;
            return {
                complaint: item.complaint,
                count: item.count,
                cumulativePercentage: Math.round((cumulativeCount * 100) / totalCount),
            };
        });

        $('#chart1').dxChart({
            size: {
                height: 250
            },
            palette: 'Harmony Light',
            dataSource: `{{ route('dashboard.chart1') }}${requestParamBuilder(1)}`,
            argumentAxis: {
                label: {
                    overlappingBehavior: 'stagger',
                },
            },
            tooltip: {
                enabled: true,
            },
            // valueAxis: [{
            //         name: 'frequency',
            //         position: 'left',
            //         tickInterval: 300,
            //     },
            //     {
            //         enabled: false,
            //         name: 'percentage',
            //         position: 'right',
            //         showZero: true,
            //         label: {
            //             customizeText(info) {
            //                 // return `${info.valueText}%`;
            //                 return ``;
            //             },
            //         },
            //         tickInterval: 20,
            //         valueMarginsEnabled: false,
            //     }
            // ],
            commonSeriesSettings: {
                argumentField: 'date',
            },
            series: [
                {
                    type: 'line',
                    valueField: 'value',
                    // axis: 'percentage',
                    // name: 'Cumulative percentage',
                    color: '#4db2c4',
                }
            ],
            legend: {
                visible: false,
                verticalAlignment: 'top',
                horizontalAlignment: 'center',
            },
        });

        $(() => {
            $('#chart2').dxChart({
                size: {
                    height: 340
                },
                series: {
                    argumentField: 'day',
                    valueField: 'oranges',
                    name: 'My oranges',
                    type: 'bar',
                    color: '#ffaa66',
                },
                legend: {
                    visible: false,
                },
                rotated: true
            });
        });

        $(() => {
            $('#chart3').dxChart({
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
                series: {
                    argumentField: 'day',
                    valueField: 'oranges',
                    name: 'My oranges',
                    type: 'bar',
                    color: '#ffaa66',
                },
                legend: {
                    visible: false,
                },
                rotated: false
            });
        });

    </script>
@endsection
