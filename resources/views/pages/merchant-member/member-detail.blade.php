@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Detail Member')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4 rounded-xxl">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col">
                        <div class="row mb-2">
                            <div class="col-md-2">Code</div>
                            <div class="col-md-8"><input type="text" class="form-control" placeholder="Company Name"></i></div>
                            <div class="col-auto"><i class="fas fa-edit"></i></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-2">Name</div>
                            <div class="col-md-8"><input type="text" class="form-control" placeholder="150"></div>
                            <div class="col-auto"><i class="fas fa-edit"></i></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto">Note</div>
                            <div class="col-md-10"><textarea name="" id="" cols="10" rows="5" class="form-control" ></textarea></div>
                        </div>
                    </div>
                </div>

                {{-- Chart Area Member Point --}}
                <div class="row mt-3 rounded-xl ">
                    <div class="col">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
const dataSource = [{
  country: 'China',
  y014: 233866959,
  y1564: 1170914102,
  y65: 171774113,
}, {
  country: 'India',
  y014: 373419115,
  y1564: 882520945,
  y65: 76063757,
}, {
  country: 'United States',
  y014: 60554755,
  y1564: 213172625,
  y65: 54835293,
}, {
  country: 'Indonesia',
  y014: 65715705,
  y1564: 177014815,
  y65: 18053690,
}, {
  country: 'Brazil',
  y014: 45278034,
  y1564: 144391494,
  y65: 17190842,
}, {
  country: 'Russia',
  y014: 24465156,
  y1564: 96123777,
  y65: 20412243,
}];

const types = ['area', 'stackedarea', 'fullstackedarea'];
$(() => {
  const chart = $('#chart').dxChart({
    palette: 'Harmony Light',
    dataSource,
    commonSeriesSettings: {
      type: types[0],
      argumentField: 'country',
    },
    series: [
      { valueField: 'y1564', name: '15-64 years' },
      { valueField: 'y014', name: '0-14 years' },
      { valueField: 'y65', name: '65 years and older' },
    ],
    margin: {
      bottom: 20,
    },
    title: 'Member Point',
    argumentAxis: {
      valueMarginsEnabled: false,
    },
    export: {
      enabled: true,
    },
    legend: {
      verticalAlignment: 'bottom',
      horizontalAlignment: 'center',
    },
  }).dxChart('instance');

  $('#types').dxSelectBox({
    dataSource: types,
    value: types[0],
    onValueChanged(e) {
      chart.option('commonSeriesSettings.type', e.value);
    },
  });
});
</script>

@endsection
