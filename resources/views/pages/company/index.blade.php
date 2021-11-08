@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Company')
@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card mb-4 rounded-xxl">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-md bg-info rounded-xl" href="" style="color: white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Company <i class="fas fa-plus"></i>
                        </button>

                    </div>
                </div>
                {{-- Data All Company --}}
                <div class="row mt-3 rounded-xl ">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-md table-hover"  style="width:100%">
                                <tr class="bg-info" style="color:white; weight: 5px;">
                                    <th>No.</th>
                                    <th>Company</th>
                                    <th>Bussinness Type</th>
                                    <th>NIB</th>
                                    <th>Member</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>PT Something BIG</td>
                                    <td>Franchise</td>
                                    <td>123456009</td>
                                    <td>5 <i class="fas fa-user me-2"></i> <i class="fas fa-angle-right"></i></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>PT Something BIG</td>
                                    <td>Franchise</td>
                                    <td>123456009</td>
                                    <td>5 <i class="fas fa-user me-2"></i> <i class="fas fa-angle-right"></i></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card mb-4 rounded-xxl">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        PT Something Big <i class="fas fa-edit"></i></a>
                    </div>
                    <div class="col" style="text-align : right;">
                        5  <i class="fas fa-users"></i></a>
                    </div>
                </div>
                {{-- Data All Merchant Per company --}}
                <div class="row  mt-2 ">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover" style="width:100%">
                                    <tr class="bg-light">
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Point</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Jhon Doe</td>
                                        <td>150</td>
                                        <td><i class="fas fa-ellipsis-v"></i></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Jhon Doe</td>
                                        <td>150</td>
                                        <td><i class="fas fa-ellipsis-v"></i></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Jhon Doe</td>
                                        <td>150</td>
                                        <td><i class="fas fa-ellipsis-v"></i></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Jhon Doe</td>
                                        <td>150</td>
                                        <td><i class="fas fa-ellipsis-v"></i></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Jhon Doe</td>
                                        <td>150</td>
                                        <td><i class="fas fa-ellipsis-v"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                <label>Company Name</label>
                            </div>
                            <div class="col-md-6 rounded-xl">
                                <input type="text" class=" form-control" id="company_name">
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
