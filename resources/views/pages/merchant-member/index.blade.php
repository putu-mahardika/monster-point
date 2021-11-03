@extends('layouts.main')
@section('content')

<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-5">
                    <div class="col">
                        <div class="row">
                           <div class="col-auto">Key <i class="fas fa-info-circle"></i></div>
                           <div class="col-md-8"><input type="text" class="form-control" placeholder="Company Name"></i></div>
                           <div class="col-auto"><i class="fas fa-edit"></i></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto">Starting Point</div>
                            <div class="col-md-8"><input type="text" class="form-control" placeholder="150"></div>
                            <div class="col-auto"><i class="fas fa-edit"></i></div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-md bg-info rounded-xl me-5" href="" style="color: white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Member <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <i class="fas fa-sort-amount-down"></i>
                </div>
                <div class="col-auto">
                    <input type="text" class=" form-control " placeholder="Point">
                </div>
            </div>
            
            {{-- Data All Company --}}
            <div class="row mt-3 rounded-xl ">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-md table-hover"  style="width:100%">
                            <tr class="bg-info" style="color:white; weight: 5px;">
                                
                                <th>Key</th>
                                <th>Name</th>
                                <th>Point</th>
                                <th>Note</th>
                                <th></th>
                            </tr>
                            <form action="" method="" >
                                <tr>
                                    <td>
                                        <div class="col-auto"><input type="text" class="form-control" placeholder="Company Name"></i></div>
                                        <div class="col-auto"><i class="fas fa-edit"></i></div>
                                    </td>
                                    <td>
                                        <div class="col-auto"><input type="text" class="form-control" placeholder="Company Name"></i></div>
                                        <div class="col-auto"><i class="fas fa-edit"></i></div>
                                    </td>
                                    <td>
                                        <div class="col-auto"><input type="text" class="form-control" placeholder="Company Name"></i></div>
                                        <div class="col-auto"><i class="fas fa-edit"></i></div>
                                    </td>
                                    <td>
                                        <div class="col-auto"><input type="text" class="form-control" placeholder="Company Name"></i></div>
                                        <div class="col-auto"><i class="fas fa-edit"></i></div>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-md bg-info rounded-xl" style="color: white">Save</button>
                                    </td>
                                </tr>
                            </form>
                            <tr>
                                <td>AB001</td>
                                <td>Jhon Doe</td>
                                <td>150</td>
                                <td>Any note for the member</td>
                                <td><i class="fas fa-ellipsis-v"></i></td>
                            </tr>

                            <tr>
                                <td>AB001</td>
                                <td>Jhon Doe</td>
                                <td>150</td>
                                <td>Any note for the member</td>
                                <td><i class="fas fa-ellipsis-v"></i></td>
                            </tr>
                            
                            <tr>
                                <td>AB001</td>
                                <td>Jhon Doe</td>
                                <td>150</td>
                                <td>Any note for the member</td>
                                <td><i class="fas fa-ellipsis-v"></i></td>
                            </tr>
                            <tr>
                                <td>AB001</td>
                                <td>Jhon Doe</td>
                                <td>150</td>
                                <td>Any note for the member</td>
                                <td><a href="{{ url('/member-detail')}}"><i class="fas fa-ellipsis-v"></i></a></td>
                            </tr>

                        </tbody>
                    </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
