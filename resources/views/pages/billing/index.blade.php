@extends('layouts.main')
@section('content')
<div class="col-md-4">
    <div class="card mb-4">
        <div class="card-body">
            {{-- Data Billing --}}
            <div class="row mt-3 rounded-xl ">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-md  table-hover"  style="width:100%">
                                <tr class="bg-info" style="color:white; weight: 5px;">
                                    <th></th>
                                    <th>Company Name</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td> <a href="{{ url('/billing-company') }}">Some Company Name</a></td>
                                    <td>5 <i class="fas fa-angle-right ml-3"></i></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td> <a href="{{ url('/billing-company') }}">Some Company Name</a></td>
                                    <td>5 <i class="fas fa-angle-right ml-3"></i></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td> <a href="{{ url('/billing-company') }}">Some Company Name</a></td>
                                    <td>5 <i class="fas fa-angle-right ml-3"></i></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td> <a href="{{ url('/billing-company') }}">Some Company Name</a></td>
                                    <td>5 <i class="fas fa-angle-right ml-3"></i></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td> <a href="{{ url('/billing-company') }}">Some Company Name</a></td>
                                    <td>5 <i class="fas fa-angle-right ml-3"></i></td>
                                </tr>
                                
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-8">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <b>Some Company Name</b>
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="" id="">
                        <option value="">2020</option>
                        <option value="">2021</option>
                        <option value="">2022</option>
                        <option value="">2023</option>
                    </select>
                </div>
            </div>
            {{-- Data All Billing Per company --}}
            <div class="row  mt-2 ">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-md  table-hover">
                            <tr class="bg-light">
                                <th>Month</th>
                                <th>Clicks</th>
                                <th>Bill</th>
                                <th>Date Paid</th>
                                <th></th>
                            </tr>
                            <form action="" method="">
                                <tr>
                                    <td>January</td>
                                    <td>1256</td>
                                    <td>Rp 12.345.678,-</td>
                                    <td>20 February 2020</td>
                                    <td><button class="btn btn-md bg-info rounded-xl" style="color:white" type="submit">Save</button></td>
                                </tr>
                            </form>
                            <form action="" method="">
                                <tr>
                                    <td>January</td>
                                    <td>1256</td>
                                    <td>Rp 12.345.678,-</td>
                                    <td>20 February 2020</td>
                                    <td><button class="btn btn-md bg-info rounded-xl" style="color:white" type="submit">Save</button></td>
                                </tr>
                            </form>
                            <form action="" method="">
                                <tr>
                                    <td>January</td>
                                    <td>1256</td>
                                    <td>Rp 12.345.678,-</td>
                                    <td>20 February 2020</td>
                                    <td><button class="btn btn-md bg-info rounded-xl" style="color:white" type="submit">Save</button></td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="row justify-content-center ms-2 me-2">
                <div class="col">
                    <form acttion="" class="" methods="">
                        @csrf
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6">
                                <label>Nama Perusahaan</label>
                            </div>
                            <div class="col-md-6 rounded-xl">
                                <input type="test" class=" form-control" id="inputEmail3">
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6">
                                <label>Alamat Perusahaan</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class=" form-control" id="inputEmail3">
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6">
                                <label>Peron in Charge (PIC)</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class=" form-control " id="inputEmail3">
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6">
                                <label>PIC Phone</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class=" form-control " id="inputEmail3">
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class=" form-control " id="inputEmail3">
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6">
                                <label>Kebutuhan</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class=" form-control " id="inputEmail3">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-md btn-info rounded-xl">Save</button>
                        </div>
                    </form>
                </div>
            </div>
      </div>

    </div>
  </div>
</div>

@endsection
