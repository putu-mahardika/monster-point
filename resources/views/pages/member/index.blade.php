@extends('layouts.main')
@section('meta')

@endsection

@section('title', 'Members')

@section('css')

@endsection
@section('content')
    <div class="card rounded-xxl">
        <div class="card-body" style="min-height: calc(100vh - 10.3rem);">
            {{-- <div class="row mb-3">
                <div class="col">
                    <div class="row">
                        <div class="col-auto py-2">
                            Key <i class="fas fa-info-circle" style="color: var(--ekky-cyan);"></i>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <input type="text" name="key" id="key" class="form-control rounded-xl-start border-end-0">
                                <span class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-auto py-2">
                            Starting Point
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <input type="text" name="starting_point" id="starting_point" class="form-control rounded-xl-start border-end-0">
                                <span class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);" type="button">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

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

            eventTable = $('#memberTable').dxDataGrid({
                dataSource: `{{ route('dx.members', auth()->user()->merchant->Id ?? null) }}`,
                keyExpr: 'Id',
                columnAutoWidth: true,
                hoverStateEnabled: true,
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
                    },
                    {
                        dataField: 'Point',
                    },
                    {
                        dataField: 'Keterangan'
                    },
                    {
                        dataField: 'Id',
                        caption: '',
                        cellTemplate: function (container, options) {
                            let html = '';
                            @can('members edit')
                                html += `<button class="btn btn-primary btn-sm rounded-xxl" data-id="${options.value}" data-bs-toggle="tooltip" data-bs-placement="top" id="edit" title="Edit">
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
            }).dxDataGrid('instance');

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
                });
            });
            // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Edit Data >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        });
    </script>
@endsection
