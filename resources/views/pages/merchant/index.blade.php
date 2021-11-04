@extends('layouts.main')
@section('meta')

@endsection

@section('title', 'Merchants')

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card rounded-xxl">
                <div class="card-body" style="min-height: calc(100vh - 10.3rem);">
                    <div class="row mb-3">
                        <div class="col">
                            <button type="button" class="btn btn-primary rounded-xxl" data-bs-toggle="modal" data-bs-target="#addMerchantModal">
                                Add Merchant <i class="fas fa-plus ms-3"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div id="merchantTable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card rounded-xxl">
                <div class="card-body position-relative" style="min-height: calc(100vh - 10.3rem);">
                    <div class="row justify-content-between mb-3">
                        <div class="col-auto fw-bold">
                            PT. Something Big <i class="fas fa-pencil-alt ms-3"></i>
                        </div>
                        <div class="col-auto">
                            5 <i class="fas fa-user ms-1"></i>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <div id="memberTable"></div>
                        </div>
                    </div>
                    <button class="btn btn-primary rounded-xxl position-absolute" style="bottom: 1rem; right: 1rem;" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        Add Member <i class="fas fa-plus ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    {{-- Add Merchant Modal --}}
    <div class="modal fade" id="addMerchantModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addMerchantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-xxl">
                <div class="modal-header px-4">
                    <h5 class="modal-title" id="addMerchantModalLabel">Add New Merchant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="merchant_name">Merchant Name</label>
                            </div>
                            <div class="col-md-7">
                                <input name="merchant_name" id="merchant_name" type="text" class="form-control rounded-xl" autofocus autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="merchant_address">Address</label>
                            </div>
                            <div class="col-md-7">
                                <input name="merchant_address" id="merchant_address" type="text" class="form-control rounded-xl" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="merchant_pic">Peron in Charge</label>
                            </div>
                            <div class="col-md-7">
                                <input name="merchant_pic" id="merchant_pic" type="text" class="form-control rounded-xl" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="merchant_pic_phone">PIC Phone</label>
                            </div>
                            <div class="col-md-7">
                                <input name="merchant_pic_phone" id="merchant_pic_phone" type="text" class="form-control rounded-xl" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="merchant_pic_email">Email</label>
                            </div>
                            <div class="col-md-7">
                                <input name="merchant_pic_email" id="merchant_pic_email" type="email" class="form-control rounded-xl" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="use_for">Use For</label>
                            </div>
                            <div class="col-md-7">
                                <input name="use_for" id="use_for" type="text" class="form-control rounded-xl" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Merchant Modal --}}
    <div class="modal fade" id="addMemberModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-xxl">
                <div class="modal-header px-4">
                    <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="member_key">Member Key</label>
                            </div>
                            <div class="col-md-7">
                                <input name="member_key" id="member_key" type="text" class="form-control rounded-xl" autofocus autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="member_name">Member Name</label>
                            </div>
                            <div class="col-md-7">
                                <input name="member_name" id="member_name" type="text" class="form-control rounded-xl" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-5">
                                <label for="member_note">Note</label>
                            </div>
                            <div class="col-md-7">
                                <textarea class="form-control rounded-xl" name="member_note" id="member_note" cols="30" rows="3" style="resize: none;"></textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let merchantPicPhone = null;
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
            merchantPicPhone = new Cleave('#merchant_pic_phone', {
                phone: true,
                phoneRegionCode: 'id'
            });

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
                                <a href="${options.value}" class="text-dark text-decoration-none px-2">
                                    <i class="fas fa-ellipsis-v"></i>
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
            container.html(`${options.value} <i class="fas fa-user ms-1"></i><i class="fas fa-chevron-right ms-5"></i>`);
        }
    </script>
@endsection
