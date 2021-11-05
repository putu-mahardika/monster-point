@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Event')

@section('content')

<div class="col-md-12">
    <div class="card mb-4 rounded-xxl">
        <div class="card-body">

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-md bg-info rounded-xl me-5" href="" style="color: white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                   New Event <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <i class="fas fa-sort-amount-down"></i>
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="function" id="function">
                        <option value=""> Function </option>
                        <option value="">a</option>
                        <option value="">a</option>
                    </select>
                </div>
            </div>

            {{-- Data All Company --}}
            <div class="row mt-3 rounded-xl ">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-md table-hover"  style="width:100%">
                            <tr class="bg-info" style="color:white; weight: 5px;">
                                <th>Code</th>
                                <th>Event</th>
                                <th>Formula</th>
                                <th>Daily/Once</th>
                                <th>Delay Lock</th>
                                <th>Notes</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>PB_POINT01</td>
                                <td>Event_Buy_01</td>
                                <td>formula.buy.point.something.somecodeoverhere.</td>
                                <td>Daily</td>
                                <td>Yes</td>
                                <td>Note for the event and formula</td>
                                <td><a href="{{ url('/event-detail') }}"><i class="fas fa-ellipsis-v"></i></a></td>
                            </tr>
                            <tr>
                                <td>PB_POINT01</td>
                                <td>Event_Buy_01</td>
                                <td>formula.buy.point.something.somecodeoverhere.</td>
                                <td>Daily</td>
                                <td>Yes</td>
                                <td>Note for the event and formula</td>
                                <td><i class="fas fa-ellipsis-v"></i></td>
                            </tr>
                            <tr>
                                <td>PB_POINT01</td>
                                <td>Event_Buy_01</td>
                                <td>formula.buy.point.something.somecodeoverhere.</td>
                                <td>Daily</td>
                                <td>Yes</td>
                                <td>Note for the event and formula</td>
                                <td><i class="fas fa-ellipsis-v"></i></td>
                            </tr>
                            <tr>
                                <td>PB_POINT01</td>
                                <td>Event_Buy_01</td>
                                <td>formula.buy.point.something.somecodeoverhere.</td>
                                <td>Daily</td>
                                <td>Yes</td>
                                <td>Note for the event and formula</td>
                                <td><i class="fas fa-ellipsis-v"></i></td>
                            </tr>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
