@extends('layouts.main')
@section('meta')

@endsection

@section('css')

@endsection

@section('title', 'Billing')

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

                    <div class="vr"></div>

                    <div class="col p-3 ">
                        <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-offset="0" tabindex="0">
                            <h4 id="item-1">Create Daily Point</h4>
                             <textarea class="form-control rounded-xxl" id="editor-area" cols="50" name="" rows="10"></textarea>
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

    var myCodeMirror = CodeMirror(document.getElementById('editor-area'), {
        mode:  "text",
        theme: "dracula",
        readonly: true,
    });
    myCodeMirror.setSize("100%", "10rem");
</script>
@endsection
