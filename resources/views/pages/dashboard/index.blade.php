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
                                    <div class="col-lg-6 mb-3">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button id="btnDay" type="button" data-code="d" class="btn-type-date btn btn-sm py-0 px-3 rounded-xl-start btn-primary">D</button>
                                            <button id="btnMonth" type="button" data-code="m" class="btn-type-date btn btn-sm py-0 px-3 btn-outline-primary">M</button>
                                            <button id="btnYear" type="button" data-code="y" class="btn-type-date btn btn-sm py-0 px-3 rounded-xl-end btn-outline-primary">Y</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm py-0 px-2 rounded-xl btn-primary mx-2 px-2">
                                                {{ now()->format('d M Y') }}
                                            </button>
                                            <button type="button" class="btn btn-sm py-0 px-2 rounded-xl btn-primary">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
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
        <div class="row mb-3">
            <div class="col">
                <div class="card rounded-xxl">
                    <div class="card-body">
                        <div class="row justify-content-between mb-3">
                            <div class="col-md-3 col-sm-5">
                                <select class="form-select py-0" id="month" name="month" style="font-size: .8rem;">
                                    <option value="">Click per month</option>
                                    <option value="">January</option>
                                    <option value="">February</option>
                                    <option value="">Maret</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div id="chart3"></div>
                            </div>
                        </div>
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
        let config = {
            type: {
                d: 'day',
                m: 'month',
                y: 'year',
                curr: 'd'
            },
            date: {
                prev: "2021-11-14",
                curr: "2021-11-15",
                next: "2021-11-16",
                now: "2021-11-15"
            },
            format: {
                d: 'dd MM YYYY',
                m: 'MM YYYY',
                y: 'YYYY'
            }
        };

        $('.btn-type-date').on('click', function () {
            $('.btn-type-date').addClass('btn-outline-primary');
            $('.btn-type-date').removeClass('btn-primary');

            $(this).removeClass('btn-outline-primary');
            $(this).addClass('btn-primary');

            config.type.curr = $(this).data('code');
        });

        function reloadChart() {
            //  dsnsjkfjkdsfkls
        }

        console.log(
            config.format[config.type.curr]
        );

        $(document).ready(() => {
            console.log(
                @json(auth()->user())
            );
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
            dataSource,
            argumentAxis: {
                label: {
                    overlappingBehavior: 'stagger',
                },
            },
            tooltip: {
                enabled: true,
            },
            valueAxis: [{
                    name: 'frequency',
                    position: 'left',
                    tickInterval: 300,
                },
                {
                    enabled: false,
                    name: 'percentage',
                    position: 'right',
                    showZero: true,
                    label: {
                        customizeText(info) {
                            // return `${info.valueText}%`;
                            return ``;
                        },
                    },
                    tickInterval: 20,
                    valueMarginsEnabled: false,
                }
            ],
            commonSeriesSettings: {
                argumentField: 'complaint',
            },
            series: [
                // {
                //     type: 'bar',
                //     valueField: 'count',
                //     axis: 'frequency',
                //     name: 'Complaint frequency',
                //     color: '#fac29a',
                // },
                {
                    type: 'line',
                    valueField: 'cumulativePercentage',
                    axis: 'percentage',
                    name: 'Cumulative percentage',
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
                    height: 300
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
