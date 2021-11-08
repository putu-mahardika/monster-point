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
            <form id="memberForm" action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                <label for="event_code">Code</label>
                            </div>
                            <div class="col-xl-10 col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="text" name="event_code" id="event_code" class="form-control rounded-xl-start border-end-0" autofocus autocomplete="off" required>
                                    <span class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                <label for="event_name">Event</label>
                            </div>
                            <div class="col-xl-10 col-lg-9">
                                <div class="input-group mb-3">
                                    <input type="text" name="event_name" id="event_name" class="form-control rounded-xl-start border-end-0" autocomplete="off" required>
                                    <span class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 py-2">
                                <label for="event_note">Note</label>
                            </div>
                            <div class="col-xl-10 col-lg-9">
                                <textarea name="event_note" id="event_note" class="form-control rounded-xl" cols="30" rows="3" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="event_formula">Formula<span class="text-danger">*</span></label>
                        <div class="border rounded-xl" id="formulaContainer">
                            <span class="d-block text-center py-3">Please Wait...</span>
                        </div>
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
                        <div class="border rounded-xl" id="exampleContainer">
                            <span class="d-block text-center py-3">Please Wait...</span>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-2 mb-2">
                        <div class="d-grid gap-2">
                            <button class="btn btn-dark rounded-xxl">
                                Test
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="d-grid gap-2">
                            <button class="btn btn-secondary rounded-xxl">
                                Close
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-xxl">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Testing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" placeholder="Event Name">
                    <input type="text" class="form-control mb-2" placeholder="Formula" style="height:200px">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Result/Notes</h5>

                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" placeholder="" style="height: 100px">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-md rounded-xl" style="background-color:#CCCCCC; color:white"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let eventFormula = null;
        let eventExample = null;

        function loadFormula(search = '') {
            let list = '';
            let index = 0;
            formulas.forEach(formula => {
                if (search.length > 0) {
                    if (formula.name.indexOf(search.toUpperCase()) >= 0) {
                        list += `<li data-index="${index}" class="list-group-item">${formula.name}</li>`;
                    }
                }
                else {
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
            $('#formulaContainer').html(`<textarea name="event_formula" id="event_formula" cols="30" rows="3" required></textarea>`);
            eventFormula = CodeMirror.fromTextArea(document.getElementById('event_formula'), {
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

            $('#searchFormula').on('keyup', function () {
                loadFormula(
                    $(this).val()
                );
            });
        });
    </script>
@endsection
