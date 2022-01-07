@extends('layouts.main')
@section('meta')

@endsection

@section('css')
    <style>
        ul#formulaList li:hover {
            background-color: var(--ekky-light-gray);
            cursor: pointer;
        }

        ul#formulaList li:active {
            background-color: var(--ekky-light-cyan);
            cursor: pointer;
        }

        ul#formulaList li.is-active {
            background-color: var(--ekky-light-cyan);
            cursor: pointer;
        }
    </style>
@endsection

@section('title', 'Event Detail')

@section('content')
    <div class="card rounded-xxl">
        <div class="card-body" style="min-height: calc(100vh - 10.3rem);">
            @if (request()->route()->getName() == 'events.create')
                <form id="eventForm" action="{{ route('events.store') }}" method="POST">
            @elseif (request()->route()->getName() == 'events.edit')
                <form id="eventForm" action="{{ route('events.update', $event->Id) }}" method="POST">
                    @method('put')
            @endif
                @csrf
                <input type="hidden" name="merchant_id" value="{{ request()->m }}">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                <label for="code">Code</label>
                            </div>
                            <div class="col-xl-10 col-lg-9 mb-3">
                                <input type="text" name="code" id="code" class="form-control rounded-xl" autofocus autocomplete="off" required value="{{ old('code', $event->Kode ?? '') }}">
                                <x-error-message-field for="code" class="d-none"></x-error-message-field>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                <label for="name">Event</label>
                            </div>
                            <div class="col-xl-10 col-lg-9 mb-3">
                                <input type="text" name="name" id="name" class="form-control rounded-xl" autocomplete="off" required value="{{ old('name', $event->Event ?? '') }}">
                                <x-error-message-field for="name" class="d-none"></x-error-message-field>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                <label for="note">Note</label>
                            </div>
                            <div class="col-xl-10 col-lg-9">
                                <textarea name="note" id="note" class="form-control rounded-xl" cols="30" rows="3" style="resize: none;">{{ old('note', $event->Keterangan ?? '') }}</textarea>
                                <x-error-message-field for="note" class="d-none"></x-error-message-field>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                <label for="action">Action</label>
                            </div>
                            <div class="col-xl-10 col-lg-9 mb-3">
                                <div class="input-group">
                                    <select name="action" id="action" class="form-select rounded-xl-start" required>
                                        <option value="none">None</option>
                                        <option value="daily" @if(in_array(old('action', $event->Daily ?? false), ['daily', true])) selected @endif>Daily</option>
                                        <option value="oncetime" @if(in_array(old('action', $event->OnceTime ?? false), ['oncetime', true])) selected @endif>Once Time</option>
                                    </select>
                                    <button type="button" class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);" data-bs-toggle="modal" data-bs-target="#modalActionFieldInfo">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                                <x-error-message-field for="action" class="d-none"></x-error-message-field>
                            </div>
                        </div>
                    </div>

                    @if (request()->route()->getName() == 'events.edit')
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-xl-2 col-lg-3">
                                    <label for="switchAktif">Active</label>
                                </div>
                                <div class="col-xl-10 col-lg-9 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="switchAktif" name="switchAktif" {{ old('switchAktif', $event->Aktif ? 'checked' : '') }} style="height: 1.5rem; width: 3rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="formula">Formula<span class="text-danger">*</span></label>
                        <div class="border rounded-xl" id="formulaContainer">
                            <span class="d-block text-center py-3">Please Wait...</span>
                        </div>
                        <x-error-message-field for="formula" class="d-none"></x-error-message-field>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-2">
                            <input type="text" name="searchFormula" id="searchFormula" class="form-control rounded-xl-start border-end-0" autocomplete="off" placeholder="Find the formula...">
                            <span class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <div class="border rounded-xl" style="max-height: 10rem; overflow-y: auto;">
                            <ul id="formulaList" class="mb-3 list-group list-group-flush small">
                                <li class="list-group-item">
                                    Please Wait...
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="exampleContainer">Example</label>
                        <div class="border rounded-xl" id="exampleContainer">
                            <span class="d-block text-center py-3">Please Wait...</span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row justify-content-end">
                @if (request()->route()->getName() == 'events.edit')
                    <div class="col-md-2 mb-2">
                        <div class="d-grid gap-2">
                            <button id="btnTest" type="button" class="btn btn-dark rounded-xxl" data-bs-toggle="modal" data-bs-target="#modalFormulaTester">
                                Test
                            </button>
                        </div>
                    </div>
                @endif
                <div class="col-md-2 mb-2">
                    <div class="d-grid gap-2">
                        <button id="btnClose" type="button" class="btn btn-secondary rounded-xxl" onclick="location.href='{{ route('events.index') }}'">
                            Close
                        </button>
                    </div>
                </div>

                @if (auth()->user()->can('events create') || auth()->user()->can('events edit'))
                    <div class="col-md-2 mb-2">
                        <div class="d-grid gap-2">
                            <button id="btnSave" type="submit" form="eventForm" class="btn btn-primary rounded-xxl">
                                Save
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modalActionFieldInfo" tabindex="-1" aria-labelledby="modalActionFieldInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-xxl ms-2">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalActionFieldInfoLabel">Action Field</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p> <small> The "Action" column is input to determine whether the event that is created requires checking the member transaction data</small></p>
                    <p> <small> There are 3 options to choose from. i.e. <b> "None", "Daily", dan "Once Time"</b></small></p>
                    <p> <small>
                        <h4 style="fw-bolder">None</h4>
                        <p> <small> Events that are created do not require checking member transactions to get points.</small></p>
                        <p> <small> Points will be added to members (according to the formula) right after the event runs.</small></p>
                    </small></p>
                    <p> <small>
                        <h4 style="fw-bolder">Daily</h4>
                        <p> <small> Events that are created require checking member transactions to get points.</small></p>
                        <p> <small> Our system will ensure that events with this action can only be run once a day for each member.</small></p>
                    </small></p>
                    <p> <small>
                        <h4 style="fw-bolder">Once Time</h4>
                        <p> <small>Events that are created require checking member transactions to get points.</small></p>
                        <p> <small> Our system will ensure that the event with this action can only be run once (once) since the member has been registered.</p>
                    </p>
                </div>
                {{-- <div class="modal-body">
                    <p>"Action" field adalah inputan untuk menentukan apakah event yang dibuat membutuhkan pengecekan terhadap data transaksi member</p>
                    <p>Terdapat 3 opsi yang dapat dipilih. yaitu "None", "Daily", dan "Once Time"</p>
                    <p>
                        <h4 style="fw-bolder">None</h5>
                        <p>Event yang dibuat tidak memerlukan pengecekan transaksi member untuk kemudian mendapatkan poin.</p>
                        <p>Poin akan ditambahkan pada member (sesuai formula yang dibuat) tepat setelah event dijalankan.</p>
                    </p>
                    <p>
                        <h5 style="fw-bolder">Daily</h5>
                        <p>Event yang dibuat memerlukan pengecekan transaksi member untuk kemudian mendapatkan poin.</p>
                        <p>Sistem kami akan memastikan event dengan action ini hanya bisa dijalankan 1x (satu kali) sehari untuk tiap member.</p>
                    </p>
                    <p>
                        <h5 style="fw-bolder">Once Time</h5>
                        <p>Event yang dibuat memerlukan pengecekan transaksi member untuk kemudian mendapatkan poin.</p>
                        <p>Sistem kami akan memastikan event dengan action ini hanya bisa dijalankan 1x (satu kali) sejak member terdaftar.</p>
                    </p>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-xxl" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRateLimiterFieldInfo" tabindex="-1" aria-labelledby="modalRateLimiterFieldInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-xxl">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRateLimiterFieldInfoLabel">Rate Limiter Field</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>The "Rate Limiter" field is an input to control the number of requests for an event within a certain time range.</p>
                    <p>This can be used to prevent DoS, and requests from accumulating.</p>
                    <p>This field uses seconds. input the 0 (Zero) for unlimited uses.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-xxl" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if (request()->route()->getName() == 'events.edit')
        <div class="modal fade" id="modalFormulaTester" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFormulaTesterLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content rounded-xxl">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFormulaTesterLabel">Formula Tester</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <input type="text" class="form-control rounded-xl" placeholder="Event Name">
                        </div>
                        <div class="mb-2 border rounded-xl" id="formulaTesterContainer">
                            <span class="d-block text-center py-3">Please Wait...</span>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div id="resultTest" class="border rounded-xxl p-3 d-flex justify-content-center">
                                    <div id="loadingTest" class="spinner-border text-info" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-xxl" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <script>
        let eventFormula = null;
        let eventExample = null;
        let eventTester = null;
        let logs = null;

        function loadFormula(search = '') {
            let list = '';
            let index = 0;
            // console.log(formulas);
            formulas.forEach(formula => {       // array formulas get dari resource->js->monster-point->formulas.js
                if (search.length > 0) {
                    if (formula.name.indexOf(search.replace(/(^|\s)\S/g, l => l.toUpperCase())) >= 0) {
                        list += `<li data-index="${index}" class="list-group-item">${formula.name}</li>`;
                    }
                } else {
                    list += `<li data-index="${index}" class="list-group-item">${formula.name}</li>`;
                }
                index++;
            });
            $('#formulaList').html(list);

            $('ul#formulaList li').on('click', function () {
                let index = $(this).data('index');
                $('ul#formulaList li').each((index, element) => {
                    $(element).removeClass('is-active');
                });
                $(this).addClass('is-active');
                eventExample.setValue(formulas[index].example);
            });

            $('ul#formulaList li').on('dblclick', function () {
                let index = $(this).data('index');
                eventFormula.setValue(
                    eventFormula.getValue() + formulas[index].expression
                );
                eventFormula.focus();
            });
        }

        $(document).ready(() => {
            $('#formulaContainer').html(`<textarea name="formula" id="formula" cols="30" rows="3"></textarea>`);
            @if(request()->route()->getName() == 'events.edit')
                $('#formulaContainer').html(`<textarea name="formula" id="formula" cols="30" rows="3">{{ $event->Formula }}</textarea>`);
            @endif
            eventFormula = CodeMirror.fromTextArea(document.getElementById('formula'), {
                lineNumbers: true,
                mode: 'text/monsterpoint',
            });
            eventFormula.setSize('100%', '10rem');
            eventFormula.on('focus', () => {
                $('#formulaContainer').attr('style', 'box-shadow: var(--ekky-box-shadow-cyan);');
            });
            eventFormula.on('blur', () => {
                $('#formulaContainer').attr('style', '');
            });

            $('#exampleContainer').html(`<textarea name="example" id="example" cols="30" rows="3"></textarea>`);
            eventExample = CodeMirror.fromTextArea(document.getElementById('example'), {
                lineNumbers: true,
                mode: 'text/monsterpoint',
                readOnly: 'nocursor',
            });
            eventExample.setSize('100%', '10rem');
            loadFormula();

            $('#searchFormula').keyup(function () {
                loadFormula(
                    $(this).val()
                );
            })

            @if (auth()->user()->can('events create') || auth()->user()->can('events edit'))
                $('#eventForm').on('submit', function (e) {
                    e.preventDefault();
                    $(this).addClass('disabled-container');
                    $('#btnSave').html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving
                    `);
                    $('#btnTest').addClass('disabled');
                    $('#btnClose').addClass('disabled');
                    $('#btnSave').addClass('disabled');
                    clearErrorField();

                    $.ajax({
                        url: $(this).attr('action'),
                        @if(auth()->user()->can('events create') && request()->route()->getName() == 'events.create')
                            type: "POST",
                        @elseif(auth()->user()->can('events edit') && request()->route()->getName() == 'events.edit')
                            type: "PUT",
                        @endif
                        data: $(this).serialize(),
                        success: (res) => {
                            Swal.fire({
                                allowOutsideClick: false,
                                icon: 'success',
                                title: 'Success!',
                                text: res.message,
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = res.url;
                                }
                            });
                        },
                        error: (error) => {
                            if (error.status == 403) {
                                Toast.fire({
                                    icon: 'error',
                                    title: error.responseJSON.msg
                                });
                            }
                            else {
                                showErrorField(error.responseJSON);
                            }

                            $('html, body').animate({
                                scrollTop: 0
                            });
                            $(this).removeClass('disabled-container');
                            $('#btnSave').html(`
                                Save
                            `);
                            $('#btnTest').removeClass('disabled');
                            $('#btnClose').removeClass('disabled');
                            $('#btnSave').removeClass('disabled');
                        }
                    });
                });
            @endif



            @if(request()->route()->getName() == 'events.edit')
                $('#modalFormulaTester').on('show.bs.modal', function (e) {
                    $('#formulaTesterContainer').html(`<textarea name="tester" id="tester" cols="30" rows="3">{{ $event->Formula }}</textarea>`);
                    eventTester = CodeMirror.fromTextArea(document.getElementById('tester'), {
                        lineNumbers: true,
                        autoRefresh: true,
                        mode: 'text/monsterpoint',
                        readOnly: 'nocursor',
                    });
                    eventTester.setSize('100%', '10rem');
                });

                $('#modalFormulaTester').on('shown.bs.modal', function (e) {
                    eventTester.refresh();
                    $.ajax({
                        url: "{{ route('event-test', $event->Id) }}",
                        type: "POST",
                        data: {
                            event_id: {{ $event->Id }}
                        },
                        success: (res) => {
                            new JsonViewer({
                                container: document.querySelector('#resultTest'),
                                data: JSON.stringify(res[0]),
                                theme: 'light',
                                expand: true
                            });
                            $('#loadingTest').addClass('d-none');
                        },
                        error: (error) => {
                            $('#resultTest').html(`
                                    <span class="text-danger">${error.responseJSON.message}</span>
                                `);
                        }
                    });
                });
                eventTester.setSize('100%', '10rem');

                $('#modalFormulaTester').on('shown.bs.modal', function (e) {
                    eventTester.refresh();
                });

                $('#modalFormulaTester').on('hidden.bs.modal', function (e) {
                    $('#resultTest').html('');

                });
            @endif
        });
    </script>
@endsection
