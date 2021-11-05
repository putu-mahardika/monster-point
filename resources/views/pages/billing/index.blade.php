@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Billing')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card mb-4 rounded-xxl">
            <div class="card-body">
                {{-- Data Billing --}}
                <div class="row mt-3 rounded-xl ">
                    <div class="col">
                       <div id="merchantTable"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card mb-4 rounded-xxl">
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
                       <div id="memberTable"></div>
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
@section('js')
    <script>
        const merchants = [
            {
                ID: 1,
                MerchantName: 'PT. Something Big',
                BussinessType: 'Franchise',
                NIB: '123.123.456.456',
                Member: 5
            },
            {
                ID: 2,
                MerchantName: 'PT. Something Big',
                BussinessType: 'Franchise',
                NIB: '123.123.456.456',
                Member: 5
            },
            {
                ID: 3,
                MerchantName: 'PT. Something Big',
                BussinessType: 'Franchise',
                NIB: '123.123.456.456',
                Member: 5
            },
            {
                ID: 4,
                MerchantName: 'PT. Something Big',
                BussinessType: 'Franchise',
                NIB: '123.123.456.456',
                Member: 5
            }
        ];

        const members = [
            {
                ID: 1,
                MemberName: 'John Doe',
                Point: '150',
                Link: '#'
            },
            {
                ID: 2,
                MemberName: 'John Doe',
                Point: '150',
                Link: '#'
            },
            {
                ID: 3,
                MemberName: 'John Doe',
                Point: '150',
                Link: '#'
            },
            {
                ID: 4,
                MemberName: 'John Doe',
                Point: '150',
                Link: '#'
            },
            {
                ID: 5,
                MemberName: 'John Doe',
                Point: '150',
                Link: '#'
            }
        ];
        $(document).ready(() => {
            $('#addMerchantModal').on('shown.bs.modal', function () {
                $(this).find('#merchant_name').focus();
            });

            $('#addMemberModal').on('shown.bs.modal', function () {
                $(this).find('#member_key').focus();
            });

            $('#merchantTable').dxDataGrid({
                dataSource: merchants,
                keyExpr: 'ID',
                columnAutoWidth: true,
                hoverStateEnabled: true,
                selection: {
                    mode: "single" // or "multiple" | "none"
                },
                columns: [
                    {
                        dataField: 'MerchantName',
                    },
                    {
                        dataField: 'BussinessType',
                    },
                    {
                        dataField: 'NIB',
                        caption: 'NIB',
                    },
                    {
                        dataField: 'Member',
                        cellTemplate: memberCellTemplate,
                    }
                ],
                showBorders: false,
                showColumnLines: false,
                showRowLines: true,
                activeStateEnabled: true,
            });

            $('#memberTable').dxDataGrid({
                dataSource: members,
                keyExpr: 'ID',
                columnAutoWidth: true,
                hoverStateEnabled: true,
                columns: [
                    {
                        caption: '#',
                        cellTemplate: function(container, options) {
                            container.html(`${options.row.rowIndex + 1}`);
                        }
                    },
                    {
                        dataField: 'MemberName',
                    },
                    {
                        dataField: 'Point',
                    },
                    {
                        dataField: 'Link',
                        caption: '',
                        cellTemplate: function (container, options) {
                            container.html(`
                                <a href="${options.value}" class="btn btn-md btn-primary rounded px-2">
                                   Save
                                </a>
                            `);
                        }
                    }
                ],
                showBorders: false,
                showColumnLines: false,
                showRowLines: true,
            });
        });

        function memberCellTemplate(container, options) {
            container.html(`${options.value} <i class="fas fa-arrow-right ms-1"></i><i class="fas fa-chevron-right ms-5"></i>`);
        }
    </script>
@endsection
