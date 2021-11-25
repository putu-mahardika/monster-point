@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Events')

@section('content')
    <div class="row">
        {{-- @if (auth()->user()->is_admin)
            <div class="col-md-4">
                <div class="card rounded-xxl" style="min-height: calc(100vh - 10.3rem);">
                    <div class="card-body">
                        <div id="merchantTable"></div>
                    </div>
                </div>
            </div>
        @endif
        <div class="{{ auth()->user()->is_admin ? 'col-md-8' : 'col' }}">
            <div class="card rounded-xxl" style="min-height: calc(100vh - 10.3rem);">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <a id="btnCreateEvent" href="{{ auth()->user()->is_admin ? 'javascript:void(0);' : route('events.create') . '?m=' . auth()->user()->merchant->Id }}" class="btn btn-primary rounded-xxl">
                            New Event <i class="fas fa-plus ms-2"></i>
                        </a>
                    </div>
                    <div id="eventTable"></div>
                </div>
            </div>
        </div> --}}
        @if (auth()->user()->is_admin)
            <div class="col">
                <div class="card rounded-xxl" style="min-height: calc(100vh - 10.3rem);">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            {{-- <a id="btnCreateEvent" href="{{ auth()->user()->is_admin ? 'javascript:void(0);' : route('events.create') . '?m=' . auth()->user()->merchant->Id }}" class="btn btn-primary rounded-xxl">
                                New Event <i class="fas fa-plus ms-2"></i>
                            </a> --}}
                            <div class="col">
                                <button type="button" id="createSetting" class="btn btn-primary rounded-xxl" data-bs-toggle="modal" data-bs-target="#addSettingModal">
                                    Add Setting <i class="fas fa-plus ms-3"></i>
                                </button>
                            </div>
                        </div>
                        <div id="settingsTable"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('modal')
    {{-- Add Merchant Modal --}}
    <div class="modal fade modalSetting" id="addSettingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addSettingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-xxl">

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let settingTable = null;
        function deleteData(id) {
            Swal.fire({
                title: 'Do you want to delete this setting?',
                showCancelButton: true,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: 'Delete this setting',
                cancelButtonText: `No!`,
            }).then((result) => {
                if (result.isDenied) {
                    $.ajax({
                        url: `{{ route('settings.index') }}/${id}`,
                        type: "DELETE",
                        data: {},
                        success: (res) => {
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            });
                            settingTable.refresh();
                        },
                        error: (error) => {
                            console.log(error);
                        }
                    });
                }
            });
        }

        $(document).ready(() => {
            @if (auth()->user()->is_admin)
                settingTable = $('#settingsTable').dxDataGrid({
                    dataSource: `{{ route('settings.index') }}`,
                    keyExpr: 'Id',
                    columnAutoWidth: true,
                    hoverStateEnabled: true,
                    selection: {
                        mode: "single" // or "multiple" | "none"
                    },
                    columns: [
                        {
                            caption: 'No',
                            width: 40,
                            cellTemplate: function(container, options) {
                                container.html(`${options.row.rowIndex + 1}`);
                            }
                        },
                        {
                            caption: 'Code',
                            dataField: 'Kode'
                        },
                        {
                            caption: 'Value',
                            dataField: 'Value'
                        },
                        {
                            caption: 'Note',
                            dataField: 'Keterangan'
                        },
                        {
                        dataField: 'Id',
                        caption: '',
                        cellTemplate: function (container, options) {
                            container.html(`
                                <button class="btn btn-primary btn-sm rounded-xxl" data-id="${options.value}" id="editSetting">
                                    <i class="fas fa-edit fa-sm"></i>
                                </button>
                                <button onclick="deleteData(${options.value});" class="btn btn-danger btn-sm rounded-xxl" id="deleteSetting">
                                    <i class="fas fa-trash-alt fa-sm"></i>
                                </button>
                            `);
                        }
                    }
                    ],

                    showBorders: false,
                    showColumnLines: false,
                    showRowLines: true,
                    activeStateEnabled: true,
                }).dxDataGrid('instance');
            @endif


            $(document).on('click', '#createSetting', function () {
                // $('.editorassets').find('form')[0].reset();
                $.get('{{ route("settings.create") }}', function(data) {
                    $('.modalSetting').find('.modal-content').html(data);
                    $('.modalSetting').modal('show');
                    showRedStarRequired();
                });
            });

            $('.modalSetting').on('hidden.bs.modal', function (event) {
                if (submitted) {
                    settingTable.refresh();
                    submitted = false;
                }
            });


            $(document).on('click', '#editSetting', function() {
                let setting_id = $(this).data('id');
                console.log(setting_id);
                $('.modalSetting').find('span.error-text').text('');
                $.get(`{{ route("settings.index") }}/${setting_id}/edit`, function(data) {
                    $('.modalSetting').find('.modal-content').html(data);
                    $('.modalSetting').modal('show');
                    showRedStarRequired();
                });
            });
        });
    </script>
@endsection
