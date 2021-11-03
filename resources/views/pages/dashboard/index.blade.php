@extends('layouts.main')

@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col">
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
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
@endsection

@section('modal')

@endsection

@section('js')
    <script>
        const complaintsData = [
            { complaint: 'Sunday', count: 780 },
            { complaint: 'Monday', count: 120 },
            { complaint: 'Tuesdey', count: 52 },
            { complaint: 'Wednesday', count: 1123 },
            { complaint: 'Thursday', count: 321 },
            { complaint: 'Friday', count: 89 },
            { complaint: 'Saturday', count: 222 },
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

        $('#chart').dxChart({
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
            valueAxis: [
                {
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
    </script>
@endsection
