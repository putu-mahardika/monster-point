@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Events')

@section('content')
    <div class="row">
        @if (auth()->user()->is_admin)
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
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('js')
    <script>
        let eventTable = null;
        let merchantTable = null;
        let selectedMerchant = {{ auth()->user()->is_admin ? 0 : auth()->user()->merchant->Id }};
        function deleteEvent(id) {
            Swal.fire({
                title: 'Do you want to delete this event?',
                showCancelButton: true,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: 'Delete this event',
                cancelButtonText: `No!`,
            }).then((result) => {
                if (result.isDenied) {
                    $.ajax({
                        url: `{{ route('events.index') }}/${id}`,
                        type: "DELETE",
                        data: {},
                        success: (res) => {
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            });
                            eventTable.refresh();
                        },
                        error: (error) => {
                            console.log(error);
                        }
                    });
                }
            });
        }

        @if (auth()->user()->is_admin)
            function loadEventByMerchant() {
                $('#btnCreateEvent').attr('href', `{{ route('events.create') }}?m=${selectedMerchant}`);
                eventTable.option('dataSource', `{{ url('dx/events') }}/${selectedMerchant}`);
                eventTable.refresh();
            }
        @endif

        $(document).ready(() => {
            @if (auth()->user()->is_admin)
                merchantTable = $('#merchantTable').dxDataGrid({
                    dataSource: `{{ route('dx.merchants') }}`,
                    keyExpr: 'Id',
                    columnAutoWidth: true,
                    hoverStateEnabled: true,
                    selection: {
                        mode: "single" // or "multiple" | "none"
                    },
                    columns: [
                        {
                            caption: '#',
                            width: 40,
                            cellTemplate: function(container, options) {
                                container.html(`${options.row.rowIndex + 1}`);
                            }
                        },
                        {
                            dataField: 'Nama',
                            caption: 'Name',
                        }
                    ],
                    onSelectionChanged(selectedItems) {
                        selectedMerchant = selectedItems.currentSelectedRowKeys[0].Id;
                        loadEventByMerchant();
                    },
                    showBorders: false,
                    showColumnLines: false,
                    showRowLines: true,
                    activeStateEnabled: true,
                }).dxDataGrid('instance');
            @endif

            eventTable = $('#eventTable').dxDataGrid({
                dataSource: `{{ url('dx/events') }}/${selectedMerchant}`,
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
                    {
                        dataField: 'Kode',
                        caption: 'Code',
                    },
                    {
                        dataField: 'Event',
                        caption: 'Event',
                    },
                    {
                        dataField: 'Formula',
                        caption: 'Formula',
                    },
                    {
                        dataField: 'Daily',
                        caption: 'Daily',
                        cellTemplate: function (container, options) {
                            let html = '';
                            if(options.value == 1) {
                                html += '<span style="color:limegreen"><i class="fas fa-check"></i></span>';
                            } else {
                                html += '<span style="color:red"><i class="fas fa-times"></i></span>';
                            }
                            container.html(html);
                        }
                    },
                    {
                        dataField: 'OnceTime',
                        caption: 'Once',
                        cellTemplate: function (container, options) {
                            let html = '';
                            if(options.value == 1) {
                                html += '<span style="color:limegreen"><i class="fas fa-check"></i></span>';
                            } else {
                                html += '<span style="color:red"><i class="fas fa-times"></i></span>';
                            }
                            container.html(html);
                        }
                    },
                    {
                        dataField: 'LockDelay',
                        dataType: 'number',
                        caption: 'Delay',
                        cellTemplate: function (container, options) {
                            container.html(`
                                ${options.value} min
                            `);
                        }
                    },
                    {
                        dataField: 'Keterangan',
                        caption: 'Description',
                    },
                    {
                        dataField: 'Id',
                        caption: '',
                        cellTemplate: function (container, options) {
                            container.html(`
                                <a href="{{ route('events.index') }}/${options.value}/edit" class="btn btn-primary btn-sm rounded-xxl" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-pencil-alt fa-sm"></i>
                                </a>
                                <button onclick="deleteEvent(${options.value});" class="btn btn-danger btn-sm rounded-xxl" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt fa-sm"></i>
                                </button>
                            `);
                            activateTooltip();
                        }
                    }
                ],
                showBorders: false,
                showColumnLines: false,
                showRowLines: true,
            }).dxDataGrid('instance');
        });
    </script>
@endsection
