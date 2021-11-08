@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Events')

@section('content')
    <div class="card rounded-xxl">
        <div class="card-body" style="min-height: calc(100vh - 10.3rem);">
            <div class="d-flex mb-3">
                <a href="#" class="btn btn-primary rounded-xxl">
                    New Event <i class="fas fa-plus ms-2"></i>
                </a>
            </div>

            <div class="row">
                <div class="col">
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
        const events = [
            {
                Code: 'AAA',
                Event: 'Event 1',
                Formula: 'formula.buy.point.something<somecodeoverhere?>',
                Type: 'Daily',
                DelayLock: 'Yes',
                Note: 'Dolore anim adipisicing in consequat est.',
                Link: '#'
            },
            {
                Code: 'AAB',
                Event: 'Event 2',
                Formula: 'formula.buy.point.something<somecodeoverhere?>',
                Type: 'Daily',
                DelayLock: 'Yes',
                Note: 'Dolore anim adipisicing in consequat est.',
                Link: '#'
            },
            {
                Code: 'AAC',
                Event: 'Event 3',
                Formula: 'formula.buy.point.something<somecodeoverhere?>',
                Type: 'Daily',
                DelayLock: 'Yes',
                Note: 'Dolore anim adipisicing in consequat est.',
                Link: '#'
            },
            {
                Code: 'ABA',
                Event: 'Event 4',
                Formula: 'formula.buy.point.something<somecodeoverhere?>',
                Type: 'Daily',
                DelayLock: 'Yes',
                Note: 'Dolore anim adipisicing in consequat est.',
                Link: '#'
            },
            {
                Code: 'ABB',
                Event: 'Event 5',
                Formula: 'formula.buy.point.something<somecodeoverhere?>',
                Type: 'Daily',
                DelayLock: 'Yes',
                Note: 'Dolore anim adipisicing in consequat est.',
                Link: '#'
            },
            {
                Code: 'ABC',
                Event: 'Event 6',
                Formula: 'formula.buy.point.something<somecodeoverhere?>',
                Type: 'Daily',
                DelayLock: 'Yes',
                Note: 'Dolore anim adipisicing in consequat est.',
                Link: '#'
            },
        ];

        $(document).ready(() => {
            $('#addEventModal').on('shown.bs.modal', function () {
                $(this).find('#member_key').focus();
            });

            $('#eventTable').dxDataGrid({
                dataSource: events,
                keyExpr: 'Code',
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
                        dataField: 'Code',
                    },
                    {
                        dataField: 'Event',
                    },
                    {
                        dataField: 'Formula'
                    },
                    {
                        dataField: 'Type',
                        caption: 'Daily/Once'
                    },
                    {
                        dataField: 'DelayLock'
                    },
                    {
                        dataField: 'Note'
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
    </script>
@endsection
