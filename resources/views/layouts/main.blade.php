<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="{{ asset('img/logo_ps.png') }}">
        <title>Point Service</title>
        <link href="{{ asset('app.css') }}" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed" style="overflow-x: hidden;">
        @include('partials.topbar')
            <div id="layoutSidenav">
                @include('partials.menu')
                <div id="layoutSidenav_content">
                    <main  style="background-color: var(--ekky-light); min-height: 100vh;">
                        <div class="p-2 ">
                            <div class="row mt-3">
                                @yield('content')
                            </div>
                        </div>
                    </main>
                       <footer class="py-3 mt-auto" style="background-color: ">
                            <div class="container-fluid px-3">
                                <div class="d-flex align-items-center justify-content-center small">
                                    <div class="text-muted">version 1.00.001 &copy; Monster Code 2021</div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>

        <script src="{{ asset('js/app.js') }}"></script>
        @yield('js')

    </body>
</html>
