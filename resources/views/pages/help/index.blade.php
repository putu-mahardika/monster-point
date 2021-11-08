@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Help')

@section('content')
<div class="row">
    <div class="col-auto">
        <div class="card mb-4 rounded-xxl">
            <div class="card-body">
                <div class="row mt-2 ">
                    <nav id="navbar-example3" class="navbar navbar-light flex-column align-items-stretch p-3">
                        <a class="navbar-brand" href="#">Navbar</a>
                        <nav class="nav nav-pills flex-column">
                            <a class="nav-link" href="#item-1">Item 1</a>
                                <nav class="nav nav-pills flex-column">
                                    <a class="nav-link ms-3 my-1" href="#item-1-1">Item 1-1</a>
                                    <a class="nav-link ms-3 my-1" href="#item-1-2">Item 1-2</a>
                                </nav>
                            <a class="nav-link" href="#item-2">Item 2</a>
                            <a class="nav-link" href="#item-3">Item 3</a>
                                <nav class="nav nav-pills flex-column">
                                    <a class="nav-link ms-3 my-1" href="#item-3-1">Item 3-1</a>
                                    <a class="nav-link ms-3 my-1" href="#item-3-2">Item 3-2</a>
                                </nav>
                        </nav>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10">
        <div class="card mb-4 rounded-xxl">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col p-3">
                        <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-offset="0" tabindex="0">
                            <h4 id="item-1">Item 1</h4>
                            <p>...</p>
                            <h5 id="item-1-1">Item 1-1</h5>
                            <p>...</p>
                            <h5 id="item-1-2">Item 1-2</h5>
                            <p>...</p>
                            <h4 id="item-2">Item 2</h4>
                            <p>...</p>
                            <h4 id="item-3">Item 3</h4>
                            <p>...</p>
                            <h5 id="item-3-1">Item 3-1</h5>
                            <p>...</p>
                            <h5 id="item-3-2">Item 3-2</h5>
                            <p>...</p>
                        </div>
                    </div>

                    <div class="col p-3 border-start">
                        <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-offset="0" tabindex="0">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="border rounded-xl" id="formulaContainer">
                                        <span class="d-block text-center py-3">Please Wait...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
     $(document).ready(() => {
            $('#formulaContainer').html(`<textarea name="event_formula" id="event_formula" cols="30" rows="3"></textarea>`);
            eventFormula = CodeMirror.fromTextArea(document.getElementById('event_formula'), {
                lineNumbers: true,
                mode: "sql",
                theme: "dracula"
            });
            eventFormula.setSize('100%', '10rem');

        });

</script>
@endsection
