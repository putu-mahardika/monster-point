@extends('layouts.main')
@section('meta')

@endsection

@section('title', 'Members')

@section('css')

@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card rounded-xxl auto-align">
                <div class="card-body" style="min-height: calc(100vh - 10.3rem);">

                    @can('members create')
                        <div class="row mb-3">
                            <div class="col-auto">
                                <button type="button" id="create" class="btn btn-primary rounded-xxl" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                    Add Member <i class="fas fa-plus ms-2"></i>
                                </button>
                            </div>
                        </div>
                    @endcan

                    <div class="row">
                        <div class="col">
                            <div id="memberTable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card rounded-xxl auto-align">
                <div class="card-body position-relative" style="min-height: calc(100vh - 10.3rem);">
                    <div class="row justify-content-between mb-3">
                        <div class="col-auto fw-bold">
                            <span id="record-name">Records</span>
                        </div>
                        <div class="col-auto">
                            <span id="total-record">0</span> <i class="fas fa-user ms-1"></i>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <div id="pointTable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    {{-- Add Member Modal --}}
    <div class="modal fade modalMember" id="addMemberModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-xxl">

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let submitted = false;
        let eventTable = null;

        function deleteMember(id) {
            Swal.fire({
                title: 'Do you want to delete this member?',
                showCancelButton: true,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: 'Delete this Member',
                cancelButtonText: `No!`,
            }).then((result) => {
                if (result.isDenied) {
                    $.ajax({
                        url: `{{ route('members.index') }}/${id}`,
                        type: "DELETE",
                        data: {},
                        success: (res) => {
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            });
                            // return getDataMember();
                            eventTable.refresh();
                        },
                        error: (error) => {
                            console.log(error);
                        }
                    });
                }
            });
        }

        $(document).ready(() => {
            $('#addMemberModal').on('shown.bs.modal', function () {
                $(this).find('#member_key').focus();
            });

            getHistoryPoint();

            // ==============================>>>> Get Data Member <<<<=============================

            eventTable = $('#memberTable').dxDataGrid({
                dataSource: `{{ route('dx.members', auth()->user()->hasMerchant->Id ?? null) }}`,
                keyExpr: 'Id',
                columnAutoWidth: true,
                hoverStateEnabled: true,
                selection: {
                    mode: "single" // or "multiple" | "none"
                },
                columns: [
                    {
                        caption: '#',
                        cellTemplate: function(container, options) {
                            container.html(`${options.row.rowIndex + 1}`);
                        }
                    },
                    @if (auth()->user()->is_admin)
                        {
                            dataField: 'merchant.Nama',
                            caption: 'Merchant'
                        },
                    @endif
                    {
                        dataField: 'MerchentMemberKey',
                        caption: 'Key'
                    },
                    {
                        dataField: 'Nama',
                        caption: 'Name',
                    },
                    {
                        dataField: 'Point',
                        caption: 'Point',
                    },
                    {
                        dataField: 'Keterangan',
                        caption: 'Description'
                    },
                    {
                        dataField: 'Id',
                        caption: '',
                        cssClass: 'actionField',
                        cellTemplate: function (container, options) {
                            let html = '';
                            @can('members edit')
                                html += `<button class="btn btn-primary btn-sm rounded-xxl me-1" data-id="${options.value}" data-bs-toggle="tooltip" data-bs-placement="top" id="edit" title="Edit">
                                    <i class="fas fa-edit fa-sm"></i>
                                </button>`;
                            @endcan
                            @can('members delete')
                                html += `<button onclick="deleteMember(${options.value});" class="btn btn-danger btn-sm rounded-xxl" data-bs-toggle="tooltip" data-bs-placement="top" id="delete" title="Delete">
                                    <i class="fas fa-trash-alt fa-sm"></i>
                                </button>`;
                            @endcan
                            container.html(html);
                            activateTooltip();
                        }
                    }
                ],
                showBorders: false,
                showColumnLines: false,
                showRowLines: true,
                activeStateEnabled: true,
                onSelectionChanged(selectedItems) {
                    const data = selectedItems.selectedRowsData[0];
                    if (data) {
                        console.log(data.MerchentMemberKey);
                        console.log(data.merchant.Token);
                        let merchantMemberKey = data.MerchentMemberKey;
                        let merchantToken = data.merchant.Token;
                        getHistoryPoint(merchantToken, merchantMemberKey);
                        getCountHistoryPoints(merchantToken, merchantMemberKey);
                    }
                },
            }).dxDataGrid('instance');

            // ==============================>>>> Get Data Member <<<<=============================

            // ==============================>>>> Get History Point Member <<<<=============================
            function getHistoryPoint(token = '', id = ''){
                memberTable = $('#pointTable').dxDataGrid({
                    dataSource: `{{ url('members/getHistoryPoints') }}?token=${token}&id=${id}`,
                    paging: {
                        pageSize: 10
                    },
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
                            dataField: 'CreateDate',
                            dataType: 'datetime',
                            format: "dd-MM-yyyy HH:mm:ss",
                            caption: 'Date'
                        },
                        {
                            dataField: 'Point',
                            dataType: 'number',
                            caption: 'Point',
                        },
                    ],
                    showBorders: false,
                    showColumnLines: false,
                    showRowLines: true,
                }).dxDataGrid('instance');
            }

            // ==============================>>>> Get History Point Member <<<<=============================

            // ====================================>>>> Get Count Data Member <<<<====================================

            function getCountHistoryPoints(token = '', id = '') {
                $.get(`{{ url('members/getCountHistoryPoints') }}?token=${token}&id=${id}`, function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    document.getElementById('total-record').innerText = data;
                });
            }
            // ====================================>>>> Get Count Data Member <<<<====================================




            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Call modal Create Data >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('click', '#create', function () {
                // $('.editorassets').find('form')[0].reset();
                $.get('{{ route("members.create") }}', function(data) {
                    $('.modalMember').find('.modal-content').html(data);
                    $('.modalMember').modal('show');
                    showRedStarRequired();
                });
            });

            $('.modalMember').on('hidden.bs.modal', function (event) {
                console.log('cek');
                if (submitted) {
                    eventTable.refresh();
                    submitted = false;
                }
            });
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Call modal Create Data >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Edit Data >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('click', '#edit', function() {
                let member_id = $(this).data('id');
                console.log(member_id);
                $('.modalMember').find('span.error-text').text('');
                $.get(`{{ route("members.index") }}/${member_id}/edit`, function(data) {
                    $('.modalMember').find('.modal-content').html(data);
                    $('.modalMember').modal('show');
                    showRedStarRequired();
                });
            });
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Edit Data >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        });
    </script>
@endsection
