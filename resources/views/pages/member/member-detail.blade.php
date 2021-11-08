@extends('layouts.main')
@section('meta')

@endsection

@section('title', 'Member Details')

@section('css')

@endsection
@section('content')
    <div class="card rounded-xxl">
        <div class="card-body">
            <form id="memberForm" action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                Code
                            </div>
                            <div class="col-xl-10 col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="text" name="code" id="code" class="form-control rounded-xl-start border-end-0">
                                    <span class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                Name
                            </div>
                            <div class="col-xl-10 col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="text" name="name" id="name" class="form-control rounded-xl-start border-end-0">
                                    <span class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                Note
                            </div>
                            <div class="col-xl-10 col-lg-9">
                                <textarea name="note" id="note" class="form-control rounded-xl" cols="30" rows="3" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row mt-5">
                <div class="col-md-3">
                    <select name="type" id="type" class="form-select rounded-xl">
                        <option value="day">Daily</option>
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                        <option value="year">Monthly</option>
                    </select>
                </div>
            </div>

            {{-- Chart Area Member Point --}}
            <div class="row mt-0 mb-3">
                <div class="col-12">
                    <div id="chart"></div>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6 text-center mb-3 order-2 order-sm-1">
                    <div class="d-grid gap-2">
                        <button class="btn btn-secondary rounded-xxl px-5">Close</button>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6 text-center mb-3 order-1 order-sm-2">
                    <div class="d-grid gap-2">
                        <button type="submit" form="memberForm" class="btn btn-primary rounded-xxl px-5">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('js')
    <script>
        const weeks = [
            {
                week: 'Sunday',
                c200: Math.floor(Math.random() * 100),
                c400: Math.floor(Math.random() * 100),
                c500: Math.floor(Math.random() * 100),
            },
            {
                week: 'Monday',
                c200: Math.floor(Math.random() * 100),
                c400: Math.floor(Math.random() * 100),
                c500: Math.floor(Math.random() * 100),
            },
            {
                week: 'Tuesday',
                c200: Math.floor(Math.random() * 100),
                c400: Math.floor(Math.random() * 100),
                c500: Math.floor(Math.random() * 100),
            },
            {
                week: 'Wednesday',
                c200: Math.floor(Math.random() * 100),
                c400: Math.floor(Math.random() * 100),
                c500: Math.floor(Math.random() * 100),
            },
            {
                week: 'Thursday',
                c200: Math.floor(Math.random() * 100),
                c400: Math.floor(Math.random() * 100),
                c500: Math.floor(Math.random() * 100),
            },
            {
                week: 'Friday',
                c200: Math.floor(Math.random() * 100),
                c400: Math.floor(Math.random() * 100),
                c500: Math.floor(Math.random() * 100),
            },
            {
                week: 'Saturday',
                c200: Math.floor(Math.random() * 100),
                c400: Math.floor(Math.random() * 100),
                c500: Math.floor(Math.random() * 100),
            }
        ];
        const chart = $('#chart').dxChart({
            palette: 'Blue',
            dataSource: weeks,
            commonAxisSettings: {
                grid: {
                    visible: true,
                },
            },
            commonPaneSettings: {
                border: {
                    color: '#f00',
                    dashStyle: 'dot',
                },
            },
            commonSeriesSettings: {
                type: 'area',
                argumentField: 'week',
                point: {
                    visible: true,
                    symbol: 'circle',
                    hoverMode: 'onlyPoint',
                },
                label: {
                    visible: true,
                },
            },
            series: [
                {
                    valueField: 'c200',
                    name: 'Success',
                    color: '#4db2c4',
                }
            ],
            margin: {
                top: 20,
                bottom: 20,
            },
            argumentAxis: {
                valueMarginsEnabled: false,
            },
            export: {
                enabled: false,
            },
            legend: {
                visible: false,
            },
        }).dxChart('instance');
    </script>
@endsection
