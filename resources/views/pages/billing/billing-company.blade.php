@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Detail Billing')

@section('content')

<div class="col-md-12">
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




<!-- Modal -->
<div class="modal fade rounded-xxl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                const members = [
            {
                ID: 1,
                MemberName: 'John Doe',
                Month: 'Desember',
                Clicks: '1550',
                Bill: 'Rp 1.550.000',
                Date_Paid: '21 December 2021'
            },

            {
                ID: 1,
                MemberName: 'John Doe',
                Month: 'Desember',
                Clicks: '1550',
                Bill: 'Rp 1.550.000',
                Date_Paid: '21 December 2021'
            },

            {
                ID: 1,
                MemberName: 'John Doe',
                Month: 'Desember',
                Clicks: '1550',
                Bill: 'Rp 1.550.000',
                Date_Paid: '21 December 2021'
            },

            {
                ID: 1,
                MemberName: 'John Doe',
                Month: 'Desember',
                Clicks: '1550',
                Bill: 'Rp 1.550.000',
                Date_Paid: '21 December 2021'
            },

            {
                ID: 1,
                MemberName: 'John Doe',
                Month: 'Desember',
                Clicks: '1550',
                Bill: 'Rp 1.550.000',
                Date_Paid: '21 December 2021'
            },

            {
                ID: 1,
                MemberName: 'John Doe',
                Month: 'Desember',
                Clicks: '1550',
                Bill: 'Rp 1.550.000',
                Date_Paid: '21 December 2021'
            },

        ];
        $(document).ready(() => {
            $('#addMerchantModal').on('shown.bs.modal', function () {
                $(this).find('#merchant_name').focus();
            });

            $('#addMemberModal').on('shown.bs.modal', function () {
                $(this).find('#member_key').focus();
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
                        dataField: 'Month',
                    },
                    {
                        dataField: 'Clicks',
                    },
                    {
                        dataField: 'Bill',
                    },
                    {
                        dataField: 'Date_Paid',
                    },
                    {
                        dataField: 'Link',
                        caption: '',
                        cellTemplate: function (container, options) {
                            container.html(`
                                <a href="${options.value}" type="submit" class="btn btn-sm btn-primary rounded-xl px-2">
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
            container.html(`${options.value}<i class="fas fa-chevron-right ms-5"></i>`);
        }
    </script>
@endsection
