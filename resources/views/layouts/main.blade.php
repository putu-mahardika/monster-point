<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        @yield('meta')
        <link rel="icon" href="{{ asset('img/logo_ps.png') }}">
        <title>@yield('title', 'title') | {{ config('app.name') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        @yield('css')
    </head>
    <body class="sb-nav-fixed" style="overflow-x: hidden;">
        @include('partials.topbar')
        <div id="layoutSidenav">
            @include('partials.menu')
            <div id="layoutSidenav_content">
<<<<<<< HEAD
                <main  style="background-color: var(--ekky-light); min-height: calc(100vh - 8.2rem);">
                    <div class="p-3 ">
=======
                <main style="background-color: var(--ekky-light); min-height: calc(100vh - 8.2rem);">
                    <div class="p-3">
>>>>>>> 61903d5d34a722ddee79456302d097c892edde2d
                        @yield('content')
                    </div>
                </main>
                <footer class="py-3 mt-auto">
                    <x-footer-text />
                </footer>
                </div>
            </div>
        </div>

        @yield('modal')

        <script src="{{ asset('js/app.js') }}"></script>
        @yield('js')
    </body>
</html>
