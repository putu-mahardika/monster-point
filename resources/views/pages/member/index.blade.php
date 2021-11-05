@extends('layouts.main')
@section('meta')

@endsection

@section('title', 'Members')

@section('css')

@endsection
@section('content')
    <div class="card rounded-xxl">
        <div class="card-body" style="min-height: calc(100vh - 10.3rem);">
            <div class="row mb-3">
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
            </div>
            <div class="row mb-3">
                <div class="col-auto">
                    <button type="button" class="btn btn-primary rounded-xxl" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        Add Member <i class="fas fa-plus ms-2"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div id="memberTable"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
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
        const members = [
            {
                Key: 1,
                Name: 'John Doe',
                Point: '150',
                Note: 'Proident ea pariatur do magna labore in do dolore.',
                Link: '#'
            },
            {
                Key: 2,
                Name: 'John Doe',
                Point: '150',
                Note: 'Est eiusmod est enim quis ipsum.',
                Link: '#'
            },
            {
                Key: 3,
                Name: 'John Doe',
                Point: '150',
                Note: 'Do consectetur eiusmod non dolor cupidatat proident ea eu sint est fugiat ipsum.',
                Link: '#'
            },
            {
                Key: 4,
                Name: 'John Doe',
                Point: '150',
                Note: 'Sit ad culpa excepteur veniam nisi.',
                Link: '#'
            },
            {
                Key: 5,
                Name: 'John Doe',
                Point: '150',
                Note: 'Esse sint veniam ad id incididunt magna voluptate et culpa.',
                Link: '#'
            }
        ];

        $(document).ready(() => {
            $('#addMemberModal').on('shown.bs.modal', function () {
                $(this).find('#member_key').focus();
            });

            $('#memberTable').dxDataGrid({
                dataSource: members,
                keyExpr: 'Key',
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
                        dataField: 'Name',
                    },
                    {
                        dataField: 'Point',
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
